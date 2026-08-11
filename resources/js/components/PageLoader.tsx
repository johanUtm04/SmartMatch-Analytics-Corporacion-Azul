import React from 'react';

interface PageLoaderProps {
  message?: string;
}

export default function PageLoader({ message = "Cargando módulo..." }: PageLoaderProps) {
  return (
    <div className="fixed inset-0 z-50 flex flex-col items-center justify-center bg-slate-900/90 backdrop-blur-md transition-opacity">
      <div className="flex flex-col items-center gap-4 p-6 text-center">
        <img
          src="/images/cruz-azul-logo.png"
          alt="Corporación Azul"
          className="h-20 w-auto animate-pulse drop-shadow-lg"
        />
        
        <div className="flex items-center gap-2 text-slate-200 font-medium text-sm">
          <span className="h-4 w-4 animate-spin rounded-full border-2 border-white border-t-transparent"></span>
          <span>{message}</span>
        </div>
      </div>
    </div>
  );
}