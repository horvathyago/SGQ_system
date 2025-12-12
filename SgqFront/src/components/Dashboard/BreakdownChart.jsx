import React from "react";

/**
 * Placeholder simples para breakdown (donut / bars)
 * Path: src/components/Dashboard/BreakdownChart.jsx
 */

export default function BreakdownChart({ data = [], type = "donut" }) {
  if (type === "donut") {
    return (
      <div className="flex items-center justify-center h-36">
        <svg viewBox="0 0 36 36" className="w-20 h-20">
          <circle r="16" cx="18" cy="18" fill="transparent" stroke="#111827" strokeWidth="8" />
          <circle r="16" cx="18" cy="18" fill="transparent" stroke="#ef4444" strokeWidth="8" strokeDasharray="40 60" strokeLinecap="round" />
        </svg>
      </div>
    );
  }
  // bars
  return (
    <div className="space-y-2">
      <div className="h-3 bg-red-500 rounded" style={{ width: "78%" }} />
      <div className="h-3 bg-yellow-500 rounded" style={{ width: "52%" }} />
      <div className="h-3 bg-sky-500 rounded" style={{ width: "36%" }} />
    </div>
  );
}