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
                console.error("Erro ao carregar listas:", err);
                setError("Falha na conexão com o servidor.");
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
            const newInspection = await InspectionService.createInspection({
                checklist_template_id: selectedTemplate,
                item_master_id: selectedMaster || null,
                inspector_id: user?.id,
                status: 'EM_ANDAMENTO',
                origem: 'REACT_APP'
            });

            onComplete({
                inspectionId: newInspection.id,
                checklistTemplateId: selectedTemplate,
                itemMasterId: selectedMaster
            });
        } catch (err) {
            console.error(err);
            setError("Erro crítico ao criar registro. Tente novamente.");
        } finally {
            setLoading(false);
        }
    };

    if (loadingLists) return <div className="p-8 text-center text-slate-500 animate-pulse text-sm">Carregando parâmetros do sistema...</div>;

    return (
        <div className="max-w-2xl mx-auto">
            <div className="bg-slate-900 rounded-xl border border-slate-800 shadow-sm p-8">
                <div className="mb-6">
                    <h2 className="text-xl font-bold text-white">Parâmetros da Inspeção</h2>
                    <p className="text-sm text-slate-400 mt-1">Defina o escopo para gerar o checklist dinâmico.</p>
                </div>

                {error && (
                    <div className="mb-6 p-4 bg-rose-950/30 border border-rose-900/50 rounded-lg flex items-center gap-3">
                         <svg className="w-5 h-5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                         <span className="text-sm text-rose-300 font-medium">{error}</span>
                    </div>
                )}

                <div className="space-y-6">
                    <div>
                        <label className="block text-[10px] uppercase font-bold text-slate-500 tracking-wider mb-2">Checklist Template *</label>
                        <select 
                            className="w-full bg-slate-950 border border-slate-700 text-slate-200 rounded-lg p-3 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                            value={selectedTemplate}
                            onChange={(e) => setSelectedTemplate(e.target.value)}
                        >
                            <option value="">Selecione um modelo...</option>
                            {templates.map(t => (
                                <option key={t.id} value={t.id}>{t.titulo || t.nome || `Template #${t.id}`}</option>
                            ))}
                        </select>
                    </div>

                    <div>
                        <label className="block text-[10px] uppercase font-bold text-slate-500 tracking-wider mb-2">Item / Part Number (Opcional)</label>
                        <select 
                            className="w-full bg-slate-950 border border-slate-700 text-slate-200 rounded-lg p-3 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                            value={selectedMaster}
                            onChange={(e) => setSelectedMaster(e.target.value)}
                        >
                            <option value="">Genérico / Avulso</option>
                            {itemMasters.map(m => (
                                <option key={m.id} value={m.id}>{m.codigo} - {m.nome}</option>
                            ))}
                        </select>
                    </div>

                    <div className="pt-4">
                        <button
                            onClick={handleStart}
                            disabled={!selectedTemplate || loading}
                            className="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-3.5 rounded-lg shadow-lg shadow-indigo-500/20 disabled:opacity-50 disabled:cursor-not-allowed transition-all active:scale-[0.99]"
                        >
                            {loading ? (
                                <span className="flex items-center justify-center gap-2">
                                    <svg className="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4"></circle><path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Inicializando...
                                </span>
                            ) : 'Iniciar Execução'}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default StartPhase;