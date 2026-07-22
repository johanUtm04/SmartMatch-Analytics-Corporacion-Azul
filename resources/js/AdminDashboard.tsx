import { useEffect, useState } from "react";
import ProductsTable from "./admin/components/ProductsTable";
import { useAdminData } from "./admin/hooks/useAdminData";


type Brand = {
  id: number;
  name: string;
};

type Product = {
  id: number;
  brand_id: number;
  brand: string;
  sku: string;
  erp_name: string;
  technical_name: string;
  guarantee_years: number;
  volume_liters: number;
  base_type: string | null;
  is_fibrated: boolean;
  requires_separate_primer: boolean;
  price: number;
  currency: string;
  surface_type: string;
  consumption_per_m2: number;
  min_coverage_m2: number;
  max_coverage_m2: number;
};

type EquivalenceMatch = {
  id: number;
  own_product_id: number;
  competitor_product_id: number;
  match_type: string;
  gama: string;
  technical_segmentation: string;
  strategic_analysis: string;
  priority: number;
  is_active: boolean;
  own_sku: string;
  own_product: string;
  competitor_sku: string;
  competitor_product: string;
};

export default function AdminDashboard() {

  const {
    brands,
    products,
    matches,
    loading,
    error,
    refetch,
  } = useAdminData();

  return (
    <main className="min-h-screen bg-slate-100 p-6">
      <div className="mx-auto max-w-7xl">
        <header className="mb-6">
          <p className="text-sm font-semibold uppercase tracking-[0.25em] text-blue-700">
            SmartMatch Admin
          </p>

          <h1 className="mt-2 text-3xl font-bold text-slate-900">
            Data Management Panel
          </h1>

          <p className="mt-2 max-w-4xl text-slate-600">
            Manage products, brands, prices, performance data, and equivalence
            matches used by the SmartMatch commercial dashboard.
          </p>
        </header>

        {loading && (
          <StatusCard
            title="Loading admin data..."
            message="Loading brands, products, and equivalence matches."
          />
        )}

        {!loading && error && (
          <StatusCard
            title="Admin loading error"
            message={error}
            actionLabel="Try again"
            onAction={refetch}
          />
        )}

        {!loading && !error && (
          <>
            <section className="mb-6 grid grid-cols-1 gap-4 md:grid-cols-3">
              <SummaryCard label="Brands" value={brands.length} />
              <SummaryCard label="Products" value={products.length} />
              <SummaryCard label="Matches" value={matches.length} />
            </section>

            <section className="grid grid-cols-1 gap-6">
              <ProductsTable products={products} />
              <MatchesTable matches={matches} />
            </section>
          </>
        )}
      </div>
    </main>
  );
}

function SummaryCard({ label, value }: { label: string; value: number }) {
  return (
    <article className="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
      <p className="text-sm font-semibold uppercase tracking-wide text-slate-500">
        {label}
      </p>

      <p className="mt-2 text-3xl font-bold text-slate-900">{value}</p>
    </article>
  );
}

function MatchesTable({ matches }: { matches: EquivalenceMatch[] }) {
  return (
    <section className="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
      <div className="mb-4 flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
        <div>
          <h2 className="text-xl font-bold text-slate-900">
            Equivalence Matches
          </h2>
          <p className="text-sm text-slate-500">
            Active and inactive comparisons used by the dashboard.
          </p>
        </div>

        <button
          type="button"
          className="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-700"
        >
          New match
        </button>
      </div>

      <div className="overflow-x-auto">
        <table className="min-w-full border-separate border-spacing-y-2 text-left text-sm">
          <thead>
            <tr className="text-slate-500">
              <th className="px-3 py-2">Status</th>
              <th className="px-3 py-2">Own product</th>
              <th className="px-3 py-2">Competitor</th>
              <th className="px-3 py-2">Gama</th>
              <th className="px-3 py-2">Type</th>
              <th className="px-3 py-2">Priority</th>
            </tr>
          </thead>

          <tbody>
            {matches.map((match) => (
              <tr key={match.id} className="rounded-xl bg-slate-50">
                <td className="px-3 py-3">
                  <span
                    className={`rounded-full px-3 py-1 text-xs font-semibold ${
                      match.is_active
                        ? "bg-green-100 text-green-800"
                        : "bg-slate-200 text-slate-700"
                    }`}
                  >
                    {match.is_active ? "Active" : "Inactive"}
                  </span>
                </td>

                <td className="px-3 py-3 text-slate-700">
                  <p className="font-semibold text-slate-900">
                    {match.own_product}
                  </p>
                  <p className="text-xs text-slate-500">{match.own_sku}</p>
                </td>

                <td className="px-3 py-3 text-slate-700">
                  <p className="font-semibold text-slate-900">
                    {match.competitor_product}
                  </p>
                  <p className="text-xs text-slate-500">
                    {match.competitor_sku}
                  </p>
                </td>

                <td className="px-3 py-3 text-slate-700">{match.gama}</td>

                <td className="px-3 py-3 text-slate-700">
                  {match.match_type}
                </td>

                <td className="px-3 py-3 text-slate-700">
                  {match.priority}
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </section>
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

function formatNumber(value: number | null | undefined) {
  if (value === null || value === undefined) {
    return "0";
  }

  return value.toLocaleString("es-MX", {
    minimumFractionDigits: 0,
    maximumFractionDigits: 2,
  });
}