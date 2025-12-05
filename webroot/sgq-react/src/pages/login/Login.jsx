// fileName: src/pages/Login.jsx

import React from 'react';
import LoginForm from '../components/LoginForm';
import './Login.css';

const Login = () => {
  return (
    <div className="login-container">
      <div className="login-box">
        <h2>Acesso ao Sistema</h2>
        <LoginForm />
      </div>
    </div>
  );
};

export default Login;