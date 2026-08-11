export default function SmartMatchHeader() {
  return (
    <header className="mb-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
      <div className="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
        
        <div className="flex items-start gap-5">
          <div className="flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-xl bg-slate-50 p-2 border border-slate-100">
            <img
              src="images/logos/logo-corporacion-azul.png"
              alt="Corporación Azul"
              className="h-full w-full object-contain"
            />
          </div>

          <div>
            <div className="flex items-center gap-2">
              <span className="inline-flex items-center rounded-full bg-[#002F6C]/10 px-2.5 py-0.5 text-xs font-bold uppercase tracking-wider text-[#002F6C]">
                Corporación Azul
              </span>
              <span className="text-slate-300">•</span>
              <span className="text-xs font-semibold uppercase tracking-wider text-[#C8102E]">
                SmartMatch Analytics
              </span>
            </div>

            <h1 className="mt-1.5 text-2xl font-black tracking-tight text-[#002F6C] sm:text-3xl">
              Tablero de Canibalización de Productos
            </h1>

            <p className="mt-1.5 max-w-3xl text-sm leading-relaxed text-slate-600">
              Compara productos equivalentes, calcula costo por m², detecta ventaja
              competitiva y genera <strong className="font-semibold text-[#002F6C]">insights estratégicos</strong> para
              marketing, ventas, pricing y estrategia de producto.
            </p>
          </div>
        </div>

        <div className="flex flex-wrap items-center gap-2.5 border-t border-slate-100 pt-4 md:flex-nowrap md:border-t-0 md:pt-0">
          <a
            href="/"
            className="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs font-bold text-slate-700 shadow-sm transition hover:bg-slate-50 hover:text-[#002F6C]"
          >
            <svg className="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Portal
          </a>

          <a
            href="/admin"
            className="inline-flex items-center gap-2 rounded-xl bg-[#002F6C] px-4 py-2.5 text-xs font-bold text-white shadow-md shadow-[#002F6C]/20 transition hover:bg-[#1B2A56]"
          >
            <svg className="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Administrador
          </a>
        </div>

      </div>

      <div className="mt-5 h-1 w-full overflow-hidden rounded-full bg-slate-100 flex">
        <div className="h-full w-2/3 bg-[#002F6C]"></div>
        <div className="h-full w-1/3 bg-[#C8102E]"></div>
      </div>
    </header>
  );
}