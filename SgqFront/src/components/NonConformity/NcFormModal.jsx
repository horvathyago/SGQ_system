// src/components/NonConformity/NcFormModal.jsx
import React, { useState, useEffect } from 'react';

const NcFormModal = ({ isOpen, onClose, onSubmit, initialData }) => {
    const [formData, setFormData] = useState({
        description: '',
        details: '',
        status: 'Open',
        severity: 'Medium', // Low, Medium, High, Critical
        inspection_item_id: '',
        responsavel_id: ''
    });

    useEffect(() => {
        if (initialData) {
            setFormData({
                description: initialData.description || '',
                details: initialData.details || '',
                status: initialData.status || 'Open',
                severity: initialData.severity || 'Medium',
                inspection_item_id: initialData.inspection_item_id || '',
                responsavel_id: initialData.responsavel_id || ''
            });
        }
    }, [initialData]);

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({ ...prev, [name]: value }));
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        onSubmit(formData);
    };

    if (!isOpen) return null;

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm">
            <div className="bg-gray-800 border border-gray-700 rounded-lg shadow-2xl w-full max-w-lg overflow-hidden animate-fade-in-up">
                
                {/* Header do Modal */}
                <div className="bg-gray-900 px-6 py-4 border-b border-gray-700 flex justify-between items-center">
                    <h3 className="text-lg font-bold text-white">
                        {initialData ? 'Editar Não Conformidade' : 'Nova Não Conformidade'}
                    </h3>
                    <button onClick={onClose} className="text-gray-400 hover:text-white text-2xl">&times;</button>
                </div>

                {/* Corpo do Formulário */}
                <form onSubmit={handleSubmit} className="p-6 space-y-4">
                    
                    {/* Descrição Curta */}
                    <div>
                        <label className="block text-sm font-medium text-gray-400 mb-1">Resumo do Problema</label>
                        <input 
                            type="text" 
                            name="description"
                            value={formData.description}
                            onChange={handleChange}
                            required
                            className="w-full bg-gray-900 border border-gray-700 text-gray-200 rounded px-3 py-2 focus:outline-none focus:border-red-500"
                            placeholder="Ex: Falha dimensional no eixo X"
                        />
                    </div>

                    {/* Detalhes / Texto Longo */}
                    <div>
                        <label className="block text-sm font-medium text-gray-400 mb-1">Detalhamento Técnico</label>
                        <textarea 
                            name="details"
                            value={formData.details}
                            onChange={handleChange}
                            rows="3"
                            className="w-full bg-gray-900 border border-gray-700 text-gray-200 rounded px-3 py-2 focus:outline-none focus:border-red-500"
                        ></textarea>
                    </div>

                    <div className="grid grid-cols-2 gap-4">
                        {/* Severidade */}
                        <div>
                            <label className="block text-sm font-medium text-gray-400 mb-1">Severidade</label>
                            <select 
                                name="severity" 
                                value={formData.severity} 
                                onChange={handleChange}
                                className="w-full bg-gray-900 border border-gray-700 text-gray-200 rounded px-3 py-2 focus:outline-none focus:border-red-500"
                            >
                                <option value="Low">Baixa</option>
                                <option value="Medium">Média</option>
                                <option value="High">Alta</option>
                                <option value="Critical">Crítica</option>
                            </select>
                        </div>

                        {/* Status */}
                        <div>
                            <label className="block text-sm font-medium text-gray-400 mb-1">Status</label>
                            <select 
                                name="status" 
                                value={formData.status} 
                                onChange={handleChange}
                                className="w-full bg-gray-900 border border-gray-700 text-gray-200 rounded px-3 py-2 focus:outline-none focus:border-red-500"
                            >
                                <option value="Open">Aberta</option>
                                <option value="Investigating">Em Análise</option>
                                <option value="Closed">Encerrada</option>
                            </select>
                        </div>
                    </div>

                    {/* IDs Relacionados (Simulados como Input Texto por enquanto) */}
                    <div className="grid grid-cols-2 gap-4">
                        <div>
                            <label className="block text-sm font-medium text-gray-400 mb-1">ID Item Inspeção</label>
                            <input 
                                type="number" 
                                name="inspection_item_id"
                                value={formData.inspection_item_id}
                                onChange={handleChange}
                                className="w-full bg-gray-900 border border-gray-700 text-gray-200 rounded px-3 py-2"
                            />
                        </div>
                         <div>
                            <label className="block text-sm font-medium text-gray-400 mb-1">ID Responsável</label>
                            <input 
                                type="number" 
                                name="responsavel_id"
                                value={formData.responsavel_id}
                                onChange={handleChange}
                                className="w-full bg-gray-900 border border-gray-700 text-gray-200 rounded px-3 py-2"
                            />
                        </div>
                    </div>

                    {/* Footer com Botões */}
                    <div className="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-700">
                        <button 
                            type="button" 
                            onClick={onClose}
                            className="px-4 py-2 rounded text-gray-300 hover:text-white hover:bg-gray-700 transition"
                        >
                            Cancelar
                        </button>
                        <button 
                            type="submit"
                            className="px-4 py-2 rounded bg-red-600 hover:bg-red-700 text-white font-medium shadow-lg shadow-red-900/50 transition"
                        >
                            Salvar Registro
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
};

export default NcFormModal;