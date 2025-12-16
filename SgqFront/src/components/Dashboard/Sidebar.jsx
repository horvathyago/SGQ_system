import React from "react";
import { NavLink } from "react-router-dom"; // Removido useNavigate pois usaremos window.location
import logoCore from "../../assets/logoCore.png"; 
import UserAccountService from "../../services/UserAccountService";

export default function Sidebar() {
  // const navigate = useNavigate(); // Não é mais necessário para o logout forçado

  const handleLogout = async () => {
    try{
      await UserAccountService.logout(); 
      
      // CORREÇÃO: Força o recarregamento da página para limpar o estado de memória do React.
      // Isso evita que verificações de rota (AuthGuard) te devolvam para o dashboard.
      window.location.href = "/"; 

    } catch (erro){
      console.error("Erro ao fazer logout:", erro);
      
      // Mesmo em caso de erro, forçamos a saída
      window.location.href = "/"; 
    }
  };

  const navClass = ({ isActive }) =>
    `group flex items-center w-full px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 ${
      isActive
        ? "bg-indigo-500/10 text-indigo-400 border-l-[3px] border-indigo-500"
        : "text-slate-400 hover:bg-slate-800 hover:text-slate-200 border-l-[3px] border-transparent"
    }`;

  const SectionLabel = ({ children }) => (
    <div className="px-4 mt-6 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">
      {children}
    </div>
  );

  return (
    <aside className="w-72 bg-slate-900 border-r border-slate-800 flex flex-col h-screen fixed left-0 top-0 z-50">
      {/* 🚀 Brand Header */}
      <div className="h-16 flex items-center px-6 border-b border-slate-800/50">
        <div className="w-8 h-8 mr-3 flex items-center justify-center">
             <img src={logoCore} alt="QualityCore" className="w-full h-full object-contain" />
        </div>
        <div>
          <h1 className="text-slate-100 font-bold text-lg tracking-tight leading-none">QualityCore</h1>
          <span className="text-[10px] text-slate-500 font-medium uppercase tracking-wider">Enterprise OS</span>
        </div>
      </div>

      {/* 🔗 Navigation */}
      <nav className="flex-1 overflow-y-auto py-6 px-3 space-y-1 custom-scrollbar">
        <SectionLabel>Visão Geral</SectionLabel>
        <NavLink to="/dashboard" className={navClass}>Dashboard</NavLink>

        <SectionLabel>Operações de Qualidade</SectionLabel>
        <NavLink to="/inspection" className={navClass}>Nova Inspeção</NavLink>
        <NavLink to="/nonconformities" className={navClass}>Não Conformidades</NavLink>
        <NavLink to="/pecas" className={navClass}>Gestão de Itens</NavLink>

        <SectionLabel>Controle & Auditoria</SectionLabel>
        <NavLink to="/calibration" className={navClass}>Calibração</NavLink>
        <NavLink to="/templates" className={navClass}>Templates</NavLink>
        <NavLink to="/reports" className={navClass}>Relatórios</NavLink>
      </nav>

      {/* 🔙 Footer */}
      <div className="p-4 border-t border-slate-800">
        <button
          onClick={handleLogout} 
          className="flex items-center w-full px-4 py-2 text-sm text-slate-500 hover:text-slate-300 transition-colors"
        >
          <span className="mr-2">←</span> Sair do Sistema
        </button>
      </div>
    </aside>
  );
}