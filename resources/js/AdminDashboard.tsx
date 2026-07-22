import ProductsTable from "./admin/components/ProductsTable";
import MatchesTable from "./admin/components/MatchesTable";
import { useAdminData } from "./admin/hooks/useAdminData";


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