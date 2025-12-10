// src/components/Form/Input.jsx
import React from 'react';

const Input = ({ label, id, icon, ...props }) => {
    return (
        <div className="space-y-2">
            {label && <label htmlFor={id} className="block text-sm font-light text-gray-300">{label}</label>}
            
            <div className="relative flex items-center group"> {/* Adicionamos 'group' para animar o ícone */}
                
                {icon && (
                    <span className="absolute left-4 text-gray-500 pointer-events-none 
                                     /* Animação: Ícone muda de cor no foco */
                                     transition-colors duration-300 group-focus-within:text-red-500">
                        {icon}
                    </span>
                )}
                
                <input 
                    id={id}
                    className={`
                        flex-1 w-full px-4 py-3 rounded-xl 
                        bg-gray-800 border border-gray-700
                        text-base text-gray-100 placeholder-gray-500 font-light
                        
                        /* Foco com Anel mais Proeminente e Transição */
                        focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500
                        transition-all duration-300 ease-in-out
                        
                        ${icon ? 'pl-11' : ''}
                    `}
                    {...props} 
                />
            </div>
        </div>
    );
};

export default Input;