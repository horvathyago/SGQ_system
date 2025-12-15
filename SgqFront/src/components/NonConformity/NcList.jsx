// src/components/NonConformity/NcList.jsx
import React from 'react';

const NcList = ({ data, onEdit, onDelete }) => {
    if (!data || data.length === 0) {
        return <div className="text-gray-500 p-4 text-center">Nenhuma não conformidade registrada.</div>;
    }

    return (
        <div className="overflow-x-auto">
            <table className="w-full text-left text-sm text-gray-400">
                <thead className="bg-gray-800 text-gray-200 uppercase text-xs">
                    <tr>
                        <th className="p-3">ID</th>
                        <th className="p-3">Descrição</th>
                        <th className="p-3">Status</th>
                        <th className="p-3">Responsável</th>
                        <th className="p-3">Data</th>
                        <th className="p-3 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody className="divide-y divide-gray-700">
                    {data.map((row) => (
                        <tr key={row.id} className="hover:bg-gray-800/50 transition-colors">
                            <td className="p-3 font-mono text-red-400">#{row.id}</td>
                            <td className="p-3 text-gray-200 font-medium">
                                {row.description}
                                {row.inspection_items && (
                                    <div className="text-xs text-gray-500 mt-1">
                                        Item Inspeção ID: {row.inspection_item_id}
                                    </div>
                                )}
                            </td>
                            <td className="p-3">
                                <span className={`px-2 py-1 rounded text-xs font-bold border ${
                                    row.status === 'Open' 
                                        ? 'bg-red-900/30 text-red-300 border-red-800' 
                                        : 'bg-green-900/30 text-green-300 border-green-800'
                                }`}>
                                    {row.status || 'Aberto'}
                                </span>
                            </td>
                            <td className="p-3">
                                {row.responsavel ? row.responsavel.name : '-'}
                            </td>
                            <td className="p-3">
                                {new Date(row.created).toLocaleDateString()}
                            </td>
                            <td className="p-3 text-right space-x-2">
                                <button 
                                    onClick={() => onEdit(row)}
                                    className="text-blue-400 hover:text-blue-300 hover:underline"
                                >
                                    Editar
                                </button>
                                <button 
                                    onClick={() => onDelete(row.id)}
                                    className="text-red-500 hover:text-red-400 hover:underline"
                                >
                                    Excluir
                                </button>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
};

export default NcList;