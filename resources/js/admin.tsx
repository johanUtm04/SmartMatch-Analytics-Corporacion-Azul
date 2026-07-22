import React from "react";
import { createRoot } from "react-dom/client";
import AdminDashboard from "./AdminDashboard";

// import "../css/app.css";
// import "./bootstrap";

const rootElement = document.getElementById("admin");

if (!rootElement) {
  throw new Error("Root element #admin not found.");
}

createRoot(rootElement).render(
  <React.StrictMode>
    <AdminDashboard />
  </React.StrictMode>
);