import type { SmartMatchOption } from "../services/smartMatchApi";

type MatchSelectorProps = {
  matches: SmartMatchOption[];
  selectedMatchId: number | null;
  loading?: boolean;
  error?: string | null;
  onChange: (matchId: number) => void;
  onRetry?: () => void;
};

export default function MatchSelector({
  matches,
  selectedMatchId,
  loading = false,
  error = null,
  onChange,
  onRetry,
}: MatchSelectorProps) {
  return (
    <section className="mb-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
      <div className="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
          <div className="flex items-center gap-2">
            <h2 className="text-lg font-bold text-[#1B2A56]">
              Selecciona una comparación
            </h2>
            
            {/* The Trigger Button - Note the capital T in popoverTarget */}
            <button
              type="button"
              popoverTarget="product-list-tip" 
              className="cursor-pointer text-slate-400 hover:text-[#1B2A56] text-sm flex items-center justify-center w-5 h-5 rounded-full border border-slate-300 bg-white shadow-sm"
            >
              ?
            </button>
          </div>
        <div
          id="product-list-tip"
          popover="auto"
          className="m-0 mt-2 p-4 max-w-xs bg-white rounded-lg shadow-xl border border-slate-200 text-sm text-slate-600"
        >
          <h4 className="font-semibold text-[#1B2A56] mb-1">Guía de Comparación</h4>
          <p>
            Selecciona dos marcas o productos equivalentes del listado para calcular la tasa de canibalización y el margen cruzado.
          </p>
        </div>
          <p className="text-sm text-slate-500">
            Elige uno de los cruces de productos activos en la base de datos.
          </p>
        </div>

        <div className="w-full md:w-[460px]">
          {loading && (
            <div className="rounded-xl border border-slate-200 bg-[#EEF1F8] px-4 py-3 text-sm text-slate-600">
              Cargando comparaciones...
            </div>
          )}

          {!loading && error && (
            <div className="rounded-xl border border-red-200 bg-red-50 px-4 py-3">
              <p className="text-sm font-semibold text-[#C8102E]">
                No se pudieron cargar las comparaciones.
              </p>

              <p className="mt-1 text-sm text-red-600">{error}</p>

              {onRetry && (
                <button
                  type="button"
                  onClick={onRetry}
                  className="mt-3 rounded-lg bg-[#C8102E] px-3 py-2 text-sm font-semibold text-white transition hover:bg-[#a20d25]"
                >
                  Reintentar
                </button>
              )}
            </div>
          )}

          {!loading && !error && matches.length === 0 && (
            <div className="rounded-xl border border-slate-200 bg-[#EEF1F8] px-4 py-3 text-sm text-slate-600">
              No se encontraron comparaciones activas.
            </div>
          )}

          {!loading && !error && matches.length > 0 && (
            <select
              value={selectedMatchId ?? ""}
              onChange={(event) => onChange(Number(event.target.value))}
              className="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition focus:border-[#1B2A56] focus:ring-2 focus:ring-[#1B2A56]/20"
            >
              {matches.map((match) => (
                <option key={match.id} value={match.id}>
                  {match.label}
                </option>
              ))}
            </select>
          )}
        </div>
      </div>
    </section>
  );
}