// src/components/inspection/InspectionPhase.jsx (Estilizado)

import React, { useState, useEffect } from 'react';
import InspectionService from '../../services/InspectionService';

// 🚨 INCLUSÃO: PHASES_LIST é necessário aqui para calcular o nome da próxima fase no botão
const PHASES_LIST = [
    // ... (Lista de Fases)
    { index: 0, id: 'PHASE_0_START', name: 'Início: Seleção do Item' },
    { index: 1, id: 'PHASE_1_DOCS', name: 'Fase 1: Documental e Rastreabilidade' },
    { index: 2, id: 'PHASE_2_PREP', name: 'Fase 2: Preparação e Ferramental' },
    { index: 3, id: 'PHASE_3_DIMENSIONAL', name: 'Fase 3: Inspeção Dimensional' },
    { index: 4, id: 'PHASE_4_VISUAL_NDT', name: 'Fase 4: Inspeção Visual e NDT' },
    { index: 5, id: 'PHASE_5_FINAL_RELEASE', name: 'Fase 5: Revisão e Liberação Final' },
    { index: 6, id: 'PHASE_6_FINISH', name: 'Concluir Inspeção' },
];

const InspectionPhase = ({ phaseId, phaseName, inspectionId, checklistTemplateId, onComplete }) => {

    const [templateItems, setTemplateItems] = useState([]);
    const [results, setResults] = useState({}); // { itemId: { template_item_id, result_value, is_ok } }
    const [loading, setLoading] = useState(true);
    const [saveError, setSaveError] = useState(null);


    useEffect(() => {
        // ... (Lógica de fetchItems mantida)
        const fetchItems = async () => {
            setLoading(true);
            setSaveError(null);
            try {
                // 🎯 Sincronização: Backend precisa filtrar por checklist ID E phaseId
                const items = await InspectionService.getTemplateItems(checklistTemplateId, phaseId);
                setTemplateItems(items);

                // Inicializa o estado de resultados
                const initialResults = items.reduce((acc, item) => ({
                    ...acc,
                    [item.id]: {
                        template_item_id: item.id,
                        // Inicializa is_ok como null para forçar preenchimento
                        is_ok: null,
                        result_value: item.tipo_medicao === 'QUANTITATIVA' ? '' : 'CONFORME'
                    }
                }), {});
                setResults(initialResults);
            } catch (err) {
                setSaveError(`Erro ao carregar itens da fase ${phaseId}. Verifique a API.`);
                console.error(err);
            } finally {
                setLoading(false);
            }
        };

        fetchItems();
    }, [checklistTemplateId, phaseId]);

    const handleResultChange = (itemId, field, value) => {
        setResults(prev => ({
            ...prev,
            [itemId]: {
                ...prev[itemId],
                [field]: value
            }
        }));
    };

    const handleSubmitPhase = async () => {
        // 2. Validação: Checar se todos os itens foram preenchidos (is_ok não pode ser null)
        const allFilled = templateItems.every(item => results[item.id] && results[item.id].is_ok !== null);

        if (!allFilled) {
            alert("Preencha todos os itens do checklist antes de avançar!");
            return;
        }

        setLoading(true);
        setSaveError(null);
        try {
            // 3. POST: Salvar todos os Inspection Items (batch)
            const payload = Object.values(results).map(result => ({
                ...result,
                inspection_id: inspectionId
            }));

            // 🎯 O Controller (InspectionItemController) precisa estar configurado para aceitar arrays (batch insert)
            await InspectionService.saveInspectionItemResults(payload);

            // 4. Conclui a fase e avança
            onComplete();

        } catch (error) {
            setSaveError(`Erro ao salvar resultados da fase ${phaseId}.`);
            console.error(`Erro ao salvar resultados da fase ${phaseId}:`, error);
        } finally {
            setLoading(false);
        }
    };

    // Calcula o nome da próxima fase para o botão
    const currentPhaseData = PHASES_LIST.find(p => p.id === phaseId);
    const nextPhaseName = PHASES_LIST.find(p => p.index === currentPhaseData.index + 1)?.name || "Finalizar";

    if (loading) return <div className="text-gray-400">Carregando checklist da {phaseName}...</div>;
    if (saveError) return <div className="p-3 text-sm text-red-400 bg-red-900/30 border border-red-800 rounded-lg">{saveError}</div>;

    return (
        <div className="checklist-form space-y-6">
            {templateItems.map(item => (
                <div key={item.id} className="checklist-item bg-gray-700 p-5 rounded-lg border-l-4 border-red-600 shadow-md">

                    <h4 className="text-lg font-bold text-white mb-2">
                        Item {item.ordem}: <span className="text-red-400">{item.descricao}</span>
                    </h4>

                    {/* 🎯 Informações de Referência */}
                    <div className="text-sm text-gray-300 space-y-1 mb-4">
                        <p><span className="font-semibold text-gray-400">Metodologia:</span> {item.metodologia}</p>
                        <p><span className="font-semibold text-gray-400">Padrão de Aceitação:</span> {item.rigor_tecnico}</p>
                    </div>

                    {/* 🎯 Opções de Resultado */}
                    <div className="flex items-center space-x-4 mb-4">
                        <label className="text-white font-semibold mr-2">Resultado:</label>
                        <button
                            onClick={() => handleResultChange(item.id, 'is_ok', true)}
                            className={`px-4 py-2 rounded-full text-sm font-medium transition-colors ${results[item.id]?.is_ok === true ? 'bg-green-600 text-white shadow-lg' : 'bg-gray-600 text-gray-300 hover:bg-gray-500'}`}
                        >
                            OK
                        </button>
                        <button
                            onClick={() => handleResultChange(item.id, 'is_ok', false)}
                            className={`px-4 py-2 rounded-full text-sm font-medium transition-colors ${results[item.id]?.is_ok === false ? 'bg-red-600 text-white shadow-lg' : 'bg-gray-600 text-gray-300 hover:bg-gray-500'}`}
                        >
                            NC
                        </button>
                    </div>

                    {/* 💡 Exemplo de Campo Quantitativo/Textual */}
                    {(item.tipo_medicao === 'QUANTITATIVA' || results[item.id]?.is_ok === false) && (
                        <input
                            type="text"
                            placeholder={item.tipo_medicao === 'QUANTITATIVA' ? 'Valor medido' : 'Descrição da Não Conformidade (NC)'}
                            value={results[item.id]?.result_value || ''}
                            onChange={(e) => handleResultChange(item.id, 'result_value', e.target.value)}
                            // 🚨 NOVO: Estilo do Input
                            className="w-full p-3 text-base bg-gray-900 text-white border border-gray-700 rounded-lg focus:ring-1 focus:ring-red-500 focus:border-red-500 transition-all"
                        />
                    )}

                </div>
            ))}

            {/* 🚨 NOVO: Estilo do Botão Principal (Avançar Fase) */}
            <button
                onClick={handleSubmitPhase}
                disabled={loading}
                className="w-full flex justify-center items-center mt-8 px-4 py-3 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-red-600 hover:bg-red-700 disabled:bg-red-900 disabled:opacity-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-300"
            >
                {loading ? (
                    <>
                        <div className="w-4 h-4 border-2 border-white border-t-red-200 rounded-full animate-spin mr-2"></div>
                        Salvando...
                    </>
                ) : (
                    `Salvar e Ir para: ${nextPhaseName}`
                )}
            </button>
        </div>
    );
};

export default InspectionPhase;