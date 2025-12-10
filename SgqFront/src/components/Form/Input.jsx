import React from 'react';

const Input = ({ label, id, icon, ...props }) => {
    return (
        <div className="space-y-1">
            {/* Label discreto */}
            {label && <label htmlFor={id} className="block text-sm font-medium text-gray-700">{label}</label>}
            
            <div className="relative flex items-center">
                
                {/* Ícone sutil */}
                {icon && (
                    <span className="absolute left-3 text-gray-400 pointer-events-none">
                        {icon}
                    </span>
                )}
                
                <input 
                    id={id}
                    // NOVO: Bordas mais finas, sombra removida e foco com ring sutil
                    className={`
                        flex-1 w-full px-4 py-3 border border-gray-300 rounded-lg 
                        text-base text-gray-900 placeholder-gray-400
                        focus:outline-none focus:ring-1 focus:ring-red-600 focus:border-red-600
                        transition-all duration-200
                        ${icon ? 'pl-10' : ''}
                    `}
                    {...props} 
                />
            </div>
        </div>
    );
};

export default Input;