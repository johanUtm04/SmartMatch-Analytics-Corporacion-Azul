import type { AdminEquivalenceMatch } from "../types/admin";

type MatchesTableProps = {
  matches: AdminEquivalenceMatch[];
};

export default function MatchesTable({ matches }: MatchesTableProps) {
  return (
    <section className="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
      <div className="mb-4 flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
        <div>
          <h2 className="text-xl font-bold text-slate-900">
            Comparaciones de equivalencia
          </h2>

          <p className="text-sm text-slate-500">
            Comparaciones activas e inactivas utilizadas por el dashboard
            SmartMatch.
          </p>
        </div>

        <button
          type="button"
          className="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-700"
        >
          Nueva comparación
        </button>
      </div>

      {matches.length === 0 ? (
        <EmptyState />
      ) : (
        <div className="overflow-x-auto">
          <table className="min-w-full border-separate border-spacing-y-2 text-left text-sm">
            <thead>
              <tr className="text-slate-500">
                <th className="px-3 py-2">Estado</th>
                <th className="px-3 py-2">Producto propio</th>
                <th className="px-3 py-2">Competidor</th>
                <th className="px-3 py-2">Gama</th>
                <th className="px-3 py-2">Tipo</th>
                <th className="px-3 py-2">Prioridad</th>
                <th className="px-3 py-2 text-right">Acciones</th>
              </tr>
            </thead>

            <tbody>
              {matches.map((match) => (
                <MatchRow key={match.id} match={match} />
              ))}
            </tbody>
          </table>
        </div>
      )}
    </section>
  );
}

function MatchRow({ match }: { match: AdminEquivalenceMatch }) {
  return (
    <tr className="rounded-xl bg-slate-50 align-top">
      <td className="px-3 py-3">
        <StatusBadge isActive={match.is_active} />
      </td>

      <td className="px-3 py-3 text-slate-700">
        <p className="font-semibold text-slate-900">{match.own_product}</p>
        <p className="mt-1 font-mono text-xs text-slate-500">
          {match.own_sku}
        </p>
      </td>

      <td className="px-3 py-3 text-slate-700">
        <p className="font-semibold text-slate-900">
          {match.competitor_product}
        </p>
        <p className="mt-1 font-mono text-xs text-slate-500">
          {match.competitor_sku}
        </p>
      </td>

      <td className="px-3 py-3 text-slate-700">
        <p className="font-semibold text-slate-900">{match.gama}</p>
        <p className="mt-1 text-xs text-slate-500">
          {match.technical_segmentation}
        </p>
      </td>

      <td className="px-3 py-3">
        <span className="rounded-full bg-blue-50 px-3 py-1 text-xs font-bold uppercase text-blue-800">
          {formatMatchType(match.match_type)}
        </span>
      </td>

      <td className="px-3 py-3 text-slate-700">{match.priority}</td>

      <td className="px-3 py-3">
        <div className="flex justify-end gap-2">
          <button
            type="button"
            className="rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-semibold text-slate-700 transition hover:bg-slate-100"
          >
            Editar
          </button>

          {match.is_active ? (
            <button
              type="button"
              className="rounded-lg border border-amber-200 px-3 py-1.5 text-xs font-semibold text-amber-700 transition hover:bg-amber-50"
            >
              Desactivar
            </button>
          ) : (
            <button
              type="button"
              className="rounded-lg border border-green-200 px-3 py-1.5 text-xs font-semibold text-green-700 transition hover:bg-green-50"
            >
              Reactivar
            </button>
          )}
        </div>
      </td>
    </tr>
  );
}

function StatusBadge({ isActive }: { isActive: boolean }) {
  return (
    <span
      className={`rounded-full px-3 py-1 text-xs font-bold uppercase ${
        isActive ? "bg-green-100 text-green-800" : "bg-slate-200 text-slate-700"
      }`}
    >
      {isActive ? "Activa" : "Inactiva"}
    </span>
  );
}

function EmptyState() {
  return (
    <div className="rounded-xl border border-dashed border-slate-300 bg-slate-50 p-6 text-center">
      <h3 className="font-bold text-slate-900">
        No hay comparaciones registradas
      </h3>

      <p className="mt-1 text-sm text-slate-500">
        Crea comparaciones para alimentar el selector dinámico del dashboard.
      </p>
    </div>
  );
}

function formatMatchType(matchType: string) {
  const labels: Record<string, string> = {
    direct: "Directa",
    indirect: "Indirecta",
    monopoly_temporal: "Monopolio temporal",
    no_equivalent: "Sin equivalente",
  };

  return labels[matchType] ?? matchType;
}