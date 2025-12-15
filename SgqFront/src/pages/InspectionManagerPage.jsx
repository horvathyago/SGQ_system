// src/pages/InspectionManagerPage.jsx
import React, { useState, useCallback, useMemo } from 'react';
import { useAuth } from '../context/AuthContext'; 
// Ajuste o caminho conforme sua estrutura real
import Sidebar from '../components/Dashboard/Sidebar'; 
import StartPhase from '../components/inspection/StartPhase';
import InspectionPhase from '../components/inspection/InspectionPhase';
import FinishPhase from '../components/inspection/FinishPhase';

const PHASES_LIST = [
    { index: 0, id: 'PHASE_0_START', name: 'Configuração' },
    { index: 1, id: 'PHASE_1_DOCS', name: 'Documental' },
    { index: 2, id: 'PHASE_2_PREP', name: 'Preparação' },
    { index: 3, id: 'PHASE_3_DIMENSIONAL', name: 'Dimensional' },
    { index: 4, id: 'PHASE_4_VISUAL_NDT', name: 'Visual / NDT' },
    { index: 5, id: 'PHASE_5_FINAL_RELEASE', name: 'Liberação' },
    { index: 6, id: 'PHASE_6_FINISH', name: 'Conclusão' },
];

const InspectionManagerPage = () => {
    const { user } = useAuth();
    
    // Estado Global
    const [currentPhaseIndex, setCurrentPhaseIndex] = useState(0);
    const [inspectionData, setInspectionData] = useState({
        inspectionId: null,
        checklistTemplateId: null,
        itemMasterId: null,
    });

    const currentPhase = PHASES_LIST[currentPhaseIndex];

    const nextPhase = useCallback((dataFromPhase = {}) => {
        if (dataFromPhase.inspectionId) {
            setInspectionData(prev => ({ ...prev, ...dataFromPhase }));
        }

        if (currentPhaseIndex < PHASES_LIST.length - 1) {
            setCurrentPhaseIndex(prev => prev + 1);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        } else {
            setInspectionData({ inspectionId: null, checklistTemplateId: null, itemMasterId: null });
            setCurrentPhaseIndex(0);
        }
    }, [currentPhaseIndex]);

    const renderPhaseContent = useMemo(() => {
        if (currentPhase.id === 'PHASE_0_START') {
            return <StartPhase onComplete={nextPhase} user={user} inspectionData={inspectionData} />;
        }
        if (currentPhase.id === 'PHASE_6_FINISH') {
            return <FinishPhase onComplete={nextPhase} inspectionId={inspectionData.inspectionId} />;
        }
        if (!inspectionData.inspectionId) {
            return (
                <div className="flex flex-col items-center justify-center h-64 border border-dashed border-slate-800 rounded-xl bg-slate-900/50 text-slate-500">
                    <p>Erro de fluxo: Inspeção não inicializada.</p>
                    <button onClick={() => setCurrentPhaseIndex(0)} className="mt-4 text-indigo-400 hover:text-indigo-300 text-sm font-medium">Voltar ao início</button>
                </div>
            );
        }
        return (
            <InspectionPhase
                key={currentPhase.id}
                phaseId={currentPhase.id}
                phaseName={currentPhase.name}
                inspectionId={inspectionData.inspectionId}
                checklistTemplateId={inspectionData.checklistTemplateId}
                onComplete={nextPhase}
            />
        );
    }, [currentPhase, nextPhase, inspectionData, user]);

    return (
        <div className="min-h-screen bg-slate-950 text-slate-200 font-sans">
            <Sidebar />

            {/* Margem esquerda para compensar Sidebar Fixa */}
            <div className="pl-72 transition-all duration-300">
                <div className="max-w-5xl mx-auto p-8">
                    
                    {/* Header de Contexto */}
                    <header className="mb-8 flex items-end justify-between border-b border-slate-800 pb-6">
                        <div>
                            <span className="text-xs font-bold text-indigo-400 uppercase tracking-widest mb-1 block">Workflow de Inspeção</span>
                            <h1 className="text-3xl font-bold text-white tracking-tight">{currentPhase.name}</h1>
                        </div>
                        
                        <div className="text-right">
                             {inspectionData.inspectionId ? (
                                <div className="flex items-center gap-3 bg-slate-900 border border-slate-800 px-4 py-2 rounded-lg">
                                    <div className="text-right">
                                        <span className="block text-[10px] text-slate-500 uppercase font-bold">Protocolo</span>
                                        <span className="block text-sm font-mono text-indigo-300">#{inspectionData.inspectionId}</span>
                                    </div>
                                </div>
                             ) : (
                                 <span className="text-sm text-slate-500">Nova Inspeção</span>
                             )}
                        </div>
                    </header>

                    {/* Stepper Visual */}
                    <div className="mb-10 overflow-x-auto pb-2">
                        <div className="flex items-center min-w-max">
                            {PHASES_LIST.map((phase, idx) => {
                                const active = idx === currentPhaseIndex;
                                const completed = idx < currentPhaseIndex;
                                return (
                                    <div key={phase.id} className="flex items-center">
                                        <div className={`flex items-center gap-2 px-3 py-2 rounded-md text-sm font-medium transition-colors ${
                                            active ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 
                                            completed ? 'text-emerald-400 bg-emerald-500/5 border border-emerald-500/20' : 'text-slate-600'
                                        }`}>
                                            <span className={`flex items-center justify-center w-5 h-5 rounded-full text-[10px] ${
                                                active ? 'bg-white text-indigo-600' : 
                                                completed ? 'bg-emerald-500 text-black' : 'bg-slate-800 text-slate-500'
                                            }`}>
                                                {completed ? '✓' : idx + 1}
                                            </span>
                                            <span className="whitespace-nowrap">{phase.name}</span>
                                        </div>
                                        {idx < PHASES_LIST.length - 1 && (
                                            <div className={`w-8 h-px mx-2 ${completed ? 'bg-emerald-500/30' : 'bg-slate-800'}`}></div>
                                        )}
                                    </div>
                                );
                            })}
                        </div>
                    </div>

                    {/* Conteúdo da Fase */}
                    <main className="animate-fade-in-up">
                        {renderPhaseContent}
                    </main>

                    <footer className="mt-16 text-center border-t border-slate-800/50 pt-6">
                        <p className="text-xs text-slate-600 font-medium uppercase tracking-wider">QualityCore Enterprise OS &copy; 2025</p>
                    </footer>
                </div>
            </div>
        </div>
    );
};

export default InspectionManagerPage;