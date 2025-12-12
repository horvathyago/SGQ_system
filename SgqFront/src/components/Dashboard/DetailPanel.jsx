import React from "react";

/**
 * Painel lateral de detalhe
 * Path: src/components/Dashboard/DetailPanel.jsx
 */

export default function DetailPanel({ item }) {
  if (!item) {
    return (
      <div className="bg-[#0f1720] rounded-xl p-4 border border-white/5 shadow">
        <div className="text-sm text-gray-400 font-semibold">Detalhe rápido</div>
        <div className="text-xs text-gray-500 mt-2">Selecione uma inspeção ou NC para ver detalhes</div>
      </div>
    );
  }

  return (
    <div className="bg-[#0f1720] rounded-xl p-4 border border-white/5 shadow">
      <div className="text-sm text-gray-200 font-semibold">{item.code ?? "Detalhe"}</div>
      <div className="text-xs text-gray-400 mt-2">{item.summary ?? item.description}</div>
      <div className="mt-4 space-y-1">
        <div className="text-xs text-gray-400">Responsável: {item.owner ?? "-"}</div>
        <div className="text-xs text-gray-400">Status: {item.status ?? "-"}</div>
        <div className="text-xs text-gray-400">Criado em: {item.date ?? "-"}</div>
      </div>

      <div className="mt-4 flex gap-2">
        <button className="px-3 py-2 rounded bg-gradient-to-br from-red-500 to-pink-400 text-white">Abrir</button>
        <button className="px-3 py-2 rounded bg-white/5 text-gray-200">Comentar</button>
      </div>
    </div>
  );
}