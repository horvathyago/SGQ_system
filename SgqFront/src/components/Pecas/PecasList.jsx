import React from "react";

export default function PecasList({ data = [], loading = false, onEdit, onDelete }) {
  
  if (loading) {
    return (
      <div className="p-12 text-center">
        <div className="inline-block w-8 h-8 border-4 border-indigo-500/30 border-t-indigo-500 rounded-full animate-spin mb-4"></div>
        <p className="text-slate-500 text-sm">Carregando catálogo...</p>
      </div>
    );
  }

  if (!data || data.length === 0) {
    return (
      <div className="p-12 text-center text-slate-500">
        <p>Nenhum item encontrado.</p>
      </div>
    );
  }

  return (
    <div className="overflow-x-auto">
      <table className="w-full text-left border-collapse">
        <thead>
          <tr className="bg-slate-950/50 border-b border-slate-800 text-slate-500 text-[10px] uppercase font-bold tracking-wider">
            <th className="py-4 px-6">Código</th>
            <th className="py-4 px-6">Título / Descrição</th>
            <th className="py-4 px-6">Peso</th>
            <th className="py-4 px-6">Status</th>
            <th className="py-4 px-6 text-right">Ações</th>
          </tr>
        </thead>
        <tbody className="divide-y divide-slate-800/50 text-sm text-slate-300">
          {data.map((item, index) => {
            // IDs e Chaves
            const id = item.id;
            
            // CORREÇÃO: Lê 'codigo_item' do banco
            const code = item.codigo_item || item.code || "S/COD";

            // Lê 'titulo' (confirmado anteriormente)
            const title = item.titulo || item.title || "Sem Título"; 
            
            const desc = item.description || item.descricao || "—";
            const weight = item.weight || item.peso || 0;
            const status = item.status ?? item.ativo ?? 1;
            const isActive = (status === 'active' || status === true || status === 1);

            return (
              <tr key={id || index} className="hover:bg-slate-800/30 transition-colors">
                <td className="py-4 px-6 font-mono text-indigo-400">
                    {code}
                </td>
                <td className="py-4 px-6">
                    <div className="font-semibold text-white">{title}</div>
                    <div className="text-xs text-slate-500 truncate max-w-xs">{desc}</div>
                </td>
                <td className="py-4 px-6 font-mono">
                    {Number(weight).toFixed(2)} kg
                </td>
                <td className="py-4 px-6">
                   {isActive 
                     ? <span className="text-emerald-400 bg-emerald-500/10 px-2 py-1 rounded text-xs">Ativo</span>
                     : <span className="text-slate-400 bg-slate-700/30 px-2 py-1 rounded text-xs">Inativo</span>
                   }
                </td>
                <td className="py-4 px-6 text-right space-x-2">
                  <button onClick={() => onEdit(item)} className="text-slate-400 hover:text-indigo-400 p-1.5 hover:bg-slate-800 rounded">
                    <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                  </button>
                  <button onClick={() => onDelete(id)} className="text-slate-400 hover:text-rose-400 p-1.5 hover:bg-slate-800 rounded">
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