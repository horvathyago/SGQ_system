import React from "react";

/**
 * KpiCard simples
 * Path: src/components/Dashboard/KpiCard.jsx
 * Props: title, value, accent ('red'|'green'|'yellow'), onClick
 */

export default function KpiCard({ title, value, accent, onClick }) {
  const accentClass =
    accent === "red" ? "ring-2 ring-red-600/30" : accent === "green" ? "ring-2 ring-emerald-600/20" : "";
  return (
    <div
      onClick={onClick}
      className={`p-4 rounded-xl bg-[#0f1720] border border-white/5 shadow cursor-pointer ${accentClass}`}
    >
      <div className="text-xs text-gray-400">{title}</div>
      <div className="mt-2 text-2xl font-bold text-white">{value ?? "—"}</div>
    </div>
  );
}