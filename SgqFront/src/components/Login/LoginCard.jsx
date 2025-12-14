import React from 'react';
import SvgBrand from './SvgBrand';

/**
 * LoginCard (apresentação)
 * - Recebe props para estado e callbacks.
 * - Não faz requests diretos (delegar ao contexto).
 */

export default function LoginCard({ email, password, setEmail, setPassword, onSubmit, loading, error }) {
  return (
    <div className="w-full max-w-md">
      <div className="bg-gradient-to-b from-white/2 to-white/1 rounded-2xl p-8 shadow-xl border border-white/5">
        <div className="flex items-center justify-between mb-6">
          <div className="flex items-center gap-3">
            <SvgBrand className="w-12 h-12" />
            <div>
              <h3 className="text-xl font-semibold text-white">Acessar o sistema</h3>
              <p className="text-sm text-gray-400">Entre com sua conta para continuar</p>
            </div>
          </div>
        </div>

        <form onSubmit={onSubmit} className="space-y-4">
          <div>
            <label className="block text-sm text-gray-300 mb-2">E‑mail</label>
            <div className="relative">
              <input
                type="email"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                placeholder="seu-email@empresa.com"
                required
                className="w-full bg-transparent border border-white/6 rounded-lg px-4 py-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-red-500"
              />
            </div>
          </div>

          <div>
            <label className="block text-sm text-gray-300 mb-2">Senha</label>
            <input
              type="password"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              placeholder="Digite sua senha"
              required
              className="w-full bg-transparent border border-white/6 rounded-lg px-4 py-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-red-500"
            />
          </div>

          <div className="flex items-center justify-between">
            <label className="inline-flex items-center gap-2 text-sm text-gray-300 cursor-pointer">
              <input
                type="checkbox"
                className="form-checkbox h-4 w-4 text-red-500 bg-transparent border border-white/5 rounded-sm"
              />
              Lembrar-me
            </label>

            <a href="/forgot-password" className="text-sm text-red-300 hover:underline">
              Esqueci minha senha
            </a>
          </div>

          {error && <div className="text-sm text-red-300">{error}</div>}

          <div className="pt-2">
            <button
              type="submit"
              disabled={loading}
              className="w-full py-3 rounded-lg bg-gradient-to-br from-red-500 to-pink-500 text-white font-semibold shadow-md hover:from-red-600 disabled:opacity-60"
            >
              {loading ? "Entrando..." : "Entrar"}
            </button>
          </div>

          <div className="flex items-center my-4">
            <div className="h-px bg-white/5 flex-1" />
            <div className="px-3 text-sm text-gray-400">Ou conectar com</div>
            <div className="h-px bg-white/5 flex-1" />
          </div>

          <div className="grid grid-cols-2 gap-3">
            <button
              type="button"
              onClick={() => alert("Implementar: Entrar com Google")}
              className="w-full py-2 rounded-lg bg-white/5 text-gray-200 hover:bg-white/6"
            >
              Entrar com Google
            </button>
            <button
              type="button"
              onClick={() => alert("Implementar: SSO")}
              className="w-full py-2 rounded-lg bg-red-600/10 text-red-200 border border-red-600/20 hover:bg-red-600/12"
            >
              Entrar com SSO
            </button>
          </div>

          <p className="text-xs text-gray-500 mt-3">
            Ao continuar, você aceita nossos{' '}
            <a href="/terms" className="text-red-300 underline">Termos</a> e{' '}
            <a href="/privacy" className="text-red-300 underline">Política de Privacidade</a>.
          </p>
        </form>
      </div>
    </div>
  );
}