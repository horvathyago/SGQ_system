// src/App.jsx
import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import { AuthProvider } from './context/AuthContext';
import PrivateRoute from './components/routes/PrivateRoute';

// Importa suas Páginas
import LoginPage from './pages/LoginPage';
// Importe o seu Dashboard ou Home page para o usuário logado
import DashboardPage from './pages/DashboardPage'; // Crie esta página se ainda não existir! 

function App() {
    return (
        // O Router é o contêiner principal para navegação
        <Router>
            {/* O AuthProvider envolve tudo o que precisa de autenticação */}
            <AuthProvider>
                <Routes>
                    {/* Rota Pública: Usa LoginPage (o formulário centralizado) */}
                    <Route path="/" element={<LoginPage />} />

                    {/* Rota Protegida: Requer login, usa PrivateRoute */}
                    <Route 
                        path="/dashboard" 
                        element={
                            <PrivateRoute>
                                {/* O conteúdo que só aparece para usuários logados */}
                                <DashboardPage /> 
                            </PrivateRoute>
                        } 
                    />

                    {/* Adicione outras rotas protegidas aqui */}
                    {/* <Route path="/perfil" element={<PrivateRoute><ProfilePage /></PrivateRoute>} /> */}
                    
                    {/* Opcional: Rota de 404 */}
                    {/* <Route path="*" element={<div>Página Não Encontrada</div>} /> */}
                </Routes>
            </AuthProvider>
        </Router>
    );
}

export default App;