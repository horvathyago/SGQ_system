// src/components/inspection/StartPhase.jsx
import React, { useEffect, useState } from 'react';
import InspectionService from '../../services/InspectionService';

const StartPhase = ({ onComplete, user, inspectionData }) => {
    const [loading, setLoading] = useState(false);
    const [loadingLists, setLoadingLists] = useState(true);
    const [error, setError] = useState(null);

    const [templates, setTemplates] = useState([]);
    const [itemMasters, setItemMasters] = useState([]);

    const [selectedTemplate, setSelectedTemplate] = useState(inspectionData.checklistTemplateId || '');
    const [selectedMaster, setSelectedMaster] = useState(inspectionData.itemMasterId || '');

    useEffect(() => {
        const loadInitialData = async () => {
            setLoadingLists(true);
            try {
                const [tmplData, masterData] = await Promise.all([
                    InspectionService.getAllChecklistTemplates(),
                    InspectionService.getAllItemMasters()
                ]);
                setTemplates(tmplData);
                setItemMasters(masterData);
            } catch (err) {
                console.error("Erro ao carregar listas iniciais:", err);
                setError("Não foi possível carregar os modelos de checklist. Verifique a API.");
            } finally {
                setLoadingLists(false);
            }
        };
        loadInitialData();
    }, []);

    const handleStart = async () => {
        if (!selectedTemplate) return;

        setLoading(true);
        setError(null);
        try {
            // Cria a inspeção no backend para gerar o ID
            const newInspection = await InspectionService.createInspection({
                checklist_template_id: selectedTemplate,
                item_master_id: selectedMaster || null,
                inspector_id: user?.id,
                status: 'EM_ANDAMENTO',
                origem: 'REACT_APP'
            });

            // Passa os dados para o gerenciador de estado
            onComplete({
                inspectionId: newInspection.id,
                checklistTemplateId: selectedTemplate,
                itemMasterId: selectedMaster
            });
        } catch (err) {
            console.error(err);
            setError("Erro crítico ao criar registro de inspeção. Tente novamente.");
        } finally {
            setLoading(false);
        }
    };

    if (loadingLists) return <div className="text-gray-400 p-4">Carregando configurações...</div>;

    return (
        <div className="bg-gray-800 p-6 rounded-lg border border-gray-700 space-y-6">
            <div className="border-b border-gray-600 pb-4">
                <h2 className="text-2xl font-bold text-white">Configuração da Inspeção</h2>
                <p className="text-gray-400 text-sm mt-1">Selecione o modelo e o item para iniciar o processo.</p>
            </div>

            {error && (
                <div className="bg-red-900/50 text-red-200 p-3 rounded border border-red-700">
                    {error}
                </div>
            )}

            <div className="space-y-4">
                <div>
                    <label className="block text-gray-300 mb-2 font-medium">Checklist Template *</label>
                    <select 
                        className="w-full bg-gray-900 border border-gray-600 text-white rounded p-3 focus:ring-2 focus:ring-red-500 focus:outline-none"
                        value={selectedTemplate}
                        onChange={(e) => setSelectedTemplate(e.target.value)}
                    >
                        <option value="">-- Selecione --</option>
                        {templates.map(t => (
                            <option key={t.id} value={t.id}>{t.titulo || t.nome || t.name || `Template #${t.id}`}</option>
                        ))}
                    </select>
                </div>

                <div>
                    <label className="block text-gray-300 mb-2 font-medium">Item Mestre (Opcional)</label>
                    <select 
                        className="w-full bg-gray-900 border border-gray-600 text-white rounded p-3 focus:ring-2 focus:ring-red-500 focus:outline-none"
                        value={selectedMaster}
                        onChange={(e) => setSelectedMaster(e.target.value)}
                    >
                        <option value="">-- Nenhum / Genérico --</option>
                        {itemMasters.map(m => (
                            <option key={m.id} value={m.id}>{m.codigo || m.nome || m.title || `Item #${m.id}`}</option>
                        ))}
                    </select>
                </div>
            </div>

            <button
                onClick={handleStart}
                disabled={!selectedTemplate || loading}
                className="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded shadow-lg disabled:opacity-50 disabled:cursor-not-allowed transition-all"
            >
                {loading ? 'Iniciando Sistema...' : 'Iniciar Inspeção'}
            </button>
        </div>
    );
};

export default StartPhase;