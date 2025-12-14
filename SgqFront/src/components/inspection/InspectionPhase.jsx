// src/components/inspection/InspectionPhase.jsx

import React, { useState, useEffect } from 'react';
import InspectionService from '../../services/InspectionService';

const PHASES_LIST = [
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
    const [results, setResults] = useState({});
    const [loading, setLoading] = useState(true);
    const [saveError, setSaveError] = useState(null);
    const [validationErrors, setValidationErrors] = useState(null);

    useEffect(() => {
        const fetchItems = async () => {
            setLoading(true);
            setSaveError(null);
            setValidationErrors(null);
            try {
                // Busca os Items do Template para esta fase (dados de referência: tipo_medicao, ordem, descrição)
                const items = await InspectionService.getTemplateItems(checklistTemplateId, phaseId);
                setTemplateItems(items);

                const initialResults = items.reduce((acc, item) => ({
                    ...acc,
                    [item.id]: {
                        template_item_id: item.id,
                        is_ok: null,
                        result_value: item.tipo_medicao === 'QUANTITATIVA' ? '' : 'CONFORME',
                    }
                }), {});
                setResults(initialResults);
            } catch (err) {
                setSaveError(`Erro ao carregar itens da fase ${phaseId}.`);
                console.error(err);
            } finally {
                setLoading(false);
            }
        };

        if (checklistTemplateId) {
            fetchItems();
        } else {
            setTemplateItems([]);
            setResults({});
            setLoading(false);
        }
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

    const validateBeforeSubmit = () => {
        const errors = {};
        let ok = true;
        templateItems.forEach(item => {
            const r = results[item.id];
            if (!r || r.is_ok === null) {
                ok = false;
                errors[item.id] = { message: 'Resultado não informado' };
                return;
            }
            if (item.tipo_medicao === 'QUANTITATIVA' && (!r.result_value || String(r.result_value).trim() === '')) {
                ok = false;
                errors[item.id] = { message: 'Valor medido obrigatório para medição quantitativa' };
                return;
            }
            if (r.is_ok === false && (!r.result_value || String(r.result_value).trim() === '')) {
                ok = false;
                errors[item.id] = { message: 'Descrição da Não Conformidade (NC) é obrigatória' };
                return;
            }
        });
        return { ok, errors };
    };

    const handleSubmitPhase = async () => {
        const { ok, errors } = validateBeforeSubmit();
        setValidationErrors(errors || null);
        if (!ok) {
            alert('Existem itens com erro. Verifique e corrija antes de avançar.');
            return;
        }

        setLoading(true);
        setSaveError(null);
        setValidationErrors(null);

        const payload = templateItems.map(item => {
            const r = results[item.id] || {};
            return {
                inspection_id: inspectionId,
                template_item_id: item.id,
                ordem: item.ordem || null,
                result_value: r.result_value,
                is_ok: r.is_ok,
                comentario: r.comentario || null,
            };
        });

        try {
            // 1) salva em batch
            await InspectionService.saveInspectionItemResults(payload);

            // 2) pede ao backend os inspectionItems salvos para esta inspection+fase e valida completude
            //    nota: isPhaseComplete usa getInspectionItems internamente
            const complete = await InspectionService.isPhaseComplete(inspectionId, phaseId, templateItems);

            if (!complete) {
                setSaveError('Itens salvos, porém a verificação final mostra que a fase não está completa. Verifique os itens ou erros do servidor.');
                // Opcional: buscar e mostrar os inspectionItems retornados para debugging
                const saved = await InspectionService.getInspectionItems(inspectionId, phaseId);
                setValidationErrors(saved);
                return;
            }

            // 3) Avança a fase somente depois da confirmação
            onComplete();

        } catch (err) {
            if (err && err.validationErrors) {
                setValidationErrors(err.validationErrors);
                setSaveError('Erros de validação retornados pelo servidor. Corrija os itens indicados.');
            } else {
                setSaveError(`Erro ao salvar resultados da fase ${phaseId}.`);
            }
            console.error('Erro ao salvar resultados da fase:', err);
        } finally {
            setLoading(false);
        }
    };

    const currentPhaseData = PHASES_LIST.find(p => p.id === phaseId) || { index: 0 };
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

                    <div className="text-sm text-gray-300 space-y-1 mb-4">
                        <p><span className="font-semibold text-gray-400">Metodologia:</span> {item.metodologia}</p>
                        <p><span className="font-semibold text-gray-400">Padrão de Aceitação:</span> {item.rigor_tecnico}</p>
                    </div>

                    <div className="flex items-center space-x-4 mb-4">
                        <label className="text-white font-semibold mr-2">Resultado:</label>
                        <button onClick={() => handleResultChange(item.id, 'is_ok', true)} className={`px-4 py-2 rounded-full text-sm font-medium transition-colors ${results[item.id]?.is_ok === true ? 'bg-green-600 text-white shadow-lg' : 'bg-gray-600 text-gray-300 hover:bg-gray-500'}`}>OK</button>
                        <button onClick={() => handleResultChange(item.id, 'is_ok', false)} className={`px-4 py-2 rounded-full text-sm font-medium transition-colors ${results[item.id]?.is_ok === false ? 'bg-red-600 text-white shadow-lg' : 'bg-gray-600 text-gray-300 hover:bg-gray-500'}`}>NC</button>
                    </div>

                    {(item.tipo_medicao === 'QUANTITATIVA' || results[item.id]?.is_ok === false) && (
                        <input
                            type="text"
                            placeholder={item.tipo_medicao === 'QUANTITATIVA' ? 'Valor medido' : 'Descrição da Não Conformidade (NC)'}
                            value={results[item.id]?.result_value || ''}
                            onChange={(e) => handleResultChange(item.id, 'result_value', e.target.value)}
                            className="w-full p-3 text-base bg-gray-900 text-white border border-gray-700 rounded-lg focus:ring-1 focus:ring-red-500 focus:border-red-500 transition-all"
                        />
                    )}

                    {validationErrors && validationErrors[item.id] && (
                        <div className="mt-2 text-sm text-yellow-100 bg-yellow-800/30 p-2 rounded">
                            {validationErrors[item.id].message || JSON.stringify(validationErrors[item.id])}
                        </div>
                    )}
                </div>
            ))}

            <button onClick={handleSubmitPhase} disabled={loading} className="w-full flex justify-center items-center mt-8 px-4 py-3 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-red-600 hover:bg-red-700 disabled:bg-red-900 disabled:opacity-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-300">
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