import { useEffect, useState } from "react";
import {
  getSmartMatchMatches,
  type SmartMatchOption,
} from "../services/smartMatchApi";

type UseSmartMatchMatchesResult = {
  matches: SmartMatchOption[];
  loading: boolean;
  error: string | null;
  refetch: () => void;
};

export function useSmartMatchMatches(): UseSmartMatchMatchesResult {
  const [matches, setMatches] = useState<SmartMatchOption[]>([]);
  const [loading, setLoading] = useState<boolean>(false);
  const [error, setError] = useState<string | null>(null);
  const [reloadKey, setReloadKey] = useState<number>(0);

    const refetch = () => {
    setReloadKey((current) => current + 1);
  };


    useEffect(() => {
    const controller = new AbortController();

    async function fetchMatches() {
      try {
        setLoading(true);
        setError(null);

        const result = await getSmartMatchMatches(controller.signal);

        setMatches(result);
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
            : "Unexpected error loading SmartMatch matches."
        );

        setMatches([]);
      } finally {
        setLoading(false);
      }
    }

    fetchMatches();

    return () => {
      controller.abort();
    };
  }, [reloadKey]);

  return {
    matches,
    loading,
    error,
    refetch,
  };

}