import React from 'react';
import { createRoot } from 'react-dom/client';

// A simple placeholder component to test if the connection works
const App = () => {
    return (
        <div className="container p-5 text-center">
            <div className="card shadow-sm p-4 bg-white">
                <h1 className="text-success fw-bold">¡React está vivo! 🚀</h1>
                <p className="text-muted">El contenedor de Laravel y Vite se ha enlazado correctamente.</p>
            </div>
        </div>
    );
};

// Find the HTML element with id "root"
const container = document.getElementById('root');

if (container) {
    const root = createRoot(container);
    // Render our App component into the DOM
    root.render(<App />);
} else {
    console.error("No se encontró el elemento contenedor con el ID 'root'.");
}