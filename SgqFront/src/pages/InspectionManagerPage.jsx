// src/pages/InspectionManagerPage.jsx (Estilizado e Corrigido)

import React, { useState, useCallback, useMemo } from 'react';
import { useAuth } from '../context/AuthContext';

// 🚨 CORREÇÃO APLICADA AQUI
import StartPhase from '../components/inspection/StartPhase';
import InspectionPhase from '../components/inspection/InspectionPhase';
import FinishPhase from '../components/inspection/FinishPhase';


const PHASES_LIST = [
    // ... (Lista de Fases)
    { index: 0, id: 'PHASE_0_START', name: 'Início: Seleção do Item' },
    { index: 1, id: 'PHASE_1_DOCS', name: 'Fase 1: Documental e Rastreabilidade' },
    { index: 2, id: 'PHASE_2_PREP', name: 'Fase 2: Preparação e Ferramental' },
    { index: 3, id: 'PHASE_3_DIMENSIONAL', name: 'Fase 3: Inspeção Dimensional' },
    { index: 4, id: 'PHASE_4_VISUAL_NDT', name: 'Fase 4: Inspeção Visual e NDT' },
    { index: 5, id: 'PHASE_5_FINAL_RELEASE', name: 'Fase 5: Revisão e Liberação Final' },
    { index: 6, id: 'PHASE_6_FINISH', name: 'Concluir Inspeção' },
];

const InspectionManagerPage = () => {
    // ... (restante da lógica mantida)
    const { user } = useAuth();

    const [currentPhaseIndex, setCurrentPhaseIndex] = useState(0);

    const [inspectionData, setInspectionData] = useState({
        itemMasterId: null,
        checklistTemplateId: null,
        inspectionId: null,
    });

    const currentPhase = PHASES_LIST[currentPhaseIndex];
    const isInspectionStarted = inspectionData.inspectionId !== null;

    const nextPhase = useCallback((data = {}) => {
        setInspectionData(prev => ({ ...prev, ...data }));

        if (currentPhaseIndex < PHASES_LIST.length - 1) {
            setCurrentPhaseIndex(prev => prev + 1);
        } else {
            alert("Processo de Inspeção Concluído!");
            setInspectionData({
                itemMasterId: null,
                checklistTemplateId: null,
                inspectionId: null,
            });
            setCurrentPhaseIndex(0);
        }
    }, [currentPhaseIndex]);


    const renderCurrentPhase = useMemo(() => {
        // ... (Lógica de renderização de fases mantida)
        // Fase 0: Seleção e Criação do Cabeçalho
        if (currentPhase.id === 'PHASE_0_START') {
            return (
                <StartPhase
                    onComplete={nextPhase}
                    user={user}
                    inspectionData={inspectionData}
                />
            );
        }

        // Fase Final: Confirmação
        if (currentPhase.id === 'PHASE_6_FINISH') {
            return (
                <FinishPhase
                    onComplete={nextPhase}
                    inspectionId={inspectionData.inspectionId}
                />
            );
        }

        // Fases de Checklist (1 a 5)
        if (currentPhaseIndex >= 1 && currentPhaseIndex <= 5) {

            if (!isInspectionStarted) {
                return <div className="p-4 bg-red-900/30 text-red-400 rounded-lg">Erro: Inspeção não iniciada. Retorne à Fase 0.</div>;
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
        }

        return <div className="text-gray-400">Fase Desconhecida ou Incompleta.</div>;

    }, [currentPhase, nextPhase, inspectionData, isInspectionStarted, user, currentPhaseIndex]);


    return (
        // Estilização do contêiner principal para o fundo escuro (como na LoginPage)
        <div className="min-h-screen bg-gray-900 text-white p-8">
            <div className="max-w-4xl mx-auto bg-gray-800 p-8 rounded-xl shadow-2xl">

                <header className="mb-8 border-b border-red-700/50 pb-4">
                    {/* Título e Progresso com destaque da cor vermelha */}
                    <h1 className="text-3xl font-bold tracking-tight text-white mb-2">{currentPhase.name}</h1>
                    <p className="text-sm font-semibold text-red-500 mb-1">
                        Progresso: <span className="text-white font-bold">{currentPhaseIndex + 1} de {PHASES_LIST.length}</span>
                    </p>
                    <p className="text-sm text-gray-400">
                        Inspeção N°: <span className="font-mono text-red-400">{inspectionData.inspectionId || 'Aguardando Início'}</span>
                    </p>
                </header>

                <section className="phase-content">
                    {renderCurrentPhase}
                </section>

                <footer className="mt-8 pt-4 border-t border-gray-700 text-center text-xs text-gray-600">
                    SGQ Inspeção de Qualidade
                </footer>
            </div>
        </div>
    );
};

export default InspectionManagerPage;