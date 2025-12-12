import React from "react";

/**
 * Placeholder de gráfico de tendência.
 * Path: src/components/Dashboard/TrendChart.jsx
 * Substitua por Chart.js / Recharts conforme preferir.
 */

export default function TrendChart({ data = [], loading = false }) {
  if (loading) {
    return <div className="h-56 flex items-center justify-center text-gray-500">Carregando gráfico...</div>;
  }

  // Simple inline SVG placeholder using data length to draw points
  const points = (data.length ? data : Array.from({ length: 10 }, (_, i) => Math.round(50 + Math.sin(i) * 20))).map(
    (v, i) => `${i * 60},${120 - v}`
  );
  return (
    <div className="h-56">
      <svg width="100%" height="100%" viewBox="0 0 600 140" preserveAspectRatio="none">
        <rect width="100%" height="100%" fill="transparent" />
        <polyline
          fill="none"
          stroke="#ef4444"
          strokeWidth="3"
          points={points.join(" ")}
          strokeLinecap="round"
          strokeLinejoin="round"
        />
      </svg>
    </div>
  );
}