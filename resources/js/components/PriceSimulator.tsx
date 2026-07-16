import type { SmartMatchProduct } from "../types/smartMatch";

type PriceSimulatorProps = {
  areaM2: number;
  onAreaChange: (areaM2: number) => void;
  ownProduct: SmartMatchProduct;
  competitorProduct: SmartMatchProduct;
};

export default function PriceSimulator({
  areaM2,
  onAreaChange,
  ownProduct,
  competitorProduct,
}: PriceSimulatorProps) {
  return (
    <aside className="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
      <h2 className="text-lg font-bold text-slate-900">Simulador de Escenarios</h2>

      <p className="mt-1 text-sm text-slate-500">
        Ajusta el área del proyecto para estimar la inversión total.
      </p>

      <div className="mt-5">
        <label className="text-sm font-semibold text-slate-700">
          Área del proyecto: {formatNumber(areaM2)} m²
        </label>

        <input
          type="range"
          min={50}
          max={5000}
          step={50}
          value={areaM2}
          onChange={(event) => onAreaChange(Number(event.target.value))}
          className="mt-3 w-full"
        />

        <input
          type="number"
          min={1}
          value={areaM2}
          onChange={(event) => onAreaChange(Number(event.target.value))}
          className="mt-3 w-full rounded-xl border border-slate-300 px-4 py-2 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
        />
      </div>

      <div className="mt-6 space-y-4">
        <InvestmentCard product={ownProduct} />
        <InvestmentCard product={competitorProduct} />
      </div>
    </aside>
  );
}

function InvestmentCard({ product }: { product: SmartMatchProduct }) {
  return (
    <div className="rounded-xl bg-slate-50 p-4">
      <p className="text-xs font-semibold uppercase tracking-wide text-slate-500">
        {product.brand} 
      </p>

      <h3 className="mt-1 text-sm font-bold text-slate-900">{product.name}</h3>

      <p className="mt-1 text-xs text-slate-500">SKU: {product.sku}</p>

      <div className="mt-3 grid grid-cols-2 gap-3 text-sm">
        <div>
          <p className="text-slate-500">Costo/m²</p>
          <p className="font-bold text-slate-900">
            ${formatNumber(product.cost_m2)} {product.currency}
          </p>
        </div>

        <div>
          <p className="text-slate-500">Inversión</p>
          <p className="font-bold text-slate-900">
            ${formatNumber(product.total_investment)} {product.currency}
          </p>
        </div>
      </div>
    </div>
  );
}

function formatNumber(value: number) {
  return value.toLocaleString("es-MX", {
    minimumFractionDigits: 0,
    maximumFractionDigits: 2,
  });
}