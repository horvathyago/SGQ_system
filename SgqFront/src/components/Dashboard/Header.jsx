import React, { useState } from "react";

export default function Header({ onApplyFilters, filters }) {
  const [local, setLocal] = useState(filters);

  function apply() {
    onApplyFilters(local);
  }

  return (
    <header className="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-2">
      <div>
        <h2 className="text-2xl font-bold text-white tracking-tight">Painel de Controle</h2>
        <p className="text-sm text-slate-500 mt-1">Monitoramento em tempo real do SGQ</p>
      </div>

      <div className="flex flex-col sm:flex-row items-center gap-3">
        {/* Search Input com Ícone */}
        <div className="relative w-full sm:w-72 group">
          <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg className="h-4 w-4 text-slate-500 group-focus-within:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
               <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </div>
          <input
            className="block w-full pl-10 pr-3 py-2 border border-slate-700 rounded-lg leading-5 bg-slate-900 text-slate-300 placeholder-slate-600 focus:outline-none focus:bg-slate-800 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 sm:text-sm transition-all"
            placeholder="Buscar ID, Ordem ou NC..."
          />
        </div>

        {/* Filters Group */}
        <div className="flex items-center gap-2 bg-slate-900 p-1 rounded-lg border border-slate-700">
          <select
            className="bg-transparent border-none text-xs font-medium text-slate-300 focus:ring-0 cursor-pointer py-1.5 pl-3 pr-8"
            value={local.period}
            onChange={(e) => setLocal({ ...local, period: e.target.value })}
          >
            <option value="7d">7 dias</option>
            <option value="30d">30 dias</option>
            <option value="90d">Trimestre</option>
          </select>
          <div className="h-4 w-px bg-slate-700"></div>
          <button
            className="px-4 py-1.5 text-xs font-medium rounded text-white bg-indigo-600 hover:bg-indigo-500 transition-colors shadow-sm"
            onClick={apply}
          >
            Atualizar
          </button>
        </div>
      </div>
    </header>
  );
}