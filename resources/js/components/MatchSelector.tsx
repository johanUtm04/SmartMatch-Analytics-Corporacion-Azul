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
          <h2 className="text-lg font-bold text-slate-900">
            Select comparison
          </h2>

          <p className="text-sm text-slate-500">
            Choose one of the active product matchups from the database.
          </p>
        </div>

        <div className="w-full md:w-[460px]">
          {loading && (
            <div className="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
              Loading comparisons...
            </div>
          )}

          {!loading && error && (
            <div className="rounded-xl border border-red-200 bg-red-50 px-4 py-3">
              <p className="text-sm font-semibold text-red-700">
                Could not load comparisons.
              </p>

              <p className="mt-1 text-sm text-red-600">{error}</p>

              {onRetry && (
                <button
                  type="button"
                  onClick={onRetry}
                  className="mt-3 rounded-lg bg-red-700 px-3 py-2 text-sm font-semibold text-white transition hover:bg-red-800"
                >
                  Try again
                </button>
              )}
            </div>
          )}

          {!loading && !error && matches.length === 0 && (
            <div className="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
              No active comparisons found.
            </div>
          )}

          {!loading && !error && matches.length > 0 && (
            <select
              value={selectedMatchId ?? ""}
              onChange={(event) => onChange(Number(event.target.value))}
              className="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
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