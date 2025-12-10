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
        // NOVO: Fundo cinza claro e minimalista
        <div className="min-h-screen flex items-center justify-center bg-gray-50 px-4">
            
            {/* NOVO: Box mais limpo, bordas arredondadas e sombra suave */}
            <div className="w-full max-w-sm bg-white rounded-xl shadow-lg p-10 space-y-8">
                
                <div className="text-center">
                    {/* NOVO: Fonte grande e cinza escuro */}
                    <h1 className="text-4xl font-extrabold text-gray-800 tracking-tight">
                        SGQ<span className="text-red-600">.</span>
                    </h1>
                    {/* NOVO: Subtítulo mais neutro */}
                    <p className="mt-3 text-base text-gray-500 font-light">
                        {loading ? 'Validando acesso...' : 'Acesse seu painel de controle'}
                    </p>
                </div>

                {loading ? (
                    // Spinner simples e limpo
                    <div className="flex flex-col items-center justify-center py-10 space-y-2">
                        <div className="w-8 h-8 border-4 border-gray-300 border-t-red-600 rounded-full animate-spin"></div>
                        <span className="text-sm text-gray-500">Conectando...</span>
                    </div>
                ) : (
                    <form onSubmit={handleSubmit} className="space-y-6"> {/* Espaçamento um pouco maior */}
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
                            // Mensagem de erro sutil, mas visível
                            <div className="p-3 text-sm text-red-700 bg-red-50 border border-red-200 rounded-lg" role="alert">
                                {error}
                            </div>
                        )}

                        <Button loading={loading}>
                            ENTRAR
                        </Button>
                        
                        {/* NOVO: Link 'Esqueceu a senha?' minimalista */}
                        <div className="text-center">
                            <a href="#" className="text-sm text-gray-500 hover:text-red-600 transition-colors duration-200">
                                Esqueceu sua senha?
                            </a>
                        </div>
                    </form>
                )}

                {/* NOVO: Rodapé simples com texto pequeno e cinza claro */}
                <div className="text-center text-xs text-gray-400 pt-6 border-t border-gray-100">
                    © {new Date().getFullYear()} SGQ. Todos os direitos reservados.
                </div>
            </div>
        </div>
    );
}

export default LoginPage;