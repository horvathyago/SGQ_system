// src/components/routes/PrivateRoute.jsx
import React from 'react';
import { Navigate } from 'react-router-dom';
import { useAuth } from '../../context/AuthContext';

// src/components/routes/PrivateRoute.jsx (Trecho)

const PrivateRoute = ({ children }) => {
    const { isAuthenticated, loading } = useAuth(); 

    if (loading) {
        return <div>Verificando sessão...</div>; // Espera aqui!
    }

    if (!isAuthenticated) {
        return <Navigate to="/" replace />; 
    }

    return children;
};

export default PrivateRoute;