// src/components/inspection/InspectionPhase.jsx

import React, { useState, useEffect } from 'react';
import InspectionService from '../../services/InspectionService';

const InspectionPhase = ({ phaseId, phaseName, inspectionId, checklistTemplateId, onComplete }) => {
    const [items, setItems] = useState([]); // Array unificado: Template + Resultado
    const [loading, setLoading] = useState(true);
    const [saving, setSaving] = useState(false);
    const [error, setError] = useState(null);
    const [validationErrors, setValidationErrors] = useState({});

    // Carrega dados iniciais: Definição do Checklist + Itens já salvos (se houver)
    useEffect(() => {
        const fetchData = async () => {
            setLoading(true);
            setError(null);
            try {
                // 1. Busca o que precisa ser feito (Template)
                const templates = await InspectionService.getTemplateItems(checklistTemplateId, phaseId);
                
                // 2. Busca o que já foi feito (Saved Results)
                const savedItems = await InspectionService.getInspectionItems(inspectionId, phaseId);

                // 3. Merge: Cria objeto de estado combinando Template com Resultados Salvos
                const mergedItems = templates.map(tmpl => {
                    // Tenta encontrar um item salvo correspondente a este template
                    const saved = savedItems.find(s => s.template_item_id === tmpl.id);
                    
                    return {
                        template_item_id: tmpl.id,
                        ordem: tmpl.ordem,
                        descricao: tmpl.descricao,
                        metodologia: tmpl.metodologia,
                        rigor_tecnico: tmpl.rigor_tecnico,
                        tipo_medicao: tmpl.tipo_medicao, // 'QUALITATIVA' ou 'QUANTITATIVA'
                        
                        // Estado do valor (usa o salvo ou inicializa)
                        // Se for quantitativa, result_value. Se qualitativa, is_ok.
                        is_ok: saved ? saved.is_ok : null, 
                        result_value: saved ? (saved.measured_value || saved.result_value || '') : '',
                        comentario: saved ? saved.comentario : '',
                        
                        // Guarda ID salvo para updates futuros (opcional, dependendo do backend)
                        existing_id: saved ? saved.id : null
                    };
                });

                setItems(mergedItems);

            } catch (err) {
                console.error(err);
                setError('Falha ao carregar dados da fase. Verifique sua conexão.');
            } finally {
                setLoading(false);
            }
        };

        if (checklistTemplateId && inspectionId) {
            fetchData();
        }
    }, [checklistTemplateId, phaseId, inspectionId]);

    // Manipula mudanças nos inputs
    const handleChange = (templateId, field, value) => {
        setItems(prevItems => prevItems.map(item => {
            if (item.template_item_id === templateId) {
                return { ...item, [field]: value };
            }
            return item;
        }));
        
        // Limpa erro específico ao editar
        if (validationErrors[templateId]) {
            setValidationErrors(prev => {
                const newErrs = { ...prev };
                delete newErrs[templateId];
                return newErrs;
            });
        }
    };

    // Lógica de Validação Local (Front-end Logic)
    const validatePhase = () => {
        const newErrors = {};
        let isValid = true;

        items.forEach(item => {
            // Regra 1: Todos devem ter status OK/NC definido
            if (item.is_ok === null || item.is_ok === undefined) {
                newErrors[item.template_item_id] = 'Definição de status (OK/NC) é obrigatória.';
                isValid = false;
            }

            // Regra 2: Se for Quantitativa, valor é obrigatório
            if (item.tipo_medicao === 'QUANTITATIVA') {
                if (!item.result_value || String(item.result_value).trim() === '') {
                    newErrors[item.template_item_id] = 'Valor medido é obrigatório.';
                    isValid = false;
                }
            }

            // Regra 3: Se for NC (Não Conforme), comentário ou valor é obrigatório para explicar
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
            // Prepara payload para a API
            const payload = items.map(item => ({
                inspection_id: inspectionId,
                template_item_id: item.template_item_id,
                is_ok: item.is_ok,
                result_value: item.result_value, // Backend mapeia para measured_value ou mantém result_value
                comentario: item.comentario,
                ordem: item.ordem
            }));

            // Envia para o backend (Batch Save)
            await InspectionService.saveInspectionItemResults(payload);

            // Sucesso total no front, avança
            onComplete();

        } catch (err) {
            console.error('Erro ao salvar:', err);
            setError('Erro ao salvar os dados. O servidor recusou os dados ou está indisponível.');
            if (err.validationErrors) {
                // Mapeia erros de validação do backend (se houver) de volta para a UI
                // Isso assume que o backend retorna erros indexados
                setValidationErrors(err.validationErrors); 
            }
        } finally {
            setSaving(false);
        }
    };

    if (loading) return <div className="p-8 text-center text-gray-400 animate-pulse">Carregando Itens da {phaseName}...</div>;

    return (
        <div className="space-y-6">
            {error && (
                <div className="bg-red-900/40 border border-red-600 text-red-200 p-4 rounded-lg flex items-center">
                    <span className="mr-2">⚠️</span> {error}
                </div>
            )}

            {items.length === 0 ? (
                <div className="text-gray-400 text-center py-10 border border-dashed border-gray-700 rounded">
                    Nenhum item configurado para esta fase.
                    <button onClick={onComplete} className="ml-4 text-blue-400 underline">Pular Fase</button>
                </div>
            ) : (
                items.map((item) => (
                    <div key={item.template_item_id} className={`p-5 rounded-lg border-l-4 shadow-lg transition-all ${
                        validationErrors[item.template_item_id] ? 'bg-gray-800 border-red-500 ring-1 ring-red-500' : 'bg-gray-800 border-gray-600 hover:border-blue-500'
                    }`}>
                        {/* Cabeçalho do Item */}
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

                        {/* Detalhes Técnicos */}
                        <div className="text-xs text-gray-400 mb-4 grid grid-cols-1 md:grid-cols-2 gap-2">
                            <p><strong>Método:</strong> {item.metodologia || 'N/A'}</p>
                            <p><strong>Critério:</strong> {item.rigor_tecnico || 'Visual'}</p>
                        </div>

                        {/* Inputs Dinâmicos */}
                        <div className="space-y-3">
                            {/* Input Quantitativo */}
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

                            {/* Comentário (Sempre disponível, mas mandatório se NC sem valor) */}
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

                        {/* Mensagem de Erro de Validação */}
                        {validationErrors[item.template_item_id] && (
                            <div className="mt-3 text-sm text-red-400 font-medium animate-pulse">
                                ⚠️ {validationErrors[item.template_item_id]}
                            </div>
                        )}
                    </div>
                ))
            )}

            <button
                onClick={handleSaveAndNext}
                disabled={saving}
                className="w-full mt-8 py-4 bg-red-600 hover:bg-red-700 text-white rounded-lg font-bold text-lg shadow-lg transform transition hover:scale-[1.01] active:scale-[0.99] disabled:opacity-50 disabled:cursor-not-allowed flex justify-center items-center"
            >
                {saving ? (
                    <>
                        <svg className="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4"></circle>
                            <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Processando e Salvando...
                    </>
                ) : (
                    'Salvar e Avançar'
                )}
            </button>
        </div>
    );
};

export default InspectionPhase;