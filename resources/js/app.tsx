import React from "react";
import { createRoot } from "react-dom/client";
import Dashboard from "./Dashboard";

// import "../css/app.css";
// import "./bootstrap";

const rootElement = document.getElementById("app");

if (!rootElement) {
  throw new Error("Root element #app not found.");
}

createRoot(rootElement).render(
  <React.StrictMode>
    <Dashboard />
  </React.StrictMode>
);