import React from "react";
import { NavLink, useNavigate } from "react-router-dom";

/**
 * Sidebar com navegação usando react-router
 * Path: src/components/Dashboard/Sidebar.jsx
 *
 * NOTA DE CORREÇÃO:
 * - O código está funcional para navegação. Se houver sobreposição de menus (como na imagem),
 * o problema está no z-index do *conteúdo principal* do Dashboard.
 * - Adicionado 'relative z-10' na <aside> para garantir que a sidebar tenha um contexto
 * de empilhamento (stacking context) claro, embora seja menos provável que seja o causador
 * da sobreposição de menus internos.
 */

export default function Sidebar() {
  const navigate = useNavigate();

  // Função para determinar as classes de estilo, incluindo o estado ativo do NavLink
  const navClass = ({ isActive }) =>
    // Garante que o item ocupe 100% da largura do pai e tenha padding/cores
    `w-full text-left px-3 py-2 rounded-lg transition-colors duration-150 block ${ // Adicionado 'block' para robustez
      isActive 
        ? "bg-white/5 text-red-200 font-medium" 
        : "hover:bg-white/3 text-gray-300"
    }`;

  return (
    // 'relative z-10' garante que a sidebar seja tratada como um bloco independente.
    // O 'mr-6' empurra o conteúdo principal para a direita.
    <aside className="w-64 bg-[#071018] rounded-xl p-5 mr-6 border border-white/5 shadow-sm relative z-10">
      
      {/* 🚀 Cabeçalho / Logo SGQ */}
      <div className="flex items-center gap-3 mb-6">
        <div className="w-10 h-10 rounded-full bg-[#0c1116] flex items-center justify-center text-red-400 font-bold">
          SGQ
        </div>
        <div>
          <div className="text-white font-semibold">SGQ</div>
          <div className="text-sm text-gray-400">Gestão de Qualidade</div>
        </div>
      </div>

      {/* 🔗 Navegação Principal (Links) */}
      <nav className="space-y-2">
        <NavLink to="/dashboard" className={navClass}>
          Dashboard
        </NavLink>

        <NavLink to="/inspection" className={navClass}>
          Inspeções
        </NavLink>

        <NavLink to="/nonconformities" className={navClass}>
          NCs
        </NavLink>

        <NavLink to="/calibration" className={navClass}>
          Calibração
        </NavLink>

        <NavLink to="/templates" className={navClass}>
          Templates
        </NavLink>

        <NavLink to="/reports" className={navClass}>
          Relatórios
        </NavLink>

        <NavLink to="/pecas" className={navClass}>
          Itens
        </NavLink>
      </nav>

      {/* 🔙 Rodapé / Ação Adicional */}
      <div className="mt-6 border-t border-white/5 pt-4">
        <button
          onClick={() => navigate("/dashboard")}
          className="w-full text-left px-3 py-2 rounded-lg bg-transparent text-sm text-gray-400 hover:bg-white/3"
        >
          Voltar ao Dashboard
        </button>
      </div>
    </aside>
  );
}