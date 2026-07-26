import React from "react";
import ReactDOM from 'react-dom/client';
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import SmartMatchHeader from './components/SmartMatchHeader';
// import ProductCreate from './pages/ProductCreate';


function App() {
    return (
    <BrowserRouter>
      <Routes>
        {/* When URL is /dashboard, show this */}
        <Route path="/dashboard" element={<div>This is your Commercial Dashboard View</div>} />

        {/* When URL is /admin, show your Admin panel with the Product Creation Form */}
        <Route 
          path="/admin" 
          element={
            <main className="min-h-screen bg-slate-100 p-6">
              <div className="mx-auto max-w-7xl">
                <SmartMatchHeader />
              </div>
            </main>
          } 
        />
      </Routes>
    </BrowserRouter>
  );
}
const rootElement = document.getElementById("app");

if (!rootElement) {
  throw new Error("Root element #app not found.");
}


createRoot(rootElement).render(
  <React.StrictMode>
    <App />
  </React.StrictMode>
);