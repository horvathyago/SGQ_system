// src/App.jsx
import React, { useState } from 'react';
import UserAccountService from './services/UserAccountService';

function App() {
  // Estados para o formulário
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  
  // Estados de controle da aplicação
  const [user, setUser] = useState(null); // Se null, não está logado
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);

  /**
   * Lida com o envio do formulário de login
   */
  const handleLogin = async (e) => {
    e.preventDefault(); // Evita recarregar a página
    setLoading(true);
    setError(null);

    try {
      // Chama o serviço passando os dados exatos que a API espera
      const userData = await UserAccountService.login({ 
        email: email, 
        password: password 
      });
      
      // Se chegou aqui, o login foi sucesso (200 OK)
      setUser(userData);
      alert(`Bem-vindo, ${userData.nome || userData.email}!`);

    } catch (err) {
      // Exibe o erro retornado pela API (Ex: "Usuário ou senha inválidos")
      setError(err.message);
    } finally {
      setLoading(false);
    }
  };

  /**
   * Função simples de logout para limpar o estado
   */
  const handleLogout = () => {
    UserAccountService.logout(); // Chama API (opcional)
    setUser(null);
    setEmail('');
    setPassword('');
    setError(null);
  };

  // --- RENDERIZAÇÃO ---

  // 1. Se o usuário estiver logado, mostra a tela de boas-vindas
  if (user) {
    return (
      <div style={{ padding: '20px', fontFamily: 'Arial, sans-serif' }}>
        <h1 style={{ color: 'green' }}>Login realizado com sucesso!</h1>
        <div style={{ border: '1px solid #ccc', padding: '15px', borderRadius: '8px' }}>
          <p><strong>ID:</strong> {user.id}</p>
          <p><strong>Nome:</strong> {user.nome}</p>
          <p><strong>Email:</strong> {user.email}</p>
          <p><strong>Role:</strong> {user.role}</p>
        </div>
        <br />
        <button onClick={handleLogout} style={{ padding: '10px 20px', cursor: 'pointer' }}>
          Sair / Logout
        </button>
      </div>
    );
  }

  // 2. Se não estiver logado, mostra o formulário
  return (
    <div style={{ display: 'flex', justifyContent: 'center', marginTop: '50px', fontFamily: 'Arial, sans-serif' }}>
      <div style={{ width: '300px', padding: '20px', border: '1px solid #ddd', borderRadius: '8px', boxShadow: '0 2px 5px rgba(0,0,0,0.1)' }}>
        <h2 style={{ textAlign: 'center' }}>Acessar Sistema</h2>
        
        <form onSubmit={handleLogin}>
          <div style={{ marginBottom: '15px' }}>
            <label style={{ display: 'block', marginBottom: '5px' }}>E-mail:</label>
            <input 
              type="email" 
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              required
              placeholder="seu@email.com"
              style={{ width: '100%', padding: '8px', boxSizing: 'border-box' }}
            />
          </div>

          <div style={{ marginBottom: '15px' }}>
            <label style={{ display: 'block', marginBottom: '5px' }}>Senha:</label>
            <input 
              type="password" 
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              required
              placeholder="Sua senha"
              style={{ width: '100%', padding: '8px', boxSizing: 'border-box' }}
            />
          </div>

          {error && (
            <div style={{ color: 'red', marginBottom: '15px', fontSize: '0.9em', textAlign: 'center' }}>
              {error}
            </div>
          )}

          <button 
            type="submit" 
            disabled={loading}
            style={{ width: '100%', padding: '10px', backgroundColor: '#007BFF', color: '#fff', border: 'none', borderRadius: '4px', cursor: loading ? 'not-allowed' : 'pointer' }}
          >
            {loading ? 'Entrando...' : 'Entrar'}
          </button>
        </form>
      </div>
    </div>
  );
}

export default App;