// src/components/inspection/FinishPhase.jsx (Estrutura)
import React, { useState } from 'react';
import InspectionService from '../../services/InspectionService';

const FinishPhase = ({ onComplete, inspectionId }) => {
    const [loading, setLoading] = useState(false);

    const handleFinalize = async () => {
        setLoading(true);
        try {
            // PATCH: Atualizar o Status para CONCLUIDO ou REPROVADO
            await InspectionService.updateInspectionStatus(inspectionId, {
                status: 'CONCLUIDO', // Ou 'REPROVADO' dependendo do resultado geral
                // ... outras observações finais
            });
            
            // Avança para a última etapa (que reinicia o processo ou navega)
            onComplete(); 
            
        } catch (error) {
            console.error("Erro ao finalizar a inspeção:", error);
            alert("Erro ao finalizar a inspeção. Tente novamente.");
            setLoading(false);
        }
    };

    return (
        <div className="review-summary">
            <h2>Revisão Final da Inspeção #{inspectionId}</h2>
            {/* Aqui você pode buscar e exibir um resumo dos resultados */}
            
            <p>Todos os passos foram concluídos. Confirme a finalização e o status final do produto.</p>
            
            <button onClick={handleFinalize} disabled={loading}>
                {loading ? 'Finalizando...' : 'Concluir e Liberar Produto'}
            </button>
        </div>
    );
};

export default FinishPhase;