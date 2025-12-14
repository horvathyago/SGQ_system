// src/components/inspection/FinishPhase.jsx
import React, { useState } from 'react';
import InspectionService from '../../services/InspectionService';

const FinishPhase = ({ onComplete, inspectionId }) => {
    const [loading, setLoading] = useState(false);
    const [finished, setFinished] = useState(false);

    const handleFinalize = async () => {
        setLoading(true);
        try {
            await InspectionService.updateInspectionStatus(inspectionId, {
                status: 'CONCLUIDO',
                finished_at: new Date().toISOString()
            });
            setFinished(true);
            setTimeout(() => {
                onComplete(); // Reseta o gerenciador para estado inicial
            }, 2000);
        } catch (error) {
            console.error("Erro ao finalizar:", error);
            alert("Erro de comunicação ao finalizar inspeção.");
        } finally {
            setLoading(false);
        }
    };

    if (finished) {
        return (
            <div className="text-center py-10 animate-fade-in">
                <div className="inline-flex items-center justify-center w-20 h-20 bg-green-900 rounded-full mb-4">
                    <svg className="w-10 h-10 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h2 className="text-3xl font-bold text-white mb-2">Inspeção Concluída!</h2>
                <p className="text-gray-400">Redirecionando...</p>
            </div>
        );
    }

    return (
        <div className="bg-gray-800 p-8 rounded-lg shadow-xl text-center space-y-6 max-w-2xl mx-auto border border-gray-700">
            <h2 className="text-2xl font-bold text-white border-b border-gray-600 pb-4">
                Finalizar Inspeção <span className="text-red-500">#{inspectionId}</span>
            </h2>

            <p className="text-gray-300 text-lg">
                Você completou todas as etapas de verificação. Deseja encerrar o processo e gerar o relatório final?
            </p>

            <div className="bg-yellow-900/20 border-l-4 border-yellow-500 text-left p-4 rounded text-yellow-200 text-sm">
                <strong>Atenção:</strong> Após finalizar, não será possível editar os itens inspecionados sem reabrir uma solicitação administrativa.
            </div>

            <div className="pt-4">
                <button
                    onClick={handleFinalize}
                    disabled={loading}
                    className="w-full sm:w-auto px-8 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg shadow-lg transition-transform transform hover:scale-105 disabled:opacity-50 disabled:scale-100"
                >
                    {loading ? 'Processando Fechamento...' : 'Confirmar e Finalizar'}
                </button>
            </div>
        </div>
    );
};

export default FinishPhase;