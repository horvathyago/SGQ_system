// src/components/NonConformity/NcList.jsx
import React from 'react';

const NcList = ({ data, onEdit, onDelete }) => {
    if (!data || data.length === 0) {
        return (
            <div className="p-12 text-center flex flex-col items-center justify-center opacity-60">
                <svg className="w-12 h-12 text-slate-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p className="text-slate-400 font-medium">Nenhuma não conformidade registrada.</p>
            </div>
        );
    }

    // Helper para cores de severidade (Estilo Badge Sutil)
    const getSeverityStyle = (level) => {
        const lvl = String(level).toLowerCase();
        if (lvl === 'critical') return 'bg-rose-500/10 text-rose-400 border-rose-500/20';
        if (lvl === 'high') return 'bg-orange-500/10 text-orange-400 border-orange-500/20';
        if (lvl === 'medium') return 'bg-amber-500/10 text-amber-400 border-amber-500/20';
        return 'bg-blue-500/10 text-blue-400 border-blue-500/20'; // Low
    };

    const getStatusStyle = (status) => {
        const s = String(status).toLowerCase();
        if (s === 'open') return 'bg-rose-500/10 text-rose-400 border-rose-500/20';
        if (s === 'closed') return 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20';
        return 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20'; // Investigating / Implementation
    };

    return (
        <div className="overflow-x-auto">
            <table className="w-full text-left border-collapse">
                <thead>
                    <tr className="bg-slate-950/50 border-b border-slate-800">
                        <th className="p-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider">ID / Severidade</th>
                        <th className="p-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Descrição da Falha</th>
                        <th className="p-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Contexto (Origem)</th>
                        <th className="p-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th className="p-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Data</th>
                        <th className="p-4 text-right text-[10px] font-bold text-slate-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody className="divide-y divide-slate-800/50">
                    {data.map((row) => (
                        <tr key={row.id} className="hover:bg-slate-800/30 transition-colors group">
                            <td className="p-4">
                                <div className="font-mono text-xs text-slate-500 mb-1.5">#{row.id.substring(0, 8)}</div>
                                <span className={`px-2 py-0.5 rounded text-[10px] uppercase font-bold border ${getSeverityStyle(row.severity)}`}>
                                    {row.severity || 'LOW'}
                                </span>
                            </td>
                            <td className="p-4">
                                <div className="text-sm text-slate-200 font-medium max-w-xs truncate" title={row.description}>
                                    {row.description}
                                </div>
                                {row.is_fca_trigger === true && (
                                    <span className="inline-flex mt-1 items-center px-1.5 py-0.5 rounded text-[9px] font-bold bg-purple-500/10 text-purple-400 border border-purple-500/20 uppercase tracking-wider">
                                        FCA REQUERIDA
                                    </span>
                                )}
                            </td>
                            <td className="p-4">
                                {row.inspection_item ? (
                                    <div className="text-xs">
                                        <div className="text-slate-300 font-semibold mb-0.5">
                                            {row.inspection_item.template_item?.descricao || "Item de Checklist"}
                                        </div>
                                        <div className="text-slate-500 font-mono">
                                            Valor: <span className="text-rose-400">{row.inspection_item.result_value}</span>
                                        </div>
                                    </div>
                                ) : (
                                    <span className="text-xs text-slate-600 italic">Registro Manual</span>
                                )}
                            </td>
                            <td className="p-4">
                                <span className={`px-2.5 py-1 rounded-full text-[10px] font-bold border uppercase tracking-wide ${getStatusStyle(row.status)}`}>
                                    {row.status === 'Open' ? 'Aberta' : row.status}
                                </span>
                            </td>
                            <td className="p-4 text-xs text-slate-400">
                                {new Date(row.created_at || row.created).toLocaleDateString()}
                            </td>
                            <td className="p-4 text-right space-x-2">
                                <button 
                                    onClick={() => onEdit(row)}
                                    className="p-1.5 rounded hover:bg-slate-800 text-slate-400 hover:text-indigo-400 transition-colors"
                                    title="Editar"
                                >
                                    <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                </button>
                                <button 
                                    onClick={() => onDelete(row.id)}
                                    className="p-1.5 rounded hover:bg-slate-800 text-slate-400 hover:text-rose-400 transition-colors"
                                    title="Excluir"
                                >
                                    <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
};

export default NcList;