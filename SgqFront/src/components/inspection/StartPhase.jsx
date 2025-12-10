// Garanta que NÃO haja mais nenhuma declaração de 'StartPhase' em outro lugar
import React, { useState, useEffect } from 'react';
import InspectionService from '../../services/InspectionService';
import { useAuth } from '../../context/AuthContext'; // Se precisar do useAuth aqui

// Definição ÚNICA e correta do componente
const StartPhase = ({ onComplete, user, inspectionData }) => {
    // ... toda a lógica de estado e fetch de ItemMasters
    
    // (O código completo do componente está na resposta anterior,
    // mas removo o 'export default' se ele já estiver sendo exportado em outro lugar
    // ou garanto que seja o único.)

    const handleStart = async () => {
        // ... Lógica para criar a Inspection e chamar onComplete({ inspectionId: ... })
    };

    return (
        <div>
            {/* ... Conteúdo JSX ... */}
            <button onClick={handleStart}>Iniciar Inspeção</button>
        </div>
    );
};

export default StartPhase; // Exporta para ser usado em InspectionManagerPage.jsx