import React from "react";
import { createRoot } from "react-dom/client";
import Dashboard from "./Dashboard";
import Portal from "./pages/Portal";

const rootElement = document.getElementById("app");

if (!rootElement) {
  throw new Error("Root element #app not found.");
}

const path = window.location.pathname;

let ComponentToRender = Portal;

if (path.startsWith("/smartmatch") || path.startsWith("/modulo3")) {
  ComponentToRender = Dashboard;
}

createRoot(rootElement).render(
  <React.StrictMode>
    <ComponentToRender />
  </React.StrictMode>
);