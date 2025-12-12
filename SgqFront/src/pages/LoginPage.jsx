// src/pages/LoginPage.jsx
import React, { useState, useEffect } from 'react';
import { useAuth } from '../context/AuthContext';
import { useNavigate } from 'react-router-dom';
import LoginCard from '../components/Login/LoginCard'; // Assumindo que este componente existe e é a parte do formulário
// import SvgBrand from "../components/Login/SvgBrand"; // Removido conforme solicitado
// Removido: import "../styles/login.css"; // Removido conforme solicitado

/**
 * Página de Login (Revisada com Nova Estrutura de Design)
 * Coloque este arquivo em: src/pages/LoginPage.jsx
 *
 * Observações:
 * - A lógica de autenticação foi migrada do código original.
 * - Assume-se que 'LoginCard' aceita as props de controle do formulário (email, password, handlers, etc.).
 */

export default function LoginPage() {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    
    // Lógica de Autenticação do código original
    const { login, loading, error, isAuthenticated } = useAuth();
    const navigate = useNavigate();

    // Redirecionamento após login (Lógica do código original)
    useEffect(() => {
        if (!loading && isAuthenticated) {
            navigate('/dashboard', { replace: true });
        }
    }, [isAuthenticated, loading, navigate]);

    // Função de submissão do formulário (Lógica do código original)
    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            // Chama a função de login do contexto de autenticação
            await login({ email, password });
        } catch (err) { 
            // O erro já é tratado e armazenado em 'error' dentro de 'useAuth'
            console.error("Erro ao tentar fazer login:", err); 
        }
    };

    return (
        // Fundo da Página BG-GRADIENT-TO-B
        <div className="min-h-screen bg-gradient-to-b from-[#060608] to-[#0b0f13] flex items-center justify-center p-6">
            
            {/* CONTAINER PRINCIPAL (MAX-W-6XL COM GRID) */}
            <div className="max-w-6xl w-full grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                {/* QUADRO VISUAL (Esquerda - col-span-5) - Oculto em Mobile por padrão */}
                <aside className="hidden lg:block lg:col-span-5 bg-[#071018] rounded-2xl p-8 border border-white/5 shadow-lg">
                    {/* Conteúdo decorativo migrado da nova proposta de design */}
                    <div className="flex items-center gap-4 mb-6">
                        <div className="w-14 h-14 rounded-full bg-[#0c1116] flex items-center justify-center text-red-400 font-black text-lg shadow-inner">
                            SGQ
                        </div>
                        <div>
                            <h2 className="text-2xl font-bold text-white">SGQ</h2>
                            <p className="text-sm text-gray-400">Sistema de Gestão de Qualidade</p>
                        </div>
                    </div>

                    <div className="mb-6">
                        <h3 className="text-base font-semibold text-gray-200 mb-2">Controle, rastreabilidade e análise</h3>
                        <p className="text-sm text-gray-400">
                            Monitore inspeções, não-conformidades e calibrações com rastreabilidade completa.
                        </p>
                    </div>

                    <ul className="space-y-4 mt-6">
                        <li className="flex items-start gap-3">
                            <div className="w-4 h-4 rounded-sm bg-red-500 mt-1" />
                            <div className="text-sm text-gray-300">Dashboard com KPIs e tendências</div>
                        </li>
                        <li className="flex items-start gap-3">
                            <div className="w-4 h-4 rounded-sm bg-red-400 mt-1" />
                            <div className="text-sm text-gray-300">Checklists versionados</div>
                        </li>
                        <li className="flex items-start gap-3">
                            <div className="w-4 h-4 rounded-sm bg-red-500 mt-1" />
                            <div className="text-sm text-gray-300">Rastreamento completo de NCs</div>
                        </li>
                    </ul>

                    <div className="mt-10 text-xs text-gray-500">
                        <div>© {new Date().getFullYear()} SGQ Systems</div>
                        <div>Versão 1.0.0</div>
                    </div>
                </aside>

                {/* QUADRO FORMULÁRIO (Direita - col-span-7) */}
                <main className="lg:col-span-7 col-span-12 flex items-center justify-center">
                    {/* O componente LoginCard é onde o formulário real deve residir. 
                        Ele recebe a lógica de estado e handlers do LoginPage. */}
                    <LoginCard 
                        email={email}
                        password={password}
                        setEmail={setEmail}
                        setPassword={setPassword}
                        handleSubmit={handleSubmit}
                        loading={loading}
                        error={error}
                    />
                </main>
            </div>
        </div>
    );
}