// src/components/Pecas/PecasList.jsx
import React from "react";

export default function PecasList({ data = [], loading = false, onEdit = () => {}, onDelete = () => {} }) {
  if (loading) {
    return (
      <div className="p-12 text-center">
        <div className="inline-block w-8 h-8 border-4 border-indigo-500/30 border-t-indigo-500 rounded-full animate-spin mb-4"></div>
        <p className="text-slate-500 text-sm font-medium">Carregando catálogo...</p>
      </div>
    );
  }

  if (!Array.isArray(data) || data.length === 0) {
    return (
      <div className="p-12 text-center flex flex-col items-center justify-center opacity-60">
        <svg className="w-12 h-12 text-slate-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
           <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
        </svg>
        <p className="text-slate-400 font-medium">Nenhum item encontrado com os filtros atuais.</p>
      </div>
    );
  }

  return (
    <div className="overflow-x-auto">
      <table className="w-full text-left border-collapse">
        <thead>
          <tr className="bg-slate-950/50 border-b border-slate-800">
            <th className="py-4 px-6 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Código</th>
            <th className="py-4 px-6 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Título / Descrição</th>
            <th className="py-4 px-6 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Peso (kg)</th>
            <th className="py-4 px-6 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Status</th>
            <th className="py-4 px-6 text-right text-[10px] font-bold text-slate-500 uppercase tracking-wider">Ações</th>
          </tr>
        </thead>
        <tbody className="divide-y divide-slate-800/50">
          {data.map((item, index) => {
            const isActive = item.status === "active";
            return (
              <tr key={item.id || index} className="group hover:bg-slate-800/30 transition-colors">
                <td className="py-4 px-6">
                    <span className="font-mono text-sm text-indigo-300 bg-indigo-500/10 px-2 py-1 rounded border border-indigo-500/20">
                        {item.code || "N/A"}
                    </span>
                </td>
                <td className="py-4 px-6">
                    <div className="text-sm font-semibold text-slate-200">{item.title || "Sem título"}</div>
                    <div className="text-xs text-slate-500 mt-0.5 max-w-md truncate">{item.description || "—"}</div>
                </td>
                <td className="py-4 px-6 text-sm text-slate-400 font-mono">
                    {item.weight ? Number(item.weight).toFixed(2) : "-"}
                </td>
                <td className="py-4 px-6">
                    <span className={`inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border ${
                        isActive 
                        ? "bg-emerald-500/10 text-emerald-400 border-emerald-500/20" 
                        : "bg-slate-700/30 text-slate-400 border-slate-600/30"
                    }`}>
                        <span className={`w-1.5 h-1.5 rounded-full mr-1.5 ${isActive ? 'bg-emerald-500' : 'bg-slate-500'}`}></span>
                        {isActive ? "Ativo" : "Inativo"}
                    </span>
                </td>
                <td className="py-4 px-6 text-right space-x-2">
                  <button
                    onClick={() => onEdit(item)}
                    className="text-slate-400 hover:text-indigo-400 transition-colors p-1.5 hover:bg-slate-800 rounded"
                    title="Editar"
                  >
                    <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                  </button>
                  <button
                    onClick={() => onDelete(item.id ?? item.code)}
                    className="text-slate-400 hover:text-rose-400 transition-colors p-1.5 hover:bg-slate-800 rounded"
                    title="Remover"
                  >
                    <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                  </button>
                </td>
              </tr>
            );
          })}
        </tbody>
      </table>
    </div>
  );
}