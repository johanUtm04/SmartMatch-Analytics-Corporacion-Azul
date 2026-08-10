import React from "react";
import { createRoot } from "react-dom/client";
import Dashboard from "./Dashboard";

// Constant with Get the root element from the HTML document
const rootElement = document.getElementById("app");
// Check if the root element exists
if (!rootElement) {
  throw new Error("Root element #app not found.");
}

createRoot(rootElement).render(
  <React.StrictMode>
    <Dashboard />
  </React.StrictMode>
);