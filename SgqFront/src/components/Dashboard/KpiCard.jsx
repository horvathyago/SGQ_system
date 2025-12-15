import React from "react";

export default function KpiCard({ title, value, accent, onClick, icon }) {
  // Map accents to semantically meaningful enterprise colors
  const styles = {
    default: { border: "border-slate-800", text: "text-slate-100", iconBg: "bg-slate-800", iconColor: "text-slate-400" },
    red: { border: "border-rose-900/50", text: "text-rose-400", iconBg: "bg-rose-950", iconColor: "text-rose-500" },
    green: { border: "border-emerald-900/50", text: "text-emerald-400", iconBg: "bg-emerald-950", iconColor: "text-emerald-500" },
    yellow: { border: "border-amber-900/50", text: "text-amber-400", iconBg: "bg-amber-950", iconColor: "text-amber-500" },
  };

  const currentStyle = styles[accent] || styles.default;
  const hoverEffect = onClick ? "cursor-pointer hover:border-slate-600 hover:bg-slate-800/80 transition-all duration-300" : "";

  return (
    <div
      onClick={onClick}
      className={`relative p-5 rounded-xl bg-slate-900 border ${currentStyle.border} shadow-sm flex flex-col justify-between h-32 ${hoverEffect}`}
    >
      <div className="flex justify-between items-start">
        <span className="text-xs font-semibold text-slate-500 uppercase tracking-wider">{title}</span>
        {/* Placeholder visual para ícone baseado na prop 'icon' */}
        <div className={`w-8 h-8 rounded-lg flex items-center justify-center ${currentStyle.iconBg}`}>
             {/* Simulação de ícone com SVG genérico se não tiver lib */}
             <svg className={`w-4 h-4 ${currentStyle.iconColor}`} fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13 10V3L4 14h7v7l9-11h-7z" />
             </svg>
        </div>
      </div>
      
      <div className="mt-2">
        <span className={`text-3xl font-bold tracking-tight ${currentStyle.text}`}>
          {value ?? "—"}
        </span>
      </div>
    </div>
  );
}