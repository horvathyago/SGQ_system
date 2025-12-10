// src/components/Form/Button.jsx
import React from 'react';

const Button = ({ children, loading = false, ...props }) => {
    return (
        <button 
            type="submit" 
            disabled={loading}
            // NOVO: Sem sombra forte, foco e transição refinados
            className={`
                w-full py-3 px-4 rounded-lg font-semibold text-lg text-white 
                bg-red-600 hover:bg-red-700 transition-all duration-300 
                focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-opacity-50
                ${loading ? 'opacity-70 cursor-not-allowed bg-gray-400 hover:bg-gray-400' : ''}
            `}
            {...props} // Permite passar onClick, etc.
        >
            {/* Exibe o texto 'loading' se o estado for true, senão exibe o children */}
            {loading ? 'Processando...' : children}
        </button>
    );
};

export default Button;