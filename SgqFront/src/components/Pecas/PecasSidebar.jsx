import React from "react";

/**
 * Pequeno painel lateral com filtros rápidos de peça.
 * Path: src/components/Pecas/PecasSidebar.jsx
 *
 * Props:
 * - filters: objeto { family, status }
 * - onChange: função(newFilters)
 *
 * Ajuste os valores das families conforme seu backend (puxar via API se preferir).
 */

export default function PecasSidebar({ filters = {}, onChange = () => {} }) {
  const families = ["all", "Família A", "Família B", "Família C"]; // placeholder

  return (
    <aside className="bg-[#071018] rounded-xl p-4 border border-white/5 shadow">
      <h3 className="text-sm font-semibold text-white mb-3">Filtros</h3>

      <div className="mb-4">
        <label className="text-xs text-gray-400 block mb-2">Família</label>
        <select
          value={filters.family}
          onChange={(e) => onChange({ ...filters, family: e.target.value })}
          className="w-full bg-transparent border border-white/5 rounded px-3 py-2 text-sm text-gray-300"
        >
          {families.map((f) => (
            <option key={f} value={f === "all" ? "all" : f}>
              {f === "all" ? "Todas" : f}
            </option>
          ))}
        </select>
      </div>

      <div className="mb-4">
        <label className="text-xs text-gray-400 block mb-2">Status</label>
        <select
          value={filters.status}
          onChange={(e) => onChange({ ...filters, status: e.target.value })}
          className="w-full bg-transparent border border-white/5 rounded px-3 py-2 text-sm text-gray-300"
        >
          <option value="all">Todos</option>
          <option value="active">Ativo</option>
          <option value="inactive">Inativo</option>
        </select>
      </div>

      <div className="text-xs text-gray-500 mt-6">
        Use os filtros para reduzir a listagem. Os valores são apenas exemplos — você pode
        carregar families dinamicamente via API.
      </div>
    </aside>
  );
}