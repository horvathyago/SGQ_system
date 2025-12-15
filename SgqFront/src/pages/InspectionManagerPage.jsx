// src/pages/InspectionManagerPage.jsx
import React, { useState, useCallback, useMemo } from 'react';
import { useAuth } from '../context/AuthContext'; 
import Sidebar from '../components/Dashboard/Sidebar'; // 1. Importar a Sidebar
import StartPhase from '../components/inspection/StartPhase';
import InspectionPhase from '../components/inspection/InspectionPhase';
import FinishPhase from '../components/inspection/FinishPhase';

const PHASES_LIST = [
    { index: 0, id: 'PHASE_0_START', name: 'Início: Configuração' },
    { index: 1, id: 'PHASE_1_DOCS', name: '1. Documental e Rastreabilidade' },
    { index: 2, id: 'PHASE_2_PREP', name: '2. Preparação e Ferramental' },
    { index: 3, id: 'PHASE_3_DIMENSIONAL', name: '3. Inspeção Dimensional' },
    { index: 4, id: 'PHASE_4_VISUAL_NDT', name: '4. Inspeção Visual e NDT' },
    { index: 5, id: 'PHASE_5_FINAL_RELEASE', name: '5. Revisão e Liberação' },
    { index: 6, id: 'PHASE_6_FINISH', name: 'Conclusão' },
];

const InspectionManagerPage = () => {
    const { user } = useAuth();
    
    // Estado Global da Inspeção Atual
    const [currentPhaseIndex, setCurrentPhaseIndex] = useState(0);
    const [inspectionData, setInspectionData] = useState({
        inspectionId: null,
        checklistTemplateId: null,
        itemMasterId: null,
    });

    const currentPhase = PHASES_LIST[currentPhaseIndex];

    // Avança para a próxima fase ou reseta se acabou
    const nextPhase = useCallback((dataFromPhase = {}) => {
        // Atualiza dados acumulados (ex: StartPhase retorna IDs)
        if (dataFromPhase.inspectionId) {
            setInspectionData(prev => ({ ...prev, ...dataFromPhase }));
        }

        if (currentPhaseIndex < PHASES_LIST.length - 1) {
            setCurrentPhaseIndex(prev => prev + 1);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        } else {
            // Fim do ciclo, reseta
            setInspectionData({ inspectionId: null, checklistTemplateId: null, itemMasterId: null });
            setCurrentPhaseIndex(0);
        }
    }, [currentPhaseIndex]);

    // Renderização Condicional da Fase Ativa
    const renderPhaseContent = useMemo(() => {
        // 1. Fase Inicial
        if (currentPhase.id === 'PHASE_0_START') {
            return (
                <StartPhase 
                    onComplete={nextPhase} 
                    user={user} 
                    inspectionData={inspectionData} 
                />
            );
        }

        // 2. Fase Final
        if (currentPhase.id === 'PHASE_6_FINISH') {
            return (
                <FinishPhase 
                    onComplete={nextPhase} 
                    inspectionId={inspectionData.inspectionId} 
                />
            );
        }

        // 3. Fases de Checklist (Intermediárias)
        if (!inspectionData.inspectionId) {
            return (
                <div className="text-center p-10 bg-red-900/20 rounded border border-red-800 text-red-300">
                    <p>Erro de fluxo: Inspeção não inicializada.</p>
                    <button onClick={() => setCurrentPhaseIndex(0)} className="mt-4 underline">Voltar ao início</button>
                </div>
            );
        }

        return (
            <InspectionPhase
                key={currentPhase.id} // Força remontagem ao mudar de fase
                phaseId={currentPhase.id}
                phaseName={currentPhase.name}
                inspectionId={inspectionData.inspectionId}
                checklistTemplateId={inspectionData.checklistTemplateId}
                onComplete={nextPhase}
            />
        );
    }, [currentPhase, nextPhase, inspectionData, user]);

    return (
        // 2. Layout Flex Container (Igual ao Dashboard/NC Page)
        <div className="min-h-screen flex bg-neutral-900 text-gray-100 font-sans">
            
            {/* 3. Inserção da Sidebar fixa à esquerda */}
            <Sidebar />

            {/* 4. Área de Conteúdo Principal (Cresce para ocupar o resto da tela) */}
            <div className="flex-1 p-6 overflow-y-auto h-screen">
                <div className="max-w-5xl mx-auto">
                    
                    {/* Header da Inspeção (Mantido o estilo, mas agora dentro do container fluido) */}
                    <header className="mb-8 bg-gray-800 p-6 rounded-xl shadow-lg border-l-8 border-red-600 flex justify-between items-center flex-wrap gap-4">
                        <div>
                            <h1 className="text-2xl md:text-3xl font-bold text-white">{currentPhase.name}</h1>
                            <p className="text-gray-400 text-sm mt-1">
                                Sistema de Gestão de Qualidade Integrada
                            </p>
                        </div>
                        
                        <div className="text-right">
                            {inspectionData.inspectionId && (
                                <div className="bg-gray-700 px-4 py-2 rounded-lg mb-2">
                                    <span className="text-xs text-gray-400 uppercase tracking-wider block">ID Inspeção</span>
                                    <span className="font-mono text-xl text-red-400 font-bold">#{inspectionData.inspectionId}</span>
                                </div>
                            )}
                            <div className="text-sm font-medium text-gray-400">
                                Etapa <span className="text-white">{currentPhaseIndex + 1}</span> de {PHASES_LIST.length}
                            </div>
                        </div>
                    </header>

                    {/* Área de Conteúdo da Fase (Start, Checklist, Finish) */}
                    <main className="transition-all duration-500 ease-in-out pb-10">
                        {renderPhaseContent}
                    </main>

                    {/* Footer interno */}
                    <footer className="mt-8 text-center text-gray-600 text-xs border-t border-gray-800 pt-4">
                        &copy; 2025 Engenharia de Qualidade. Todos os direitos reservados.
                    </footer>
                </div>
            </div>
        </div>
    );
};

export default InspectionManagerPage;