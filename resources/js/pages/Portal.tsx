import React from "react";

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
      description:
        "Análisis comparativo entre marcas, simulador de inversión por m² y detección de canibalización de productos.",
      tag: "Módulo Activo",
      href: "/smartmatch",
      available: true,
      icon: (
        <svg className="h-6 w-6 text-[#002F6C]" fill="none" stroke="currentColor" strokeWidth={2} viewBox="0 0 24 24">
          <path strokeLinecap="round" strokeLinejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
        </svg>
      ),
    },
    {
      title: "Gestión de Equivalencias",
      description:
        "Panel administrativo para alta de productos de la competencia, mapeo de catálogo y configuración de reglas.",
      tag: "Administración",
      href: "/admin",
      available: true,
      icon: (
        <svg className="h-6 w-6 text-[#002F6C]" fill="none" stroke="currentColor" strokeWidth={2} viewBox="0 0 24 24">
          <path strokeLinecap="round" strokeLinejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
          <path strokeLinecap="round" strokeLinejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
      ),
    },
    {
      title: "Desplazamiento por Sucursal",
      description:
        "Monitoreo de cuota de mercado en tiempo real, volumen de ventas y desempeño por plaza comercial.",
      tag: "Próximamente",
      href: "#",
      available: false,
      icon: (
        <svg className="h-6 w-6 text-slate-400" fill="none" stroke="currentColor" strokeWidth={2} viewBox="0 0 24 24">
          <path strokeLinecap="round" strokeLinejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28 2.28 5.941" />
        </svg>
      ),
    },
  ];

  return (
    <div className="flex min-h-screen flex-col justify-between bg-slate-100 p-6 sm:p-10">
      <div className="mx-auto w-full max-w-6xl">
        
        <div className="mb-8 overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-900/5">
          <div className="h-1.5 w-full bg-gradient-to-r from-[#002F6C] via-[#002F6C] to-[#C8102E]" />

          <div className="p-6 sm:p-8">
            <div className="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
              <div className="flex items-center gap-5">
                <div className="flex h-16 w-16 shrink-0 items-center justify-center rounded-xl bg-slate-50 p-2.5 ring-1 ring-slate-200/60">
                  <img
                    src="images/logos/logo-corporacion-azul.png"
                    alt="Corporación Azul"
                    className="h-full w-full object-contain"
                  />
                </div>

                <div>
                  <div className="flex items-center gap-2">
                    <span className="text-xs font-extrabold uppercase tracking-widest text-[#002F6C]">
                      Corporación Azul
                    </span>
                    <span className="h-1 w-1 rounded-full bg-slate-300" />
                    <span className="text-xs font-bold uppercase tracking-widest text-[#C8102E]">
                      Área de Marketing
                    </span>
                  </div>

                  <h1 className="mt-1 text-2xl font-black tracking-tight text-[#002F6C] sm:text-3xl">
                    Suite de Analítica Estratégica
                  </h1>

                  <p className="mt-1 text-xs sm:text-sm text-slate-500">
                    Selecciona el módulo de trabajo al que deseas ingresar.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div className="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
          {modules.map((mod, index) => (
            <div
              key={index}
              className={`group relative flex flex-col justify-between rounded-2xl bg-white p-6 shadow-sm ring-1 transition-all duration-200 ${
                mod.available
                  ? "ring-slate-900/5 hover:-translate-y-1 hover:shadow-md hover:ring-[#002F6C]/30"
                  : "bg-slate-50/50 ring-slate-200/60 opacity-70"
              }`}
            >
              <div>
                <div className="mb-4 flex items-center justify-between">
                  <div
                    className={`flex h-12 w-12 items-center justify-center rounded-xl ring-1 ${
                      mod.available
                        ? "bg-slate-50 ring-slate-200/80 group-hover:bg-[#002F6C]/5 group-hover:ring-[#002F6C]/20"
                        : "bg-slate-100 ring-slate-200"
                    }`}
                  >
                    {mod.icon}
                  </div>

                  <span
                    className={`rounded-full px-3 py-1 text-[10px] font-extrabold uppercase tracking-wider ${
                      mod.available
                        ? "bg-[#002F6C]/10 text-[#002F6C]"
                        : "bg-slate-200/70 text-slate-500"
                    }`}
                  >
                    {mod.tag}
                  </span>
                </div>

                <h2 className="text-lg font-bold text-[#002F6C]">{mod.title}</h2>
                <p className="mt-2 text-xs leading-relaxed text-slate-500">
                  {mod.description}
                </p>
              </div>

              <div className="mt-6 pt-4 border-t border-slate-100">
                {mod.available ? (
                  <a
                    href={mod.href}
                    className="flex w-full items-center justify-center gap-2 rounded-xl bg-[#002F6C] px-4 py-2.5 text-xs font-bold text-white shadow-sm transition hover:bg-[#1B2A56] active:scale-[0.98]"
                  >
                    Ingresar al módulo
                    <svg className="h-4 w-4" fill="none" stroke="currentColor" strokeWidth={2.5} viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                  </a>
                ) : (
                  <button
                    disabled
                    className="w-full rounded-xl bg-slate-100 py-2.5 text-xs font-bold text-slate-400 cursor-not-allowed"
                  >
                    En desarrollo
                  </button>
                )}
              </div>
            </div>
          ))}
        </div>

      </div>

      <footer className="mt-12 text-center text-xs font-medium text-slate-400">
        Corporación Azul © {new Date().getFullYear()} — Plataforma Interna de Inteligencia Comercial
      </footer>
    </div>
  );
}