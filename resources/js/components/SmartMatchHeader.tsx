export default function SmartMatchHeader() {
  return (
    <header className="mb-6 flex items-start gap-4 border-b-4 border-[#C8102E] pb-4">
      <img
        src="images/logos/logo-corporacion-azul.png"
        alt="Corporación Azul"
        className="h-14 w-30 flex-shrink-0 object-contain"
      />

      <div>
        <p className="text-sm font-semibold uppercase tracking-[0.25em] text-[#C8102E]">
          Corporación Azul · SmartMatch Analytics
        </p>

        <h1 className="mt-2 text-3xl font-bold text-[#1B2A56]">
          Tablero de Canibalización de Productos (entre marcas)
        </h1>

        <p className="mt-2 max-w-4xl text-slate-600">
          Compara productos equivalentes, calcula costo por m², detecta ventaja
          competitiva y genera <strong className="text-[#1B2A56]">insights estratégicos</strong> para
          marketing, ventas, pricing y estrategia de producto.
        </p>
      </div>

      <div className="flex-shrink-0 self-start md:self-center">
        <button
          type="button"
          onClick={() => console.log('Action clicked')}
          className="rounded-lg bg-[#1B2A56] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-[#152144] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1B2A56]"
        >
          Ir a Admin dashboard
        </button>
      </div>

    </header>
  );
}