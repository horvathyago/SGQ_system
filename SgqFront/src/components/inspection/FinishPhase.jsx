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
                onComplete();
            }, 2500);
        } catch (error) {
            console.error("Erro ao finalizar:", error);
            alert("Erro de comunicação ao finalizar inspeção.");
        } finally {
            setLoading(false);
        }
    };

    if (finished) {
        return (
            <div className="flex flex-col items-center justify-center py-20 animate-fade-in-up">
                <div className="w-24 h-24 rounded-full bg-emerald-500/10 flex items-center justify-center mb-6 shadow-[0_0_30px_rgba(16,185,129,0.2)]">
                    <svg className="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h2 className="text-3xl font-bold text-white mb-2">Inspeção Concluída</h2>
                <p className="text-slate-400">O relatório final foi gerado com sucesso.</p>
                <p className="text-xs text-slate-600 mt-8">Redirecionando para o início...</p>
            </div>
        );
    }

    return (
        <div className="max-w-2xl mx-auto">
            <div className="bg-slate-900 border border-slate-800 rounded-xl p-10 text-center shadow-lg">
                <div className="w-16 h-16 bg-indigo-500/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg className="w-8 h-8 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>

                <h2 className="text-2xl font-bold text-white mb-4">
                    Confirmar Encerramento
                </h2>

                <p className="text-slate-300 text-lg mb-8 leading-relaxed">
                    Você completou todas as etapas do protocolo <span className="font-mono text-indigo-300">#{inspectionId}</span>. 
                    Ao confirmar, os dados serão congelados para auditoria.
                </p>

                <div className="bg-amber-950/20 border border-amber-900/30 p-4 rounded-lg text-left text-sm text-amber-200/80 mb-8 flex gap-3">
                    <svg className="w-5 h-5 flex-shrink-0 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    <span>Atenção: Ações corretivas (NCs) geradas durante o processo permanecerão abertas até serem tratadas no módulo de Qualidade.</span>
                </div>

                <button
                    onClick={handleFinalize}
                    disabled={loading}
                    className="w-full sm:w-auto px-10 py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-lg shadow-xl shadow-indigo-500/20 transition-all transform hover:scale-[1.02] disabled:opacity-50 disabled:scale-100"
                >
                    {loading ? 'Finalizando Protocolo...' : 'Assinar e Finalizar'}
                </button>
            </div>
        </div>
    );
};

export default FinishPhase;