// src/context/AuthContext.jsx
import React, { createContext, useContext, useState, useEffect } from 'react';
import UserAccountService from '../services/UserAccountService';

// 1. Cria o contexto
const AuthContext = createContext();

// 2. Hook customizado para fácil acesso
export const useAuth = () => {
    return useContext(AuthContext);
};

// 3. Provider para envolver a aplicação
export const AuthProvider = ({ children }) => {
    const [user, setUser] = useState(null); 
    // 🌟 CORREÇÃO 1: Deve iniciar como TRUE para o PrivateRoute esperar a API
    const [loading, setLoading] = useState(true); 
    const [error, setError] = useState(null);
    const isAuthenticated = !!user; 

    // 🌟 CORREÇÃO 2: Implementação do useEffect para verificar a sessão na montagem
    useEffect(() => {
        const checkExistingSession = async () => {
            try {
                // Tenta buscar os dados do usuário usando o cookie de sessão
                const userData = await UserAccountService.checkStatus();
                // Sucesso: Seta os dados do usuário e autentica.
                setUser(userData);
            } catch (err) {
                // Falha (401 Unauthorized): Nenhuma sessão ativa, define o usuário como nulo.
                setUser(null); 
            } finally {
                // 🛑 Garante que o estado de carregamento seja FINALMENTE definido como false
                setLoading(false); 
            }
        };

        checkExistingSession();
    }, []); // Array de dependências vazio: roda APENAS na montagem

    const login = async (credentials) => {
        setLoading(true);
        setError(null);
        try {
            const userData = await UserAccountService.login(credentials);
            
            setUser(userData);
            return userData;

        } catch (err) {
            setError(err.message);
            throw err; 
        } finally {
            setLoading(false);
        }
    };

    const logout = async () => {
        try {
            // Chamada ao backend para limpar a sessão (importante)
            await UserAccountService.logout(); 
        } catch (err) {
            console.warn("Logout no backend falhou, mas limpando estado local.", err);
        }
        // Limpa o estado local
        setUser(null);
    };

    const value = {
        user,
        isAuthenticated,
        loading,
        error,
        login,
        logout,
    };

    return <AuthContext.Provider value={value}>{children}</AuthContext.Provider>;
};