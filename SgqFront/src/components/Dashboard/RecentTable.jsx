import React from "react";

export default function RecentTable({ data = [], loading = false, onOpen }) {
  if (loading) {
    return <div className="p-8 text-center text-sm text-slate-500 animate-pulse">Sincronizando dados...</div>;
  }

  if (!data.length) {
    return <div className="p-8 text-center text-sm text-slate-500">Nenhuma atividade registrada no período.</div>;
  }

  // Helper para Badges de Status
  const getStatusBadge = (status) => {
    const s = status?.toLowerCase() || "";
    let classes = "bg-slate-800 text-slate-400 border-slate-700"; // Default
    
    if (s.includes("concluído") || s.includes("aprovado") || s === "ok") 
      classes = "bg-emerald-500/10 text-emerald-400 border-emerald-500/20";
    if (s.includes("pendente") || s.includes("andamento")) 
      classes = "bg-indigo-500/10 text-indigo-400 border-indigo-500/20";
    if (s.includes("reprovado") || s.includes("erro") || s.includes("nc")) 
      classes = "bg-rose-500/10 text-rose-400 border-rose-500/20";

    return (
      <span className={`px-2.5 py-0.5 rounded-full text-[10px] font-semibold border ${classes} uppercase tracking-wide`}>
        {status}
      </span>
    );
  };

  return (
    <div className="overflow-x-auto">
      <table className="w-full text-left border-collapse">
        <thead>
          <tr className="border-b border-slate-800 bg-slate-900/50">
            <th className="px-5 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">ID</th>
            <th className="px-5 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Data</th>
            <th className="px-5 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Ref. Ordem</th>
            <th className="px-5 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Contexto</th>
            <th className="px-5 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Responsável</th>
            <th className="px-5 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Status</th>
            <th className="px-5 py-3 text-right text-[10px] font-bold text-slate-500 uppercase tracking-wider">Ação</th>
          </tr>
        </thead>
        <tbody className="divide-y divide-slate-800/50">
          {data.map((r, idx) => (
            <tr key={r.id ?? idx} className="hover:bg-slate-800/30 transition-colors group">
              <td className="px-5 py-3 text-xs font-medium text-slate-300 font-mono">{r.code ?? "#INSP-0000"}</td>
              <td className="px-5 py-3 text-xs text-slate-400">{r.date ?? "—"}</td>
              <td className="px-5 py-3 text-xs text-indigo-300">{r.order ?? "—"}</td>
              <td className="px-5 py-3 text-xs text-slate-300 truncate max-w-[150px]" title={r.template ?? r.item}>
                {r.template ?? r.item ?? "-"}
              </td>
              <td className="px-5 py-3 text-xs text-slate-400">
                <div className="flex items-center gap-2">
                  <div className="w-5 h-5 rounded-full bg-slate-700 flex items-center justify-center text-[9px] text-white">
                    {(r.owner?.[0] || "U").toUpperCase()}
                  </div>
                  {r.owner ?? "-"}
                </div>
              </td>
              <td className="px-5 py-3">{getStatusBadge(r.status)}</td>
              <td className="px-5 py-3 text-right">
                <button
                  onClick={() => onOpen && onOpen(r)}
                  className="text-xs font-medium text-indigo-400 hover:text-indigo-300 hover:underline opacity-0 group-hover:opacity-100 transition-opacity"
                >
                  Detalhes
                </button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}