import { useState } from "react";
import { useSmartMatch } from "./hooks/useSmartMatch";

import SmartMatchHeader from "./components/SmartMatchHeader";
import MatchSelector from "./components/MatchSelector";
import PriceSimulator from "./components/PriceSimulator";
import StrategicAlert from "./components/StrategicAlert";
import ProductComparison from "./components/ProductComparison";
import CommercialArgument from "./components/CommercialArgument";

export default function Dashboard() {
  const [matchId, setMatchId] = useState<number>(31);
  const [areaM2, setAreaM2] = useState<number>(500);

  const { data, loading, error, refetch } = useSmartMatch({
    matchId,
    areaM2,
  });

  return (
    <main className="min-h-screen bg-slate-100 p-6">
      <div className="mx-auto max-w-7xl">
        <SmartMatchHeader />

        <MatchSelector selectedMatchId={matchId} onChange={setMatchId} />

        {loading && (
          <StatusCard
            title="Cargando Resultados"
            message="Calculating the selected product comparison."
          />
        )}

        {error && (
          <StatusCard
            title="SmartMatch error"
            message={error}
            actionLabel="Try again"
            onAction={refetch}
          />
        )}

        {!loading && !error && data && (
          <>
            <StrategicAlert analysis={data.battlefield.analysis} />

            <div className="grid grid-cols-1 gap-6 xl:grid-cols-[360px_1fr]">
              <PriceSimulator
                areaM2={areaM2}
                onAreaChange={setAreaM2}
                ownProduct={data.battlefield.own_product}
                competitorProduct={data.battlefield.competitor_product}
              />

              <div>
                <ProductComparison
                  ownProduct={data.battlefield.own_product}
                  competitorProduct={data.battlefield.competitor_product}
                />

                <CommercialArgument
                  match={data.match}
                  analysis={data.battlefield.analysis}
                />
              </div>
            </div>
          </>
        )}
      </div>
    </main>
  );
}

function StatusCard({
  title,
  message,
  actionLabel,
  onAction,
}: {
  title: string;
  message: string;
  actionLabel?: string;
  onAction?: () => void;
}) {
  return (
    <div className="rounded-2xl bg-white p-6 shadow-sm">
      <h1 className="text-xl font-bold text-slate-900">{title}</h1>

      <p className="mt-2 text-slate-600">{message}</p>

      {actionLabel && onAction && (
        <button
          onClick={onAction}
          className="mt-4 rounded-xl bg-slate-900 px-4 py-2 font-semibold text-white transition hover:bg-slate-700"
        >
          {actionLabel}
        </button>
      )}
    </div>
  );
}