import { useEffect, useState } from "react";
import {
  getAdminBrands,
  getAdminEquivalenceMatches,
  getAdminProducts,
} from "../services/adminApi";
import type {
  AdminBrand,
  AdminEquivalenceMatch,
  AdminProduct,
} from "../types/admin";

type UseAdminDataResult = {
  brands: AdminBrand[];
  products: AdminProduct[];
  matches: AdminEquivalenceMatch[];
  loading: boolean;
  error: string | null;
  refetch: () => void;
};

export function useAdminData(): UseAdminDataResult {
  const [brands, setBrands] = useState<AdminBrand[]>([]);
  const [products, setProducts] = useState<AdminProduct[]>([]);
  const [matches, setMatches] = useState<AdminEquivalenceMatch[]>([]);

  const [loading, setLoading] = useState<boolean>(false);
  const [error, setError] = useState<string | null>(null);
  const [reloadKey, setReloadKey] = useState<number>(0);

  const refetch = () => {
    setReloadKey((current) => current + 1);
  };

  useEffect(() => {
    const controller = new AbortController();

    async function loadAdminData() {
      try {
        setLoading(true);
        setError(null);

        const [brandsResult, productsResult, matchesResult] =
          await Promise.all([
            getAdminBrands(controller.signal),
            getAdminProducts(controller.signal),
            getAdminEquivalenceMatches(controller.signal),
          ]);

        setBrands(brandsResult);
        setProducts(productsResult);
        setMatches(matchesResult);
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
            : "Unexpected error loading admin data."
        );

        setBrands([]);
        setProducts([]);
        setMatches([]);
      } finally {
        setLoading(false);
      }
    }

    loadAdminData();

    return () => {
      controller.abort();
    };
  }, [reloadKey]);

  return {
    brands,
    products,
    matches,
    loading,
    error,
    refetch,
  };
}