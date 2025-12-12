import React from "react";

/**
 * Sidebar simples (coloque no layout global se já existir)
 * Path: src/components/Dashboard/Sidebar.jsx
 */

export default function Sidebar() {
  return (
    <aside className="w-64 bg-[#071018] rounded-xl p-5 mr-6 border border-white/5">
      <div className="flex items-center gap-3 mb-6">
        <div className="w-10 h-10 rounded-full bg-[#0c1116] flex items-center justify-center text-red-400 font-bold">
          SGQ
        </div>
        <div>
          <div className="text-white font-semibold">SGQ</div>
          <div className="text-sm text-gray-400">Gestão de Qualidade</div>
        </div>
      </div>

      <nav className="space-y-2">
        <button className="w-full text-left px-3 py-2 rounded-lg bg-white/5 text-red-200 font-medium">Dashboard</button>
        <button className="w-full text-left px-3 py-2 rounded-lg hover:bg-white/3 text-gray-300">Inspeções</button>
        <button className="w-full text-left px-3 py-2 rounded-lg hover:bg-white/3 text-gray-300">NCs</button>
        <button className="w-full text-left px-3 py-2 rounded-lg hover:bg-white/3 text-gray-300">Calibração</button>
        <button className="w-full text-left px-3 py-2 rounded-lg hover:bg-white/3 text-gray-300">Templates</button>
        <button className="w-full text-left px-3 py-2 rounded-lg hover:bg-white/3 text-gray-300">Relatórios</button>
      </nav>
    </aside>
  );
}