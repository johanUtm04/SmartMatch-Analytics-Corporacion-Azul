import { useEffect, useState } from "react";
import { calculateSmartMatch } from "../services/smartMatchApi";
import type {
  CalculateSmartMatchParams,
  SmartMatchResponse,
} from "../types/smartMatch";

type UseSmartMatchResult = {
  data: SmartMatchResponse | null;
  loading: boolean;
  error: string | null;
  refetch: () => void;
};

export function useSmartMatch(
  params: CalculateSmartMatchParams
): UseSmartMatchResult {
  const [data, setData] = useState<SmartMatchResponse | null>(null);
  const [loading, setLoading] = useState<boolean>(false);
  const [error, setError] = useState<string | null>(null);
  const [reloadKey, setReloadKey] = useState<number>(0);

  const refetch = () => {
    setReloadKey((current) => current + 1);
  };

  useEffect(() => {
    const hasMatchId = Boolean(params.matchId);
    const hasSkus = Boolean(params.ownSku && params.competitorSku);

    if (!hasMatchId && !hasSkus) {
      setData(null);
      setError("No SmartMatch comparison selected.");
      return;
    }

    const controller = new AbortController();

    async function fetchSmartMatch() {
      try {
        setLoading(true);
        setError(null);

        const result = await calculateSmartMatch(
          {
            matchId: params.matchId,
            ownSku: params.ownSku,
            competitorSku: params.competitorSku,
            areaM2: params.areaM2 ?? 500,
          },
          controller.signal
        );

        setData(result);
      } catch (requestError) {
        if (
          requestError instanceof DOMException &&
          requestError.name === "AbortError"
        ) {
          return;
        }

        setError(
          requestError instanceof Error
            ? requestError.message
            : "Unexpected SmartMatch error."
        );

        setData(null);
      } finally {
        setLoading(false);
      }
    }

    fetchSmartMatch();

    return () => {
      controller.abort();
    };
  }, [
    params.matchId,
    params.ownSku,
    params.competitorSku,
    params.areaM2,
    reloadKey,
  ]);

  return {
    data,
    loading,
    error,
    refetch,
  };
}