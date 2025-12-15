import React from "react";

export default function DetailPanel({ item }) {
  if (!item) {
    return (
      <div className="h-full bg-slate-900 border border-slate-800 rounded-xl p-8 flex flex-col items-center justify-center text-center opacity-60 border-dashed">
        <div className="w-12 h-12 rounded-full bg-slate-800 flex items-center justify-center mb-3">
           <svg className="w-6 h-6 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
           </svg>
        </div>
        <div className="text-sm font-medium text-slate-400">Nenhum item selecionado</div>
        <div className="text-xs text-slate-600 mt-1 max-w-[200px]">
          Clique em "Detalhes" na tabela para visualizar o report rápido.
        </div>
      </div>
    );
  }

  return (
    <div className="h-full bg-slate-900 border border-slate-800 rounded-xl flex flex-col shadow-lg relative overflow-hidden">
      {/* Header do Card */}
      <div className="p-5 border-b border-slate-800 bg-slate-800/30">
        <div className="flex justify-between items-start">
           <div>
             <span className="inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-indigo-500/20 text-indigo-300 border border-indigo-500/30 mb-2">
                {item.type || "INSPEÇÃO"}
             </span>
             <h3 className="text-lg font-bold text-white tracking-tight">{item.code}</h3>
           </div>
           <div className={`w-3 h-3 rounded-full ${item.status === 'OK' ? 'bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]' : 'bg-rose-500 shadow-[0_0_8px_rgba(244,63,94,0.5)]'}`}></div>
        </div>
        <p className="text-sm text-slate-400 mt-2 line-clamp-2">{item.summary ?? item.description}</p>
      </div>

      {/* Corpo com Grid de Dados */}
      <div className="p-5 flex-1 overflow-y-auto space-y-4">
        <div className="grid grid-cols-2 gap-4">
          <div className="p-3 bg-slate-950/50 rounded border border-slate-800/50">
            <span className="block text-[10px] uppercase text-slate-500 font-semibold mb-1">Responsável</span>
            <span className="text-sm text-slate-200">{item.owner ?? "-"}</span>
          </div>
          <div className="p-3 bg-slate-950/50 rounded border border-slate-800/50">
            <span className="block text-[10px] uppercase text-slate-500 font-semibold mb-1">Data</span>
            <span className="text-sm text-slate-200">{item.date ?? "-"}</span>
          </div>
        </div>
        
        {/* Seção de Status Visual */}
        <div>
           <span className="block text-[10px] uppercase text-slate-500 font-semibold mb-2">Status do Fluxo</span>
           <div className="w-full bg-slate-800 rounded-full h-1.5 overflow-hidden">
              <div 
                className={`h-full ${item.status === 'Concluído' ? 'bg-emerald-500' : 'bg-indigo-500'} w-[70%]`}
              ></div>
           </div>
           <div className="flex justify-between mt-1">
             <span className="text-[10px] text-slate-500">Iniciado</span>
             <span className="text-[10px] text-slate-400 font-medium">{item.status}</span>
           </div>
        </div>
      </div>

      {/* Footer de Ações */}
      <div className="p-4 border-t border-slate-800 bg-slate-800/20 grid grid-cols-2 gap-3">
        <button className="flex items-center justify-center px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold transition-all shadow-lg shadow-indigo-500/20">
          Abrir Completo
        </button>
        <button className="px-4 py-2 rounded-lg bg-slate-800 hover:bg-slate-700 border border-slate-700 text-slate-300 text-xs font-medium transition-all">
          Histórico
        </button>
      </div>
    </div>
  );
}