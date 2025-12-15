// src/components/inspection/InspectionPhase.jsx

import React, { useState, useEffect } from 'react';
import InspectionService from '../../services/InspectionService';
import NonConformityService from '../../services/NonConformityService';

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
            
            try {
                const templates = await InspectionService.getTemplateItems(checklistTemplateId, phaseId);
                const savedItems = await InspectionService.getInspectionItems(inspectionId, phaseId);

                if (!Array.isArray(templates)) throw new Error("Dados inválidos do template.");

                const mergedItems = templates.map(tmpl => {
                    const saved = Array.isArray(savedItems) ? savedItems.find(s => s.template_item_id === tmpl.id) : null;
                    return {
                        template_item_id: tmpl.id,
                        ordem: tmpl.ordem,
                        descricao: tmpl.descricao || tmpl.description || `Item #${tmpl.id}`, 
                        metodologia: tmpl.metodologia,
                        rigor_tecnico: tmpl.rigor_tecnico,
                        tipo_medicao: tmpl.tipo_medicao,
                        is_ok: saved ? saved.is_ok : null, 
                        result_value: saved ? (saved.measured_value || saved.result_value || '') : '',
                        comentario: saved ? saved.comentario : '',
                        existing_id: saved ? saved.id : null,
                        was_nc: saved ? saved.is_ok === false : false 
                    };
                });
                setItems(mergedItems);
            } catch (err) {
                console.error("Erro carregando itens:", err);
                setError('Falha ao sincronizar checklist.');
            } finally {
                setLoading(false);
            }
        };

        if (checklistTemplateId && inspectionId) fetchData();
        else setLoading(false);
    }, [checklistTemplateId, phaseId, inspectionId]);

    const handleChange = (templateId, field, value) => {
        setItems(prevItems => prevItems.map(item => {
            if (item.template_item_id === templateId) return { ...item, [field]: value };
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
                newErrors[item.template_item_id] = 'Status pendente';
                isValid = false;
            }
            if (item.tipo_medicao === 'QUANTITATIVA') {
                if (!item.result_value || String(item.result_value).trim() === '') {
                    newErrors[item.template_item_id] = 'Valor obrigatório';
                    isValid = false;
                }
            }
            if (item.is_ok === false) {
                const temValor = item.result_value && String(item.result_value).trim() !== '';
                const temComent = item.comentario && String(item.comentario).trim() !== '';
                if (!temValor && !temComent) {
                    newErrors[item.template_item_id] = 'Justificativa necessária';
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

            // NC Automática
            const ncItems = items.filter(item => item.is_ok === false);
            if (ncItems.length > 0) {
                const ncPromises = ncItems.map(item => {
                    const descSafe = item.descricao ? String(item.descricao) : `Item ID ${item.template_item_id}`;
                    const valorSafe = item.result_value ? String(item.result_value) : 'Não informado';
                    const comentSafe = item.comentario ? String(item.comentario) : 'Sem observações';

                    const ncData = {
                        description: `Falha: ${descSafe.substring(0, 50)}...`, 
                        details: `[Gerado Automaticamente]\nItem: ${descSafe}\nMedição: ${valorSafe}\nObs: ${comentSafe}\nFase: ${phaseName}`,
                        status: 'Open',
                        severity: 'Medium', 
                        inspection_item_id: item.existing_id || null, 
                        responsavel_id: null 
                    };
                    return NonConformityService.create(ncData).catch(err => console.error("Erro NC auto:", err));
                });
                await Promise.allSettled(ncPromises);
            }
            onComplete();
        } catch (err) {
            console.error('Erro save:', err);
            setError('Servidor indisponível no momento.');
        } finally {
            setSaving(false);
        }
    };

    if (loading) return (
        <div className="flex justify-center items-center h-64">
             <div className="text-slate-500 animate-pulse text-sm font-medium">Carregando itens de verificação...</div>
        </div>
    );

    return (
        <div className="space-y-4">
            {error && (
                <div className="bg-rose-950/30 border border-rose-900/50 text-rose-300 p-4 rounded-lg flex items-center shadow-sm">
                    <span className="mr-2 font-bold">⚠️</span> {error}
                </div>
            )}

            {items.length === 0 ? (
                <div className="flex flex-col items-center justify-center h-64 border border-dashed border-slate-800 rounded-xl bg-slate-900/50 text-slate-500">
                    <p className="font-medium">Nenhum item de verificação para esta fase.</p>
                    <button onClick={onComplete} className="mt-4 px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded text-sm transition-colors">
                        Avançar para Próxima Fase
                    </button>
                </div>
            ) : (
                items.map((item) => (
                    <div 
                        key={item.template_item_id} 
                        className={`group p-6 rounded-xl border transition-all duration-300 ${
                            validationErrors[item.template_item_id] 
                            ? 'bg-rose-950/10 border-rose-500/50' 
                            : 'bg-slate-900 border-slate-800 hover:border-indigo-500/30'
                        }`}
                    >
                        <div className="flex flex-col md:flex-row md:items-start justify-between gap-4">
                            
                            {/* Descrição e Metadados */}
                            <div className="flex-1">
                                <div className="flex items-center gap-3 mb-2">
                                    <span className="flex items-center justify-center w-6 h-6 rounded bg-slate-800 text-xs font-mono text-slate-400 font-bold">
                                        {item.ordem}
                                    </span>
                                    <h4 className="text-base font-semibold text-slate-200 leading-snug">
                                        {item.descricao}
                                    </h4>
                                </div>
                                <div className="flex flex-wrap gap-2 mt-2">
                                    {item.metodologia && (
                                        <span className="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide bg-slate-800 text-slate-500">
                                            {item.metodologia}
                                        </span>
                                    )}
                                    {item.rigor_tecnico && (
                                        <span className="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide bg-slate-800 text-indigo-400">
                                            {item.rigor_tecnico}
                                        </span>
                                    )}
                                </div>
                            </div>

                            {/* Botões de Ação */}
                            <div className="flex items-center gap-2 bg-slate-950 p-1.5 rounded-lg border border-slate-800/50">
                                <button
                                    onClick={() => handleChange(item.template_item_id, 'is_ok', true)}
                                    className={`px-6 py-2 rounded-md text-sm font-bold transition-all ${
                                        item.is_ok === true 
                                        ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-500/20' 
                                        : 'text-slate-500 hover:text-slate-300 hover:bg-slate-800'
                                    }`}
                                >
                                    CONFORME
                                </button>
                                <div className="w-px h-6 bg-slate-800"></div>
                                <button
                                    onClick={() => handleChange(item.template_item_id, 'is_ok', false)}
                                    className={`px-6 py-2 rounded-md text-sm font-bold transition-all ${
                                        item.is_ok === false 
                                        ? 'bg-rose-600 text-white shadow-lg shadow-rose-500/20' 
                                        : 'text-slate-500 hover:text-slate-300 hover:bg-slate-800'
                                    }`}
                                >
                                    NÃO CONFORME
                                </button>
                            </div>
                        </div>

                        {/* Área de Input Condicional */}
                        <div className={`mt-4 grid grid-cols-1 md:grid-cols-3 gap-4 transition-all duration-300 overflow-hidden ${
                            (item.tipo_medicao === 'QUANTITATIVA' || item.is_ok === false) ? 'opacity-100 max-h-40 pt-4 border-t border-slate-800/50' : 'opacity-0 max-h-0'
                        }`}>
                            
                            {(item.tipo_medicao === 'QUANTITATIVA' || item.is_ok === false) && (
                                <div className="md:col-span-1">
                                    <label className="block text-[10px] text-slate-500 font-bold uppercase tracking-wider mb-1.5">
                                        {item.tipo_medicao === 'QUANTITATIVA' ? 'Valor Medido' : 'Evidência / Valor'}
                                    </label>
                                    <input
                                        type="text"
                                        className="w-full bg-slate-950 border border-slate-700 rounded-md px-3 py-2 text-sm text-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 placeholder-slate-600"
                                        placeholder="Ex: 10.5mm"
                                        value={item.result_value}
                                        onChange={(e) => handleChange(item.template_item_id, 'result_value', e.target.value)}
                                    />
                                </div>
                            )}

                            <div className="md:col-span-2">
                                <label className="block text-[10px] text-slate-500 font-bold uppercase tracking-wider mb-1.5">
                                    Observações Técnicas
                                </label>
                                <input
                                    type="text"
                                    className="w-full bg-slate-950 border border-slate-700 rounded-md px-3 py-2 text-sm text-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 placeholder-slate-600"
                                    placeholder="Adicione detalhes relevantes..."
                                    value={item.comentario || ''}
                                    onChange={(e) => handleChange(item.template_item_id, 'comentario', e.target.value)}
                                />
                            </div>
                        </div>

                        {validationErrors[item.template_item_id] && (
                            <div className="mt-3 flex items-center gap-2 text-rose-400 text-xs font-medium animate-pulse">
                                <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                {validationErrors[item.template_item_id]}
                            </div>
                        )}
                    </div>
                ))
            )}

            {items.length > 0 && (
                <div className="pt-8 flex justify-end">
                    <button
                        onClick={handleSaveAndNext}
                        disabled={saving}
                        className="px-8 py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-lg shadow-xl shadow-indigo-500/20 transform transition hover:-translate-y-0.5 active:translate-y-0 disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
                    >
                        {saving ? (
                            <>Processando...</>
                        ) : (
                            <>
                                Salvar e Avançar
                                <span className="text-indigo-200 ml-1">→</span>
                            </>
                        )}
                    </button>
                </div>
            )}
        </div>
    );
};

export default InspectionPhase;