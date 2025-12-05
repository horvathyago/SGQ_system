// fileName: src/components/Input.jsx

import React from 'react';
import '../pages/login.css'; // O CSS deste componente será o mesmo do Login.css

const Input = ({ label, type = 'text', value, onChange, disabled, error }) => {
  return (
    <div className="input-group">
      <label htmlFor={label}>{label}</label>
      <input
        type={type}
        id={label}
        value={value}
        onChange={onChange}
        required
        disabled={disabled}
      />
      {error && <p className="input-error-message">{error}</p>}
    </div>
  );
};

export default Input;