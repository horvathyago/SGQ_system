import React from "react";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import { AuthProvider } from "./context/AuthContext";
import PrivateRoute from "./components/routes/PrivateRoute";

// Importa suas Páginas
import LoginPage from "./pages/LoginPage";
import DashboardPage from "./pages/DashboardPage";
import PecasPage from "./pages/PecasPage"; 


// NOVO: Importa a página que irá gerenciar o processo de inspeção por fases
import InspectionManagerPage from "./pages/InspectionManagerPage";

// Opcional: import de outras páginas (Itens / Pecas etc.) - deixe comentado se ainda não existir
// import PecasPage from "./pages/PecasPage";

function App() {
  return (
    <Router>
      <AuthProvider>
        <Routes>
          {/* Rota Pública */}
          <Route path="/" element={<LoginPage />} />

          {/* Rota Protegida para Dashboard */}
          <Route
            path="/dashboard"
            element={
              <PrivateRoute>
                <DashboardPage />
              </PrivateRoute>
            }
          />

          {/* Rota Protegida para o Processo de Inspeção */}
          <Route
            path="/inspection"
            element={
              <PrivateRoute>
                <InspectionManagerPage />
              </PrivateRoute>
            }
          />

          
          <Route
            path="/pecas"
            element={
              <PrivateRoute>
                <PecasPage />
              </PrivateRoute>
            }
          />
          

          {/* Opcional: Rota de 404 */}
          <Route path="*" element={<div className="p-8">Página Não Encontrada</div>} />
        </Routes>
      </AuthProvider>
    </Router>
  );
}

export default App;