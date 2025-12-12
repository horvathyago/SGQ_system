import React from "react";

/**
 * Componente SVG da marca (reutilizável)
 * Path: src/components/Login/SvgBrand.jsx
 */

export default function SvgBrand({ className = "w-12 h-12" }) {
  return (
    <svg className={className} viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden>
      <rect width="56" height="56" rx="12" fill="#11161a" />
      <path d="M16 32 L24 20 L38 34" stroke="#ef4444" strokeWidth="3" strokeLinecap="round" strokeLinejoin="round" />
    </svg>
  );
}