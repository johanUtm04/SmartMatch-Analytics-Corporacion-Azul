import { useEffect, useState } from "react";
import { useSmartMatch } from "./hooks/useSmartMatch";
import { useSmartMatchMatches } from "./hooks/useSmartMatchMatches";

import SmartMatchHeader from "./components/SmartMatchHeader";
import MatchSelector from "./components/MatchSelector";
import PriceSimulator from "./components/PriceSimulator";
import StrategicAlert from "./components/StrategicAlert";
import ProductComparison from "./components/ProductComparison";
import CommercialArgument from "./components/CommercialArgument";

export default function Dashboard() {
  const [matchId, setMatchId] = useState<number | null>(null);
  const [areaM2, setAreaM2] = useState<number>(500);

  const {
    matches,
    loading: matchesLoading,
    error: matchesError,
    refetch: refetchMatches,
  } = useSmartMatchMatches();

  useEffect(() => {
    if (!matchId && matches.length > 0) {
      setMatchId(matches[0].id);
    }
  }, [matches, matchId]);

  const {
    data,
    loading: smartMatchLoading,
    error: smartMatchError,
    refetch: refetchSmartMatch,
  } = useSmartMatch({
    matchId: matchId ?? undefined,
    areaM2,
  });

  const isLoading = matchesLoading || smartMatchLoading;
  const hasMatchSelected = Boolean(matchId);

  return (
    <main className="min-h-screen bg-slate-100 p-6">
      <div className="mx-auto max-w-7xl">
        <SmartMatchHeader />

        <MatchSelector
          matches={matches}
          selectedMatchId={matchId}
          loading={matchesLoading}
          error={matchesError}
          onChange={setMatchId}
          onRetry={refetchMatches}
        />

        {isLoading && (
          <StatusCard
            title="Loading SmartMatch..."
            message="Loading comparisons and calculating the selected product matchup."
          />
        )}

        {!isLoading && matchesError && (
          <StatusCard
            title="Could not load comparisons"
            message={matchesError}
            actionLabel="Try again"
            onAction={refetchMatches}
          />
        )}

        {!isLoading && !matchesError && !hasMatchSelected && (
          <StatusCard
            title="No comparison selected"
            message="There are no active SmartMatch comparisons available yet."
          />
        )}

        {!isLoading && !matchesError && smartMatchError && (
          <StatusCard
            title="SmartMatch calculation error"
            message={smartMatchError}
            actionLabel="Try again"
            onAction={refetchSmartMatch}
          />
        )}

        {!isLoading && !matchesError && !smartMatchError && data && (
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
          type="button"
          onClick={onAction}
          className="mt-4 rounded-xl bg-slate-900 px-4 py-2 font-semibold text-white transition hover:bg-slate-700"
        >
          {actionLabel}
        </button>
      )}
    </div>
  );
}