import React from "react";
import { NavLink, useNavigate } from "react-router-dom";

/**
 * Sidebar com navegação usando react-router
 * Path: src/components/Dashboard/Sidebar.jsx
 */

export default function Sidebar() {
  const navigate = useNavigate();

  // Função para determinar as classes de estilo
  const navClass = ({ isActive }) =>
    `w-full text-left px-3 py-2 rounded-lg transition-colors duration-150 block ${
      isActive 
        ? "bg-white/5 text-red-200 font-medium border-l-2 border-red-500" 
        : "hover:bg-white/3 text-gray-300 hover:text-white"
    }`;

  return (
    <aside className="w-64 bg-[#071018] rounded-xl p-5 mr-6 border border-white/5 shadow-sm relative z-10 flex flex-col h-[calc(100vh-40px)]">
      
      {/* 🚀 Cabeçalho / Logo SGQ */}
      <div className="flex items-center gap-3 mb-8 px-2">
        <div className="w-10 h-10 rounded-full bg-gradient-to-br from-red-900 to-gray-900 flex items-center justify-center text-red-400 font-bold border border-red-900/50 shadow-lg">
          SGQ
        </div>
        <div>
          <div className="text-white font-bold tracking-wide">SGQ PRO</div>
          <div className="text-xs text-gray-500 uppercase">Qualidade Integrada</div>
        </div>
      </div>

      {/* 🔗 Navegação Principal */}
      <nav className="space-y-1 flex-1">
        <NavLink to="/dashboard" className={navClass}>
          Dashboard
        </NavLink>

        <div className="pt-4 pb-1 px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
          Operacional
        </div>

        <NavLink to="/inspection" className={navClass}>
          Nova Inspeção
        </NavLink>

        {/* ✅ Link Confirmado para a Rota criada no App.jsx */}
        <NavLink to="/nonconformities" className={navClass}>
          Não Conformidades
        </NavLink>

        <NavLink to="/pecas" className={navClass}>
          Gestão de Itens
        </NavLink>

        <div className="pt-4 pb-1 px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
          Controle
        </div>

        <NavLink to="/calibration" className={navClass}>
          Calibração
        </NavLink>

        <NavLink to="/templates" className={navClass}>
          Templates de Checklist
        </NavLink>

        <NavLink to="/reports" className={navClass}>
          Relatórios & KPIs
        </NavLink>
      </nav>

      {/* 🔙 Rodapé */}
      <div className="mt-auto border-t border-white/5 pt-4">
        <button
          onClick={() => navigate("/dashboard")}
          className="w-full text-left px-3 py-2 rounded-lg bg-transparent text-sm text-gray-400 hover:text-white hover:bg-white/5 transition-colors flex items-center gap-2"
        >
          <span>←</span> Voltar ao Início
        </button>
      </div>
    </aside>
  );
}