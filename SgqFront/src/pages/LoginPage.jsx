// src/pages/LoginPage.jsx
import React, { useState, useEffect } from 'react';
import { useAuth } from '../context/AuthContext';
import { useNavigate } from 'react-router-dom';
import Input from '../components/Form/Input';
import Button from '../components/Form/Button';

// Ícones SVG
const UserIcon = () => (
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
);

const LockIcon = () => (
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
);

// Componente Abstrato para Simular Céu (Fundo Escuro com Pontos de Luz)
const AbstractSky = () => (
    <div className="absolute inset-0 overflow-hidden bg-gray-950">
        
        {/* Gradiente/Neblina Azul Escuro para Profundidade */}
        <div className="absolute inset-0 bg-gradient-to-tr from-gray-900 via-gray-950 to-blue-950 opacity-90"></div>
        
        {/* Pontos de Luz (Simulando Estrelas/Brilho Abstrato) */}
        <div className="absolute top-[15%] left-[25%] w-2 h-2 bg-red-600/50 rounded-full blur-sm opacity-60"></div>
        <div className="absolute top-[5%] right-[15%] w-1 h-1 bg-white/70 rounded-full blur-xs opacity-70"></div>
        <div className="absolute top-[70%] left-[5%] w-3 h-3 bg-red-700/40 rounded-full blur-md opacity-50"></div>
        <div className="absolute bottom-[10%] right-[40%] w-0.5 h-0.5 bg-white rounded-full opacity-80"></div>
        <div className="absolute top-[40%] right-[30%] w-1.5 h-1.5 bg-white/80 rounded-full blur-xs opacity-90"></div>
    </div>
);


function LoginPage() {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    
    const { login, loading, error, isAuthenticated } = useAuth();
    const navigate = useNavigate();

    useEffect(() => {
        if (!loading && isAuthenticated) {
            navigate('/dashboard', { replace: true });
        }
    }, [isAuthenticated, loading, navigate]);

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            await login({ email, password });
        } catch (err) { console.error(err); }
    };
    
    return (
        // Fundo da Página BG-GRAY-800
        <div className="min-h-screen flex items-center justify-center bg-gray-800 px-4">
            
            {/* QUADRO CENTRALIZADO E DIVIDIDO (Container principal) */}
            <div className="flex w-full max-w-5xl h-[600px] bg-gray-900 rounded-2xl 
                        /* INTEGRAÇÃO: Sombra elevada para efeito flutuante */
                        shadow-2xl shadow-black/70 
                        /* Sombra interna sutil para simular uma borda suave e iluminada */
                        shadow-inner shadow-gray-700/50 
                        overflow-hidden">
                
                {/* QUADRO VISUAL (Esquerda - 60% em desktop) */}
                <div className="hidden lg:flex lg:w-[60%] relative items-center justify-center p-12 overflow-hidden">
                    
                    <AbstractSky />

                    <div className="text-center z-10 relative">
                        <h2 className="text-6xl font-extrabold tracking-tight text-white/90 transition-opacity duration-700 hover:opacity-100">
                            SGQ<span className="text-red-600">.</span>
                        </h2>
                        <p className="mt-4 text-xl font-light text-gray-300 max-w-md mx-auto transition-opacity duration-700 hover:opacity-100">
                            A plataforma de Gestão de Qualidade para otimizar seus processos críticos.
                        </p>
                        <div className="mt-12 flex justify-center space-x-6 text-red-600">
                            <svg className="hover:scale-110 transition-transform duration-300" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                            <svg className="hover:scale-110 transition-transform duration-300" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <svg className="hover:scale-110 transition-transform duration-300" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M12 2a10 10 0 0 0-9.09 14.83A5 5 0 0 0 3 19v1a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-1a5 5 0 0 0 .09-2.17A10 10 0 0 0 12 2z"></path></svg>
                        </div>
                    </div>
                    
                    {/* Linha de borda de destaque na parte inferior do quadro visual */}
                    <div className="absolute bottom-0 w-full h-1 bg-red-700/50"></div>
                </div>

                {/* QUADRO FORMULÁRIO (Direita - 40% em desktop, 100% em mobile) */}
                <div className="w-full lg:w-[40%] flex items-center justify-center p-8 sm:p-10 bg-gray-800">
                    
                    <div className="w-full max-w-sm space-y-8">
                        
                        <div className="text-left">
                            <h1 className="text-3xl font-bold text-white tracking-tight">
                                Acesso Requerido
                            </h1>
                            <p className="mt-2 text-base text-gray-500 font-light">
                                {loading ? 'Validando credenciais...' : 'Insira seus dados para entrar.'}
                            </p>
                        </div>

                        {loading ? (
                            <div className="flex flex-col items-center justify-center py-10 space-y-2">
                                <div className="w-8 h-8 border-4 border-gray-600 border-t-red-500 rounded-full animate-spin"></div>
                                <span className="text-sm text-gray-400">Conectando...</span>
                            </div>
                        ) : (
                            <form onSubmit={handleSubmit} className="space-y-6">
                                <Input
                                    label="E-mail"
                                    type="email" 
                                    value={email} 
                                    onChange={(e) => setEmail(e.target.value)} 
                                    required 
                                    placeholder="seu@email.com" 
                                    id="email-input"
                                    icon={<UserIcon />}
                                />

                                <Input
                                    label="Senha"
                                    type="password" 
                                    value={password} 
                                    onChange={(e) => setPassword(e.target.value)} 
                                    required 
                                    placeholder="••••••••" 
                                    id="password-input"
                                    icon={<LockIcon />}
                                />

                                {error && (
                                    <div className="p-3 text-sm text-red-400 bg-red-900/30 border border-red-800 rounded-lg" role="alert">
                                        {error}
                                    </div>
                                )}

                                <Button loading={loading}>
                                    ENTRAR
                                </Button>
                                
                                <div className="text-right pt-2">
                                    <a href="#" className="text-sm text-gray-500 hover:text-red-500 transition-colors duration-300">
                                        Esqueceu a senha?
                                    </a>
                                </div>
                            </form>
                        )}

                        <div className="text-left text-xs text-gray-600 pt-6 border-t border-gray-700">
                            © {new Date().getFullYear()} SGQ. Todos os direitos reservados.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default LoginPage;