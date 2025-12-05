// fileName: main.jsx

import React from "react";
import ReactDOM from "react-dom/client";
import { BrowserRouter } from "react-router-dom";
import App from "./App"; 
import "./index.css";

// Criação da root React
ReactDOM.createRoot(document.getElementById("root")).render(
  <React.StrictMode>
    {/* REMOVA OU COMENTE O basename="/app" */}
    <BrowserRouter> 
      <App />
    </BrowserRouter>
  </React.StrictMode>
);