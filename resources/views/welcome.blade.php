// resources/js/pages/Portal.tsx
import React from 'react';

interface ModuleCardProps {
  title: string;
  description: string;
  tag: string;
  href: string;
  available: boolean;
  icon: React.ReactNode;
}

export default function Portal() {
  const modules: ModuleCardProps[] = [
    {
      title: "SmartMatch Analytics",
      description: "Análisis comparativo de productos, simulador de precios por m² y detección de canibalización entre marcas.",
      tag: "Módulo Activo",
      href: "/smartmatch",
      available: true,
      icon: (
        <svg className="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
        </svg>
      )
    },
    {
      title: "Panel de Administración",
      description: "Gestión de equivalencias, carga de productos de la competencia y configuración de reglas de negocio.",
      tag: "Gestión",
      href: "/admin",
      available: true,
      icon: (
        <svg className="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
      )
    },
    {
      title: "Desplazamiento e Ingresos",
      description: "Monitoreo de cuota de mercado por sucursal y proyección de volumen de ventas.",
      tag: "Próximamente",
      href: "#",
      available: false,
      icon: (
        <svg className="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
        </svg>
      )
    }
  ];

  return (
    <div className="min-h-screen bg-slate-900 text-slate-100 flex flex-col justify-between p-8">
      <div className="max-w-6xl mx-auto w-full pt-8">
        
        {/* Encabezado */}
        <div className="mb-12 border-b border-slate-800 pb-6 flex items-center justify-between">
          <div>
            <span className="text-xs font-bold uppercase tracking-wider text-blue-500 bg-blue-950/80 px-3 py-1 rounded-full border border-blue-800">
              Corporación Azul
            </span>
            <h1 className="text-3xl font-bold mt-3 text-white">
              Suite de Analítica de Marketing
            </h1>
            <p className="text-slate-400 text-sm mt-1">
              Selecciona el módulo de trabajo que deseas acceder.
            </p>
          </div>
        </div>

        {/* Grid de Módulos */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {modules.map((mod, index) => (
            <div 
              key={index}
              className={`relative flex flex-col justify-between rounded-2xl border p-6 transition-all duration-200 ${
                mod.available 
                  ? "bg-slate-800/60 border-slate-700 hover:border-blue-500 hover:shadow-lg hover:shadow-blue-500/10" 
                  : "bg-slate-800/20 border-slate-800 opacity-60 cursor-not-allowed"
              }`}
            >
              <div>
                <div className="flex items-center justify-between mb-4">
                  <div className="p-3 bg-slate-900 rounded-xl border border-slate-700">
                    {mod.icon}
                  </div>
                  <span className={`text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full ${
                    mod.available 
                      ? "bg-blue-900/50 text-blue-400 border border-blue-700/50" 
                      : "bg-slate-800 text-slate-500"
                  }`}>
                    {mod.tag}
                  </span>
                </div>

                <h2 className="text-lg font-bold text-white mb-2">{mod.title}</h2>
                <p className="text-slate-400 text-xs leading-relaxed mb-6">
                  {mod.description}
                </p>
              </div>

              {mod.available ? (
                <a
                  href={mod.href}
                  className="w-full text-center py-2.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-semibold text-xs transition-colors"
                >
                  Ingresar al módulo
                </a>
              ) : (
                <button 
                  disabled 
                  className="w-full text-center py-2.5 px-4 rounded-xl bg-slate-800 text-slate-500 font-semibold text-xs cursor-not-allowed"
                >
                  En desarrollo
                </button>
              )}
            </div>
          ))}
        </div>

      </div>

      {/* Footer */}
      <footer className="max-w-6xl mx-auto w-full pt-12 text-center border-t border-slate-800 text-xs text-slate-500">
        Corporación Azul © {new Date().getFullYear()} — Plataforma Interna de Analítica
      </footer>
    </div>
  );
}