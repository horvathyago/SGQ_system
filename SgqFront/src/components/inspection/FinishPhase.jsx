// src/components/inspection/FinishPhase.jsx (Estilizado)
import React, { useState } from 'react';
import InspectionService from '../../services/InspectionService';

const FinishPhase = ({ onComplete, inspectionId }) => {
    const [loading, setLoading] = useState(false);

    const handleFinalize = async () => {
        setLoading(true);
        try {
            // PATCH: Atualizar o Status para CONCLUIDO
            await InspectionService.updateInspectionStatus(inspectionId, {
                status: 'CONCLUIDO',
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
        // 🚨 NOVO: Contêiner com foco e espaçamento
        <div className="review-summary bg-gray-700 p-8 rounded-lg shadow-xl text-center space-y-6">

            <h2 className="text-2xl font-bold text-white tracking-tight border-b border-gray-600 pb-3">
                Revisão Final da Inspeção #<span className="text-red-500">{inspectionId}</span>
            </h2>

            {/* Mensagem de Confirmação */}
            <p className="text-lg text-gray-300">
                Todos os passos foram concluídos. Você está prestes a **Finalizar** o processo e liberar o produto.
            </p>

            {/* Aviso/Sugestão de Revisão */}
            <div className="p-4 bg-gray-600/50 border-l-4 border-red-500 text-gray-300 text-sm italic">
                Verifique se todos os relatórios e evidências foram anexados antes de clicar em Concluir.
            </div>

            {/* 🚨 NOVO: Estilo do Botão Principal (Vermelho, em destaque) */}
            <button
                onClick={handleFinalize}
                disabled={loading}
                className="w-full sm:w-auto flex justify-center items-center mx-auto px-8 py-3 border border-transparent rounded-lg shadow-lg text-base font-medium text-white bg-red-600 hover:bg-red-700 disabled:bg-red-900 disabled:opacity-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-300"
            >
                {loading ? (
                    <>
                        <div className="w-4 h-4 border-2 border-white border-t-red-200 rounded-full animate-spin mr-2"></div>
                        Finalizando Inspeção...
                    </>
                ) : (
                    'Concluir e Liberar Produto'
                )}
            </button>
        </div>
    );
};

export default FinishPhase;