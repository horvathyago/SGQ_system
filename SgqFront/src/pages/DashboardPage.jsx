// src/pages/DashboardPage.jsx
import React from 'react';
import { useAuth } from '../context/AuthContext';

function DashboardPage() {
    const { user, logout } = useAuth();
    
    // Fallback: se o PrivateRoute falhar, mas o user for null
    if (!user) return null; 

    return (
        <div style={{ padding: '20px', fontFamily: 'Arial, sans-serif' }}>
            <h1 style={{ color: 'green' }}>Bem-vindo(a) ao Dashboard!</h1>
            <p>Esta é uma área protegida. O login foi bem-sucedido.</p>
            
            <div style={{ border: '1px solid #ccc', padding: '15px', borderRadius: '8px' }}>
                <p><strong>Detalhes do Usuário:</strong></p>
                <p><strong>Nome:</strong> {user.nome}</p>
                <p><strong>Email:</strong> {user.email}</p>
                <p><strong>Role:</strong> {user.role}</p>
            </div>
            <br />
            <button onClick={logout} style={{ padding: '10px 20px', cursor: 'pointer' }}>
                Sair / Logout
            </button>
        </div>
    );
}

export default DashboardPage;