// src/components/inspection/InspectionPhase.jsx

import React, { useState, useEffect } from 'react';
import InspectionService from '../../services/InspectionService';

const InspectionPhase = ({ phaseId, phaseName, inspectionId, checklistTemplateId, onComplete }) => {
    const [items, setItems] = useState([]); 
    const [loading, setLoading] = useState(true);
    const [saving, setSaving] = useState(false);
    const [error, setError] = useState(null);
    const [validationErrors, setValidationErrors] = useState({});

    // Carrega dados iniciais
    useEffect(() => {
        const fetchData = async () => {
            setLoading(true);
            setError(null);
            
            // LOG DE DEBUG: Verifique isso no Console do Navegador (F12)
            console.log(`🔍 [InspectionPhase] Iniciando busca...`);
            console.log(`   -> Checklist ID: ${checklistTemplateId}`);
            console.log(`   -> Fase ID: ${phaseId}`);
            console.log(`   -> Inspection ID: ${inspectionId}`);

            try {
                // 1. Busca Templates (Perguntas)
                const templates = await InspectionService.getTemplateItems(checklistTemplateId, phaseId);
                console.log("📋 [InspectionPhase] Templates recebidos:", templates);

                // 2. Busca Resultados Salvos
                const savedItems = await InspectionService.getInspectionItems(inspectionId, phaseId);
                console.log("💾 [InspectionPhase] Itens Salvos recebidos:", savedItems);

                if (!Array.isArray(templates)) {
                    throw new Error("A resposta da API de templates não é um array válido.");
                }

                // 3. Merge
                const mergedItems = templates.map(tmpl => {
                    const saved = Array.isArray(savedItems) ? savedItems.find(s => s.template_item_id === tmpl.id) : null;
                    
                    return {
                        template_item_id: tmpl.id,
                        ordem: tmpl.ordem,
                        descricao: tmpl.descricao,
                        metodologia: tmpl.metodologia,
                        rigor_tecnico: tmpl.rigor_tecnico,
                        tipo_medicao: tmpl.tipo_medicao,
                        
                        is_ok: saved ? saved.is_ok : null, 
                        result_value: saved ? (saved.measured_value || saved.result_value || '') : '',
                        comentario: saved ? saved.comentario : '',
                        existing_id: saved ? saved.id : null
                    };
                });

                setItems(mergedItems);

            } catch (err) {
                console.error("❌ [InspectionPhase] Erro:", err);
                setError('Falha ao carregar dados. Verifique o console para detalhes.');
            } finally {
                setLoading(false);
            }
        };

        if (checklistTemplateId && inspectionId) {
            fetchData();
        } else {
            console.warn("⚠️ [InspectionPhase] IDs faltando. Checklist:", checklistTemplateId, "Inspection:", inspectionId);
            setLoading(false);
        }
    }, [checklistTemplateId, phaseId, inspectionId]);

    const handleChange = (templateId, field, value) => {
        setItems(prevItems => prevItems.map(item => {
            if (item.template_item_id === templateId) {
                return { ...item, [field]: value };
            }
            return item;
        }));
        
        if (validationErrors[templateId]) {
            setValidationErrors(prev => {
                const newErrs = { ...prev };
                delete newErrs[templateId];
                return newErrs;
            });
        }
    };

    const validatePhase = () => {
        const newErrors = {};
        let isValid = true;

        items.forEach(item => {
            if (item.is_ok === null || item.is_ok === undefined) {
                newErrors[item.template_item_id] = 'Definição de status (OK/NC) é obrigatória.';
                isValid = false;
            }
            if (item.tipo_medicao === 'QUANTITATIVA') {
                if (!item.result_value || String(item.result_value).trim() === '') {
                    newErrors[item.template_item_id] = 'Valor medido é obrigatório.';
                    isValid = false;
                }
            }
            if (item.is_ok === false) {
                const temValor = item.result_value && String(item.result_value).trim() !== '';
                const temComent = item.comentario && String(item.comentario).trim() !== '';
                if (!temValor && !temComent) {
                    newErrors[item.template_item_id] = 'Para itens NC, justifique com valor ou comentário.';
                    isValid = false;
                }
            }
        });

        setValidationErrors(newErrors);
        return isValid;
    };

    const handleSaveAndNext = async () => {
        if (!validatePhase()) {
            window.scrollTo({ top: 0, behavior: 'smooth' });
            return;
        }

        setSaving(true);
        setError(null);

        try {
            const payload = items.map(item => ({
                inspection_id: inspectionId,
                template_item_id: item.template_item_id,
                is_ok: item.is_ok,
                result_value: item.result_value,
                comentario: item.comentario,
                ordem: item.ordem
            }));

            await InspectionService.saveInspectionItemResults(payload);
            onComplete();

        } catch (err) {
            console.error('Erro ao salvar:', err);
            setError('Erro ao salvar os dados. O servidor recusou os dados ou está indisponível.');
        } finally {
            setSaving(false);
        }
    };

    if (loading) return (
        <div className="p-8 text-center text-gray-400 animate-pulse">
            Carregando Itens da {phaseName}...<br/>
            <small>ID Template: {checklistTemplateId}</small>
        </div>
    );

    return (
        <div className="space-y-6">
            {error && (
                <div className="bg-red-900/40 border border-red-600 text-red-200 p-4 rounded-lg flex items-center">
                    <span className="mr-2">⚠️</span> {error}
                </div>
            )}

            {items.length === 0 ? (
                <div className="text-gray-400 text-center py-10 border border-dashed border-gray-700 rounded bg-gray-800/50">
                    <p className="text-lg font-bold text-white mb-2">Nenhum item encontrado.</p>
                    <p className="text-sm mb-4">
                        Não há perguntas cadastradas para a fase <strong>{phaseId}</strong> neste Checklist.
                    </p>
                    <div className="text-xs text-gray-500 font-mono bg-black/30 p-2 rounded inline-block text-left">
                        Checklist ID: {checklistTemplateId}<br/>
                        Fase ID: {phaseId}
                    </div>
                    <div className="mt-6">
                        <button onClick={onComplete} className="text-blue-400 underline hover:text-blue-300">
                            Pular esta Fase (Avançar)
                        </button>
                    </div>
                </div>
            ) : (
                items.map((item) => (
                    <div key={item.template_item_id} className={`p-5 rounded-lg border-l-4 shadow-lg transition-all ${
                        validationErrors[item.template_item_id] ? 'bg-gray-800 border-red-500 ring-1 ring-red-500' : 'bg-gray-800 border-gray-600 hover:border-blue-500'
                    }`}>
                        <div className="flex justify-between items-start mb-3">
                            <h4 className="text-lg font-bold text-white">
                                {item.ordem}. <span className={item.is_ok === false ? 'text-red-400' : 'text-gray-200'}>{item.descricao}</span>
                            </h4>
                            <div className="flex space-x-2">
                                <button
                                    onClick={() => handleChange(item.template_item_id, 'is_ok', true)}
                                    className={`px-4 py-1 rounded-full text-sm font-bold transition-colors ${
                                        item.is_ok === true 
                                        ? 'bg-green-600 text-white shadow-[0_0_10px_rgba(22,163,74,0.5)]' 
                                        : 'bg-gray-700 text-gray-400 hover:bg-gray-600'
                                    }`}
                                >
                                    OK
                                </button>
                                <button
                                    onClick={() => handleChange(item.template_item_id, 'is_ok', false)}
                                    className={`px-4 py-1 rounded-full text-sm font-bold transition-colors ${
                                        item.is_ok === false 
                                        ? 'bg-red-600 text-white shadow-[0_0_10px_rgba(220,38,38,0.5)]' 
                                        : 'bg-gray-700 text-gray-400 hover:bg-gray-600'
                                    }`}
                                >
                                    NC
                                </button>
                            </div>
                        </div>

                        <div className="text-xs text-gray-400 mb-4 grid grid-cols-1 md:grid-cols-2 gap-2 bg-black/20 p-2 rounded">
                            <p><strong>Método:</strong> {item.metodologia || 'N/A'}</p>
                            <p><strong>Critério:</strong> {item.rigor_tecnico || 'Visual'}</p>
                        </div>

                        <div className="space-y-3">
                            {(item.tipo_medicao === 'QUANTITATIVA' || item.is_ok === false) && (
                                <div>
                                    <label className="block text-xs text-gray-500 mb-1 uppercase tracking-wide">
                                        {item.tipo_medicao === 'QUANTITATIVA' ? 'Valor Medido' : 'Valor / Evidência'}
                                    </label>
                                    <input
                                        type="text"
                                        className="w-full bg-gray-900 border border-gray-700 rounded px-3 py-2 text-white focus:outline-none focus:border-blue-500 transition-colors"
                                        placeholder="Insira o valor..."
                                        value={item.result_value}
                                        onChange={(e) => handleChange(item.template_item_id, 'result_value', e.target.value)}
                                    />
                                </div>
                            )}

                            <div>
                                <label className="block text-xs text-gray-500 mb-1 uppercase tracking-wide">Observações / NC Detalhada</label>
                                <textarea
                                    rows="2"
                                    className="w-full bg-gray-900 border border-gray-700 rounded px-3 py-2 text-white focus:outline-none focus:border-blue-500 transition-colors text-sm"
                                    placeholder="Comentários adicionais..."
                                    value={item.comentario || ''}
                                    onChange={(e) => handleChange(item.template_item_id, 'comentario', e.target.value)}
                                />
                            </div>
                        </div>

                        {validationErrors[item.template_item_id] && (
                            <div className="mt-3 text-sm text-red-400 font-medium animate-pulse">
                                ⚠️ {validationErrors[item.template_item_id]}
                            </div>
                        )}
                    </div>
                ))
            )}

            {items.length > 0 && (
                <button
                    onClick={handleSaveAndNext}
                    disabled={saving}
                    className="w-full mt-8 py-4 bg-red-600 hover:bg-red-700 text-white rounded-lg font-bold text-lg shadow-lg transform transition hover:scale-[1.01] active:scale-[0.99] disabled:opacity-50 disabled:cursor-not-allowed flex justify-center items-center"
                >
                    {saving ? 'Processando...' : 'Salvar e Avançar'}
                </button>
            )}
        </div>
    );
};

export default InspectionPhase;