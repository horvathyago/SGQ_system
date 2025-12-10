// src/components/Form/Button.jsx
import React from 'react';

const Button = ({ children, loading = false, ...props }) => {
    return (
        <button 
            type="submit" 
            disabled={loading}
            className={`
                w-full py-3 px-4 rounded-xl font-bold text-lg text-white 
                /* Animação: Transição de todas as propriedades (shadow, scale, cor) */
                bg-red-600 hover:bg-red-700 transition-all duration-300 ease-in-out 
                
                /* Efeito Dinâmico: Sombra sutil e escala no hover */
                shadow-lg shadow-red-600/30 hover:shadow-xl hover:scale-[1.01] 
                active:scale-[0.99] active:shadow-md 
                
                /* Foco para acessibilidade */
                focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-opacity-70
                
                /* Estado Loading */
                ${loading ? 'opacity-60 cursor-not-allowed bg-gray-600 hover:bg-gray-600 hover:scale-100 shadow-none' : ''}
            `}
            {...props}
        >
            {/* Spinner para o estado de processamento */}
            {loading ? (
                <div className="flex items-center justify-center space-x-2">
                    <svg className="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4"></circle>
                        <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Processando...</span>
                </div>
            ) : children}
        </button>
    );
};

export default Button;