// src/pages/NonConformityPage.jsx
import React, { useEffect, useState } from 'react';
import Header from '../components/Dashboard/Header'; 
import Sidebar from '../components/Dashboard/Sidebar';
import NonConformityService from '../services/NonConformityService';
import NcList from '../components/NonConformity/NcList';
import NcFormModal from '../components/NonConformity/NcFormModal';

export default function NonConformityPage() {
    const [ncs, setNcs] = useState([]);
    const [loading, setLoading] = useState(true);
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [currentNc, setCurrentNc] = useState(null); 
    const [filters, setFilters] = useState({ period: '30d' });

    const loadData = async () => {
        setLoading(true);
        try {
            const data = await NonConformityService.getAll();
            setNcs(data);
        } catch (error) {
            console.error("Falha ao carregar NCs", error);
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        loadData();
    }, []);

    const handleAddNew = () => {
        setCurrentNc(null);
        setIsModalOpen(true);
    };

    const handleEdit = (nc) => {
        setCurrentNc(nc);
        setIsModalOpen(true);
    };

    const handleDelete = async (id) => {
        if (window.confirm("Confirmar exclusão deste registro de Não Conformidade?")) {
            try {
                await NonConformityService.delete(id);
                setNcs(prev => prev.filter(item => item.id !== id));
            } catch (error) {
                alert("Erro ao excluir: " + error.message);
            }
        }
    };

    const handleFormSubmit = async (formData) => {
        try {
            if (currentNc && currentNc.id) {
                await NonConformityService.update(currentNc.id, formData);
            } else {
                await NonConformityService.create(formData);
            }
            setIsModalOpen(false);
            loadData(); 
        } catch (error) {
            alert("Erro ao salvar: " + error.message);
        }
    };

    return (
        <div className="min-h-screen flex bg-slate-950 text-slate-200 font-sans">
            <Sidebar />

            <main className="pl-72 w-full transition-all duration-300">
                <div className="max-w-[1600px] mx-auto p-8">
                    
                    {/* Header Técnico */}
                    <header className="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8 border-b border-slate-800 pb-6">
                        <div>
                            <span className="text-xs font-bold text-rose-400 uppercase tracking-widest mb-1 block">Gestão da Qualidade</span>
                            <h1 className="text-3xl font-bold text-white tracking-tight">Não Conformidades</h1>
                            <p className="text-sm text-slate-400 mt-1">Registro, tratamento e disposição de ocorrências (RNC).</p>
                        </div>

                        <div className="flex items-center gap-3">
                            <button 
                                onClick={handleAddNew}
                                className="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white px-5 py-2.5 rounded-lg font-semibold shadow-lg shadow-indigo-500/20 transition-all active:scale-95"
                            >
                                <span className="text-lg leading-none mb-0.5">+</span>
                                <span>Abrir Ocorrência</span>
                            </button>
                        </div>
                    </header>

                    {/* Área de Filtros / Toolbar Rápida */}
                    <div className="bg-slate-900 border border-slate-800 rounded-t-xl p-4 flex items-center justify-between">
                         <div className="flex items-center gap-2 text-xs text-slate-500 font-medium uppercase tracking-wider">
                             <span>Status:</span>
                             <select className="bg-slate-950 border border-slate-700 rounded px-2 py-1 text-slate-300 focus:border-indigo-500">
                                 <option>Todos</option>
                                 <option>Abertos</option>
                                 <option>Em Análise</option>
                                 <option>Encerrados</option>
                             </select>
                         </div>
                         <div className="text-xs text-slate-500">
                             Total: <span className="text-white font-bold">{ncs.length}</span> registros
                         </div>
                    </div>

                    {/* Lista Principal */}
                    <div className="bg-slate-900 border-x border-b border-slate-800 rounded-b-xl overflow-hidden shadow-sm min-h-[400px]">
                        {loading ? (
                             <div className="flex flex-col items-center justify-center h-64">
                                <div className="w-8 h-8 border-4 border-indigo-500/30 border-t-indigo-500 rounded-full animate-spin mb-4"></div>
                                <span className="text-slate-500 text-sm">Carregando ocorrências...</span>
                             </div>
                        ) : (
                            <NcList 
                                data={ncs} 
                                onEdit={handleEdit} 
                                onDelete={handleDelete} 
                            />
                        )}
                    </div>
                </div>
            </main>

            {/* Modal */}
            {isModalOpen && (
                <NcFormModal 
                    isOpen={isModalOpen}
                    onClose={() => setIsModalOpen(false)}
                    onSubmit={handleFormSubmit}
                    initialData={currentNc}
                />
            )}
        </div>
    );
}