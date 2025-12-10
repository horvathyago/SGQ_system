// src/pages/InspectionManagerPage.jsx (Revisão da Estrutura)

import React, { useState, useCallback, useMemo } from 'react';
import { useAuth } from '../context/AuthContext'; 

// 🎯 Importações corrigidas: Assumindo que você criou os arquivos dos componentes de fase
import StartPhase from '../components/inspection/StartPhase'; 
import InspectionPhase from '../components/inspection/InspectionPhase'; 
import FinishPhase from '../components/inspection/FinishPhase'; 

// Definindo a ordem das fases baseada no documento
const PHASES_LIST = [
    { index: 0, id: 'PHASE_0_START', name: 'Início: Seleção do Item' },
    { index: 1, id: 'PHASE_1_DOCS', name: 'Fase 1: Documental e Rastreabilidade' },
    { index: 2, id: 'PHASE_2_PREP', name: 'Fase 2: Preparação e Ferramental' },
    { index: 3, id: 'PHASE_3_DIMENSIONAL', name: 'Fase 3: Inspeção Dimensional' },
    { index: 4, id: 'PHASE_4_VISUAL_NDT', name: 'Fase 4: Inspeção Visual e NDT' },
    { index: 5, id: 'PHASE_5_FINAL_RELEASE', name: 'Fase 5: Revisão e Liberação Final' },
    { index: 6, id: 'PHASE_6_FINISH', name: 'Concluir Inspeção' }, 
];

const InspectionManagerPage = () => {
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
                return <div className="error-message">Erro: Inspeção não iniciada. Retorne à Fase 0.</div>;
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
        
        return <div>Fase Desconhecida ou Incompleta.</div>;

    }, [currentPhase, nextPhase, inspectionData, isInspectionStarted, user, currentPhaseIndex]);


    return (
        <div className="inspection-manager-container">
            <header>
                <h1>{currentPhase.name}</h1>
                <p>Progresso: **{currentPhaseIndex + 1} de {PHASES_LIST.length}**</p>
                <p>Inspeção N°: **{inspectionData.inspectionId || 'Aguardando Início'}**</p>
                <hr />
            </header>
            
            <section className="phase-content">
                {renderCurrentPhase}
            </section>
        </div>
    );
};

export default InspectionManagerPage;