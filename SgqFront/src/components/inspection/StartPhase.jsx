// src/components/inspection/StartPhase.jsx (Estilizado e Corrigido)
import React, { useState, useEffect } from 'react';
import InspectionService from '../../services/InspectionService';
import { useAuth } from '../../context/AuthContext';

const StartPhase = ({ onComplete, user, inspectionData }) => {
    // ... (Lógica e States mantidos)
    const [items, setItems] = useState([]);
    const [selectedItemId, setSelectedItemId] = useState(null);
    const [loading, setLoading] = useState(true);
    const [fetchError, setFetchError] = useState(null);

    const { user: authUser } = useAuth();
    const currentUserId = user?.id || authUser?.id;

    // 1. Fetch ItemMasters na montagem
    useEffect(() => {
        const fetchItems = async () => {
            setLoading(true);
            try {
                // Chama a função corrigida que agora trata corretamente a paginação
                const masters = await InspectionService.getAllItemMasters();
                
                // Debug log para confirmar se os dados estão chegando
                console.log("Itens Mestre Recebidos:", masters); 
                
                setItems(masters);
                
            } catch (err) {
                // O erro de fetch agora pega o erro do InspectionService (incluindo erro de parsing)
                setFetchError("Falha ao carregar lista de itens mestre. Verifique o console e a rota /item-master/index.json");
                console.error(err);
            } finally {
                setLoading(false);
            }
        };
        fetchItems();
    }, []);

    const handleStart = async () => {
        if (!selectedItemId || loading || !currentUserId) return;

        setLoading(true);
        setFetchError(null);

        const selectedItem = items.find(i => i.id === selectedItemId);
        if (!selectedItem) return;

        try {
            const inspectionDataPayload = {
                item_master_id: selectedItem.id,
                inspector_id: currentUserId,
                status: 'EM_ANDAMENTO',
                checklist_template_id: selectedItem.checklist_id || 'DEFAULT_TEMPLATE_ID',
            };

            const newInspectionResponse = await InspectionService.createInspection(inspectionDataPayload);
            
            // 🚨 CORREÇÃO APLICADA: Busca o ID no objeto retornado da API
            // Tenta newInspectionResponse.inspection.id (se a API empacotar)
            // Tenta newInspectionResponse.id (se a API retornar a entidade direta)
            const createdInspectionId = newInspectionResponse.inspection?.id || newInspectionResponse.id;

            if (!createdInspectionId) {
                throw new Error("ID da nova inspeção não foi retornado pela API.");
            }

            onComplete({
                itemMasterId: selectedItem.id,
                checklistTemplateId: inspectionDataPayload.checklist_template_id,
                inspectionId: createdInspectionId,
            });

        } catch (error) {
            setFetchError(`Erro ao iniciar inspeção: ${error.message}`);
            console.error(error);
        } finally {
            setLoading(false);
        }
    };

    if (loading) return <div className="text-gray-400">Carregando Itens Mestre...</div>;
    if (fetchError) return <div className="p-3 text-sm text-red-400 bg-red-900/30 border border-red-800 rounded-lg">{fetchError}</div>;

    return (
        <div className="start-phase space-y-6">
            <h2 className="text-xl font-semibold text-white">1. Seleção do Item de Inspeção</h2>
            {/* 🚨 Estilo do Select (Input escuro com borda vermelha no foco) */}
            <select
                onChange={(e) => setSelectedItemId(e.target.value)}
                value={selectedItemId || ''}
                className="w-full p-3 text-base bg-gray-900 text-white border border-gray-700 rounded-lg focus:ring-1 focus:ring-red-500 focus:border-red-500 transition-all appearance-none"
            >
                <option value="" disabled className="text-gray-500">
                    Selecione o Produto/Peça ({items.length} disponíveis)
                </option>
                {items.length > 0 ? (
                    items.map(item => (
                        <option key={item.id} value={item.id} className="bg-gray-900 text-white">
                            {/* 🚨 CORREÇÃO DE EXIBIÇÃO: Garante o acesso aos campos da entidade */}
                            {item.codigo_item} - {item.titulo || 'Sem Título'} (ID: {item.id})
                        </option>
                    ))
                ) : (
                    <option disabled className="text-gray-500">Nenhum item mestre encontrado.</option>
                )}
            </select>

            {/* 🚨 Estilo do Botão (Botão vermelho da tela de login) */}
            <button
                onClick={handleStart}
                disabled={!selectedItemId || loading}
                className="w-full flex justify-center items-center px-4 py-3 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-red-600 hover:bg-red-700 disabled:bg-red-900 disabled:opacity-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-300"
            >
                {loading ? (
                    <>
                        <div className="w-4 h-4 border-2 border-white border-t-red-200 rounded-full animate-spin mr-2"></div>
                        Criando Inspeção...
                    </>
                ) : (
                    'Iniciar Inspeção (Próxima Fase)'
                )}
            </button>
        </div>
    );
};

export default StartPhase;