import React from "react";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import { AuthProvider } from "./context/AuthContext";
import PrivateRoute from "./components/routes/PrivateRoute";

// Importa suas Páginas
import LoginPage from "./pages/LoginPage";
import DashboardPage from "./pages/DashboardPage";
import InspectionManagerPage from "./pages/InspectionManagerPage";
import NonConformityPage from "./pages/NonConformityPage"; // ✅ Importação Adicionada

// Import opcional (se existir)
import PecasPage from "./pages/PecasPage"; 

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

          {/* ✅ NOVA ROTA: Gestão de Não Conformidades */}
          {/* O path deve bater com o 'to' do Sidebar */}
          <Route
            path="/nonconformities"
            element={
              <PrivateRoute>
                <NonConformityPage />
              </PrivateRoute>
            }
          />

          {/* Rota para Peças/Itens */}
          <Route
            path="/pecas"
            element={
              <PrivateRoute>
                <PecasPage />
              </PrivateRoute>
            }
          />

          {/* Rota de 404 */}
          <Route path="*" element={<div className="p-8 text-white">Página Não Encontrada</div>} />
        </Routes>
      </AuthProvider>
    </Router>
  );
}

export default App;