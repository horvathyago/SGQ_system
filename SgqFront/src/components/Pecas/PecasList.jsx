import React from "react";

/**
 * PecasList - renderiza itens normalizados (id, code, title, description, status, ...)
 */

export default function PecasList({ data = [], loading = false, onEdit = () => {}, onDelete = () => {} }) {
  if (loading) {
    return (
      <div className="p-6 bg-[#061018] rounded-lg text-gray-400">
        Carregando peças...
      </div>
    );
  }

  if (!Array.isArray(data) || data.length === 0) {
    return (
      <div className="p-6 bg-[#061018] rounded-lg text-gray-400">
        Nenhuma peça encontrada.
      </div>
    );
  }

  return (
    <div className="bg-[#061018] rounded-lg p-4 overflow-auto">
      <table className="w-full table-auto text-left text-sm">
        <thead className="text-gray-400 text-xs uppercase">
          <tr>
            <th className="py-2 px-3">Código</th>
            <th className="py-2 px-3">Título</th>
            <th className="py-2 px-3">Descrição</th>
            <th className="py-2 px-3">Peso</th>
            <th className="py-2 px-3">Status</th>
            <th className="py-2 px-3">Ações</th>
          </tr>
        </thead>

        <tbody>
          {data.map((item, index) => {
            if (!item || typeof item !== "object") return null;
            const key = item.id ?? item.code ?? `peca-${index}`;
            return (
              <tr key={key} className="border-t border-white/5">
                <td className="py-3 px-3 text-gray-200">{item.code || "-"}</td>
                <td className="py-3 px-3 text-gray-200">{item.title || "-"}</td>
                <td className="py-3 px-3 text-gray-300">{item.description || "-"}</td>
                <td className="py-3 px-3 text-gray-300">{item.weight ?? "-"}</td>
                <td className="py-3 px-3 text-gray-300">{item.status === "active" ? "Ativo" : (item.status === "inactive" ? "Inativo" : "-")}</td>
                <td className="py-3 px-3 text-gray-300 space-x-2">
                  <button
                    onClick={() => onEdit(item)}
                    className="text-sm px-2 py-1 rounded bg-yellow-600 hover:bg-yellow-700"
                  >
                    Editar
                  </button>
                  <button
                    onClick={() => onDelete(item.id ?? item._id ?? item.code)}
                    className="text-sm px-2 py-1 rounded bg-red-600 hover:bg-red-700"
                  >
                    Excluir
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