import type { SmartMatchProduct } from "../types/smartMatch";

type ProductCardProps = {
  product: SmartMatchProduct;
  label: string;
};

export default function ProductCard({ product, label }: ProductCardProps) {
  return (
    <article className="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
      <p className="text-sm font-semibold uppercase tracking-wide text-slate-500">
        {label}
      </p>

      <div className="mt-3">
        <h2 className="text-2xl font-bold text-slate-900">{product.brand}</h2>

        <h3 className="mt-1 text-lg font-semibold text-slate-800">
          {product.name}
        </h3>

        <p className="mt-2 text-sm text-slate-500">ERP: {product.erp_name}</p>
        <p className="text-sm text-slate-500">SKU: {product.sku}</p>
      </div>

      <div className="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2">
        <DataPoint
          label="Precio de la cubeta"
          value={`$${formatNumber(product.bucket_price)} ${product.currency}`}
        />

        <DataPoint
          label="Volumen de la cubeta"
          value={`${formatNumber(product.volume_liters)} L`}
        />

        <DataPoint
          label="Consumo"
          value={`${formatNumber(product.consumption_per_m2)} L/m²`}
        />

        <DataPoint
          label="Cobertura"
          value={`${formatNumber(product.min_coverage_m2)} - ${formatNumber(
            product.max_coverage_m2
          )} m²`}
        />

        <DataPoint
          label="Costo por m²"
          value={`$${formatNumber(product.cost_m2)} ${product.currency}`}
          highlight
        />

        <DataPoint
          label="Inversión total"
          value={`$${formatNumber(product.total_investment)} ${
            product.currency
          }`}
          highlight
        />
      </div>
    </article>
  );
}

function DataPoint({
  label,
  value,
  highlight = false,
}: {
  label: string;
  value: string;
  highlight?: boolean;
}) {
  return (
    <div
      className={`rounded-xl p-4 ${
        highlight ? "bg-blue-50" : "bg-slate-50"
      }`}
    >
      <p className="text-xs font-semibold uppercase tracking-wide text-slate-500">
        {label}
      </p>

      <p
        className={`mt-1 text-base font-bold ${
          highlight ? "text-blue-900" : "text-slate-900"
        }`}
      >
        {value}
      </p>
    </div>
  );
}

function formatNumber(value: number) {
  return value.toLocaleString("es-MX", {
    minimumFractionDigits: 0,
    maximumFractionDigits: 2,
  });
}