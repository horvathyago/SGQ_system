// src/components/NonConformity/NcFormModal.jsx
import React, { useState, useEffect } from 'react';

const NcFormModal = ({ isOpen, onClose, onSubmit, initialData }) => {
    const [formData, setFormData] = useState({
        description: '',
        details: '',
        status: 'Open',
        severity: 'Medium',
        inspection_item_id: '',
        responsavel_id: '',
        disposition: '',
        is_fca_trigger: 0
    });

    const [contextData, setContextData] = useState(null);

    useEffect(() => {
        if (initialData) {
            setFormData({
                description: initialData.description || '',
                details: initialData.details || '',
                status: initialData.status || 'Open',
                severity: initialData.severity || 'Medium',
                inspection_item_id: initialData.inspection_item_id || '',
                responsavel_id: initialData.responsavel_id || '',
                disposition: initialData.disposition || '',
                is_fca_trigger: initialData.is_fca_trigger ? 1 : 0
            });
            if (initialData.inspection_item) {
                setContextData(initialData.inspection_item);
            } else {
                setContextData(null);
            }
        }
    }, [initialData]);

    const handleChange = (e) => {
        const { name, value, type, checked } = e.target;
        setFormData(prev => ({ 
            ...prev, 
            [name]: type === 'checkbox' ? (checked ? 1 : 0) : value 
        }));
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        onSubmit(formData);
    };

    // Estilos reutilizáveis
    const labelClass = "block text-[10px] uppercase font-bold text-slate-500 tracking-wider mb-1.5";
    const inputClass = "w-full bg-slate-950 border border-slate-700 rounded-lg px-3 py-2.5 text-sm text-slate-200 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-600 transition-colors outline-none";

    if (!isOpen) return null;

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div className="absolute inset-0 bg-slate-950/80 backdrop-blur-sm transition-opacity" onClick={onClose}></div>
            
            <div className="relative bg-slate-900 border border-slate-800 rounded-xl shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-y-auto flex flex-col">
                
                {/* Header */}
                <div className="px-6 py-4 border-b border-slate-800 flex justify-between items-center bg-slate-900 sticky top-0 z-10">
                    <div>
                        <h3 className="text-lg font-bold text-white flex items-center gap-3">
                            {initialData ? 'Detalhes da Ocorrência' : 'Nova Não Conformidade'}
                            {formData.is_fca_trigger === 1 && (
                                <span className="text-[9px] bg-purple-500/20 text-purple-300 border border-purple-500/30 px-2 py-0.5 rounded uppercase font-bold tracking-wide">
                                    FCA Ativa
                                </span>
                            )}
                        </h3>
                        <p className="text-xs text-slate-500 font-mono mt-1">ID Ref: {initialData?.id || 'NOVO'}</p>
                    </div>
                    <button onClick={onClose} className="text-slate-500 hover:text-white transition-colors">
                        <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <form onSubmit={handleSubmit} className="p-6 space-y-6">
                    
                    {/* --- CONTEXTO (Se existir) --- */}
                    {contextData && (
                        <div className="bg-slate-950/50 border border-slate-800 rounded-lg p-4">
                            <h4 className="text-[10px] font-bold text-indigo-400 uppercase tracking-widest mb-3 border-b border-slate-800/50 pb-2">
                                Dados de Origem (Checklist)
                            </h4>
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                                <div>
                                    <span className="block text-slate-500 text-xs mb-1">Medição Registrada</span>
                                    <span className="font-mono text-rose-400 font-bold text-lg bg-rose-950/10 px-2 py-0.5 rounded border border-rose-900/30 inline-block">
                                        {contextData.result_value || 'N/A'}
                                    </span>
                                </div>
                                <div>
                                    <span className="block text-slate-500 text-xs mb-1">ID do Item</span>
                                    <span className="text-slate-300 font-mono text-xs">{contextData.id}</span>
                                </div>
                                <div className="col-span-2">
                                    <span className="block text-slate-500 text-xs mb-1">Observação do Inspetor</span>
                                    <p className="text-slate-300 italic text-sm p-3 bg-slate-900 border border-slate-800 rounded-lg">
                                        "{contextData.comentario || 'Sem observações'}"
                                    </p>
                                </div>
                            </div>
                        </div>
                    )}

                    {/* --- DADOS DA NC --- */}
                    <div className="space-y-5">
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div className="col-span-2">
                                <label className={labelClass}>Descrição Curta da Falha</label>
                                <input 
                                    type="text" 
                                    name="description"
                                    value={formData.description}
                                    onChange={handleChange}
                                    required
                                    className={inputClass}
                                    placeholder="Ex: Dimensão X fora do especificado"
                                />
                            </div>

                            <div className="col-span-2">
                                <label className={labelClass}>Disposição Imediata</label>
                                <input 
                                    type="text" 
                                    name="disposition"
                                    value={formData.disposition}
                                    onChange={handleChange}
                                    placeholder="Ex: Segregar material, Retrabalhar, Aceitar sob concessão..."
                                    className={`${inputClass} border-l-4 border-l-indigo-500`}
                                />
                            </div>
                        </div>

                        <div>
                            <label className={labelClass}>Análise Técnica & Detalhes</label>
                            <textarea 
                                name="details"
                                value={formData.details}
                                onChange={handleChange}
                                rows="4"
                                className={inputClass}
                                placeholder="Descreva a evidência objetiva, possíveis causas e impacto..."
                            ></textarea>
                        </div>

                        {/* Controles: Status, Severity, FCA */}
                        <div className="grid grid-cols-2 md:grid-cols-3 gap-5 p-5 bg-slate-950/30 rounded-xl border border-slate-800">
                            <div>
                                <label className={labelClass}>Severidade</label>
                                <select 
                                    name="severity" 
                                    value={formData.severity} 
                                    onChange={handleChange}
                                    className={inputClass}
                                >
                                    <option value="Low">Baixa</option>
                                    <option value="Medium">Média</option>
                                    <option value="High">Alta</option>
                                    <option value="Critical">Crítica</option>
                                </select>
                            </div>

                            <div>
                                <label className={labelClass}>Status Atual</label>
                                <select 
                                    name="status" 
                                    value={formData.status} 
                                    onChange={handleChange}
                                    className={inputClass}
                                >
                                    <option value="Open">Aberta</option>
                                    <option value="Investigating">Em Análise</option>
                                    <option value="Implementation">Implementação</option>
                                    <option value="Closed">Encerrada</option>
                                </select>
                            </div>

                            <div className="flex flex-col justify-end pb-2">
                                <label className="flex items-center cursor-pointer space-x-3 group">
                                    <div className="relative">
                                        <input 
                                            type="checkbox" 
                                            name="is_fca_trigger"
                                            checked={formData.is_fca_trigger === 1}
                                            onChange={handleChange}
                                            className="sr-only" 
                                        />
                                        <div className={`block w-10 h-6 rounded-full transition-colors ${formData.is_fca_trigger === 1 ? 'bg-purple-600' : 'bg-slate-700'}`}></div>
                                        <div className={`dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform ${formData.is_fca_trigger === 1 ? 'transform translate-x-4' : ''}`}></div>
                                    </div>
                                    <div className="text-sm text-slate-300 font-medium group-hover:text-white transition-colors">
                                        Requer FCA?
                                    </div>
                                </label>
                            </div>
                        </div>

                        {/* Metadata Oculto/Discreto */}
                        <div className="grid grid-cols-2 gap-4 border-t border-slate-800 pt-4">
                            <div>
                                <label className="block text-[10px] text-slate-600">ID Vinculado (Sistema)</label>
                                <input 
                                    type="text" 
                                    name="inspection_item_id"
                                    value={formData.inspection_item_id}
                                    readOnly
                                    className="w-full bg-transparent border-none text-slate-600 text-xs p-0 focus:ring-0"
                                />
                            </div>
                             <div>
                                <label className="block text-[10px] text-slate-600">Responsável ID</label>
                                <input 
                                    type="text" 
                                    name="responsavel_id"
                                    value={formData.responsavel_id}
                                    onChange={handleChange}
                                    className="w-full bg-transparent border-b border-slate-800 text-slate-500 text-xs py-0.5 focus:border-indigo-500 focus:ring-0"
                                />
                            </div>
                        </div>
                    </div>

                    {/* Footer */}
                    <div className="flex justify-end gap-3 pt-4 border-t border-slate-800">
                        <button 
                            type="button" 
                            onClick={onClose}
                            className="px-5 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-colors text-sm font-medium"
                        >
                            Cancelar
                        </button>
                        <button 
                            type="submit"
                            className="px-6 py-2.5 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white font-bold shadow-lg shadow-indigo-500/20 transition-all active:scale-[0.98] text-sm"
                        >
                            Salvar Ocorrência
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
};

export default NcFormModal;