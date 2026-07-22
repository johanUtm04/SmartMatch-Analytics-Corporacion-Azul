import type { AdminProduct } from "../types/admin";

type ProductsTableProps = {
  products: AdminProduct[];
};

export default function ProductsTable({ products }: ProductsTableProps) {
  return (
    <section className="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
      <div className="mb-4 flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
        <div>
          <h2 className="text-xl font-bold text-slate-900">Productos</h2>

          <p className="text-sm text-slate-500">
            Productos disponibles para crear comparaciones SmartMatch.
          </p>
        </div>

        <button
          type="button"
          className="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-700"
        >
          Nuevo producto
        </button>
      </div>

      {products.length === 0 ? (
        <EmptyState />
      ) : (
        <div className="overflow-x-auto">
          <table className="min-w-full border-separate border-spacing-y-2 text-left text-sm">
            <thead>
              <tr className="text-slate-500">
                <th className="px-3 py-2">Marca</th>
                <th className="px-3 py-2">SKU</th>
                <th className="px-3 py-2">Nombre ERP</th>
                <th className="px-3 py-2">Garantía</th>
                <th className="px-3 py-2">Precio</th>
                <th className="px-3 py-2">Volumen</th>
                <th className="px-3 py-2">Rendimiento</th>
                <th className="px-3 py-2">Cobertura</th>
                <th className="px-3 py-2 text-right">Acciones</th>
              </tr>
            </thead>

            <tbody>
              {products.map((product) => (
                <ProductRow key={product.id} product={product} />
              ))}
            </tbody>
          </table>
        </div>
      )}
    </section>
  );
}

function ProductRow({ product }: { product: AdminProduct }) {
  return (
    <tr className="rounded-xl bg-slate-50 align-top">
      <td className="px-3 py-3">
        <span className="rounded-full bg-blue-50 px-3 py-1 text-xs font-bold uppercase text-blue-800">
          {product.brand}
        </span>
      </td>

      <td className="px-3 py-3 font-mono text-xs text-slate-700">
        {product.sku}
      </td>

      <td className="px-3 py-3 text-slate-700">
        <p className="font-semibold text-slate-900">{product.erp_name}</p>
        <p className="mt-1 text-xs text-slate-500">
          {product.technical_name}
        </p>
      </td>

      <td className="px-3 py-3 text-slate-700">
        {product.guarantee_years > 0
          ? `${product.guarantee_years} años`
          : "Sin garantía"}
      </td>

      <td className="px-3 py-3 font-semibold text-slate-900">
        ${formatNumber(product.price)} {product.currency}
      </td>

      <td className="px-3 py-3 text-slate-700">
        {formatNumber(product.volume_liters)} L
      </td>

      <td className="px-3 py-3 text-slate-700">
        {formatNumber(product.consumption_per_m2)} L/m²
      </td>

      <td className="px-3 py-3 text-slate-700">
        {formatNumber(product.min_coverage_m2)} -{" "}
        {formatNumber(product.max_coverage_m2)} m²
      </td>

      <td className="px-3 py-3">
        <div className="flex justify-end gap-2">
          <button
            type="button"
            className="rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-semibold text-slate-700 transition hover:bg-slate-100"
          >
            Editar
          </button>

          <button
            type="button"
            className="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-semibold text-red-700 transition hover:bg-red-50"
          >
            Eliminar
          </button>
        </div>
      </td>
    </tr>
  );
}

function EmptyState() {
  return (
    <div className="rounded-xl border border-dashed border-slate-300 bg-slate-50 p-6 text-center">
      <h3 className="font-bold text-slate-900">No hay productos registrados</h3>

      <p className="mt-1 text-sm text-slate-500">
        Crea productos para poder construir nuevas comparaciones SmartMatch.
      </p>
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