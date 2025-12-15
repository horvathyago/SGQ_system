// src/pages/NonConformityPage.jsx
import React, { useEffect, useState } from 'react';
import Header from '../components/Dashboard/Header'; // Reutilizando seu Header
import Sidebar from '../components/Dashboard/Sidebar'; // Reutilizando sua Sidebar
import NonConformityService from '../services/NonConformityService';
import NcList from '../components/NonConformity/NcList';
import NcFormModal from '../components/NonConformity/NcFormModal';

export default function NonConformityPage() {
    const [ncs, setNcs] = useState([]);
    const [loading, setLoading] = useState(true);
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [currentNc, setCurrentNc] = useState(null); // Se null, é criação. Se objeto, é edição.
    
    // Filtros visuais (estado local apenas para exemplo, ou passados para a API)
    const [filters, setFilters] = useState({ period: '30d' });

    // Carregar dados
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

    // Handlers
    const handleAddNew = () => {
        setCurrentNc(null);
        setIsModalOpen(true);
    };

    const handleEdit = (nc) => {
        setCurrentNc(nc);
        setIsModalOpen(true);
    };

    const handleDelete = async (id) => {
        if (window.confirm("Tem certeza que deseja excluir esta Não Conformidade?")) {
            try {
                await NonConformityService.delete(id);
                // Atualiza lista localmente para evitar reload
                setNcs(prev => prev.filter(item => item.id !== id));
            } catch (error) {
                alert("Erro ao excluir: " + error.message);
            }
        }
    };

    const handleFormSubmit = async (formData) => {
        try {
            if (currentNc && currentNc.id) {
                // Edição
                await NonConformityService.update(currentNc.id, formData);
            } else {
                // Criação
                await NonConformityService.create(formData);
            }
            setIsModalOpen(false);
            loadData(); // Recarrega a lista para garantir dados frescos
        } catch (error) {
            alert("Erro ao salvar: " + error.message);
        }
    };

    return (
        <div className="min-h-screen flex bg-neutral-900 text-gray-100 font-sans">
            <Sidebar />

            <div className="flex-1 p-6 flex flex-col">
                <Header 
                    onApplyFilters={(f) => setFilters({...filters, ...f})} 
                    filters={filters} 
                    title="Gestão de Não Conformidades"
                />

                <div className="mt-8 flex justify-between items-center">
                    <h2 className="text-xl font-bold text-gray-200">
                        Registros de Ocorrências
                    </h2>
                    <button 
                        onClick={handleAddNew}
                        className="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded shadow transition-colors flex items-center gap-2"
                    >
                        <span>+ Nova NC</span>
                    </button>
                </div>

                <div className="mt-6 flex-1 bg-[#0f1720] rounded-xl border border-white/5 shadow p-4 overflow-hidden">
                    {loading ? (
                        <div className="text-center py-10 text-gray-400">Carregando dados...</div>
                    ) : (
                        <NcList 
                            data={ncs} 
                            onEdit={handleEdit} 
                            onDelete={handleDelete} 
                        />
                    )}
                </div>
            </div>

            {/* Modal de Formulário */}
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