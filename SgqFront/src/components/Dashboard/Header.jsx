import React, { useState } from "react";

/**
 * Header com filtros rápidos
 * Path: src/components/Dashboard/Header.jsx
 */

export default function Header({ onApplyFilters, filters }) {
  const [local, setLocal] = useState(filters);

  function apply() {
    onApplyFilters(local);
  }

  return (
    <header className="flex items-center justify-between">
      <div>
        <h1 className="text-xl font-bold text-white">Painel de Gestão</h1>
        <p className="text-sm text-gray-400 mt-1">Resumo e KPIs da qualidade</p>
      </div>

      <div className="flex items-center gap-3">
        <input
          className="bg-[#0f1720] border border-white/5 rounded-md px-3 py-2 text-sm text-gray-300 placeholder-gray-500 w-80"
          placeholder="Buscar inspeção, NC ou ordem..."
        />
        <div className="flex items-center gap-2">
          <select
            className="bg-[#0f1720] border border-white/5 rounded-md px-3 py-2 text-sm text-gray-300"
            value={local.period}
            onChange={(e) => setLocal({ ...local, period: e.target.value })}
          >
            <option value="7d">Últimos 7 dias</option>
            <option value="30d">Últimos 30 dias</option>
            <option value="90d">Últimos 90 dias</option>
          </select>
          <button
            className="px-3 py-2 rounded-md bg-gradient-to-br from-red-500 to-pink-500 text-white"
            onClick={apply}
          >
            Aplicar
          </button>
        </div>
      </div>
    </header>
  );
}