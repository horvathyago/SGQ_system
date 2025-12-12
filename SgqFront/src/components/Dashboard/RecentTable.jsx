import React from "react";

/**
 * RecentTable: lista simples com eventos/inspeções/NCs
 * Path: src/components/Dashboard/RecentTable.jsx
 */

export default function RecentTable({ data = [], loading = false, onOpen }) {
  if (loading) {
    return <div className="text-gray-500">Carregando atividades...</div>;
  }

  if (!data.length) {
    return <div className="text-gray-400">Nenhuma atividade encontrada.</div>;
  }

  return (
    <div className="overflow-x-auto">
      <table className="min-w-full table-auto">
        <thead>
          <tr className="text-left text-sm text-gray-400">
            <th className="px-3 py-2">ID</th>
            <th className="px-3 py-2">Data</th>
            <th className="px-3 py-2">Ordem</th>
            <th className="px-3 py-2">Template / Item</th>
            <th className="px-3 py-2">Responsável</th>
            <th className="px-3 py-2">Status</th>
            <th className="px-3 py-2">Ações</th>
          </tr>
        </thead>
        <tbody>
          {data.map((r, idx) => (
            <tr key={r.id ?? idx} className="border-t border-white/5">
              <td className="px-3 py-3 text-sm">{r.code ?? "#INSP-0000"}</td>
              <td className="px-3 py-3 text-sm">{r.date ?? "2025-12-12"}</td>
              <td className="px-3 py-3 text-sm">{r.order ?? "OP-1000"}</td>
              <td className="px-3 py-3 text-sm">{r.template ?? r.item ?? "-"}</td>
              <td className="px-3 py-3 text-sm">{r.owner ?? "-"}</td>
              <td className="px-3 py-3 text-sm">{r.status ?? "-"}</td>
              <td className="px-3 py-3 text-sm">
                <button
                  onClick={() => onOpen && onOpen(r)}
                  className="px-2 py-1 rounded bg-white/5 text-sm hover:bg-white/6"
                >
                  Ver
                </button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}