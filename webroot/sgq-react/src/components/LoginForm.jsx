// fileName: src/components/LoginForm.jsx

import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { login } from '../Api'; 
import Input from './Input'; // Importa o componente Input

const LoginForm = () => {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);
  const navigate = useNavigate();

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError('');
    setLoading(true);

    // 1. Validação simples no frontend
    if (!email || !password) {
        setError('Preencha todos os campos.');
        setLoading(false);
        return;
    }

    try {
      // 2. Chama a API de Login do CakePHP
      await login({ email, password });
      
      console.log('Login bem-sucedido!');
      
      // 3. Redireciona para o Dashboard
      navigate('/dashboard', { replace: true });

    } catch (err) {
      console.error('Erro de Login:', err);
      
      // 4. Trata erros da API
      if (err.status === 401) {
        setError('Email ou senha inválidos. Verifique suas credenciais.');
      } else {
        setError('Ocorreu um erro de conexão com o servidor. Tente novamente mais tarde.');
      }
    } finally {
      setLoading(false);
    }
  };

  return (
    <form onSubmit={handleSubmit}>
      
      {error && <p className="error-message">{error}</p>}

      <Input
        label="Email"
        type="email"
        value={email}
        onChange={(e) => setEmail(e.target.value)}
        disabled={loading}
      />

      <Input
        label="Senha"
        type="password"
        value={password}
        onChange={(e) => setPassword(e.target.value)}
        disabled={loading}
      />

      <button type="submit" disabled={loading}>
        {loading ? 'Entrando...' : 'Entrar'}
      </button>
    </form>
  );
};

export default LoginForm;