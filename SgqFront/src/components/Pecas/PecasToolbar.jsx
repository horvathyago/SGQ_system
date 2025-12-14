import React from "react";

/**
 * Barra superior da listagem com informações de paginação / total.
 * Path: src/components/Pecas/PecasToolbar.jsx
 *
 * Props: total, page, pageSize, setPage
 */

export default function PecasToolbar({ total = 0, page = 1, pageSize = 12, setPage = () => {} }) {
  const totalPages = Math.max(1, Math.ceil(total / pageSize));

  return (
    <div className="flex items-center justify-between">
      <div className="text-sm text-gray-400">
        Total de peças: <span className="text-white font-semibold">{total}</span>
      </div>

      <div className="flex items-center gap-2">
        <button
          onClick={() => setPage(Math.max(1, page - 1))}
          className="px-3 py-1 rounded bg-white/5 text-sm text-gray-300 disabled:opacity-40"
          disabled={page <= 1}
        >
          ←
        </button>
        <div className="text-sm text-gray-300">
          {page} / {totalPages}
        </div>
        <button
          onClick={() => setPage(Math.min(totalPages, page + 1))}
          className="px-3 py-1 rounded bg-white/5 text-sm text-gray-300 disabled:opacity-40"
          disabled={page >= totalPages}
        >
          →
        </button>
      </div>
    </div>
  );
}