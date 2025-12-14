import React, { useEffect, useState } from 'react';
import { useAuth } from '../context/AuthContext';
import { useNavigate } from 'react-router-dom';
import LoginCard from '../components/Login/LoginCard';

/**
 * LoginPage (controlador)
 * - Não realiza fetchs diretos ao backend aqui.
 * - Apenas delega a autenticação ao useAuth().
 */

export default function LoginPage() {
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
      // login() deve cuidar do armazenamento do token/session e do redirect via isAuthenticated
    } catch (err) {
      // Erro já tratado no contexto; podemos logar localmente para debug
      console.error('Erro ao tentar efetuar login:', err);
    }
  };

  return (
    <div className="min-h-screen bg-gradient-to-b from-[#060608] to-[#0b0f13] flex items-center justify-center p-6">
      <div className="max-w-6xl w-full grid grid-cols-12 gap-8">
        {/* Left decorative panel */}
        <aside className="hidden lg:block lg:col-span-5 bg-[#071018] rounded-2xl p-8 border border-white/5 shadow-lg">
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

        {/* Right login card */}
        <main className="col-span-12 lg:col-span-7 flex items-center justify-center">
          <LoginCard
            email={email}
            password={password}
            setEmail={setEmail}
            setPassword={setPassword}
            onSubmit={handleSubmit}
            loading={loading}
            error={error}
          />
        </main>
      </div>
    </div>
  );
}