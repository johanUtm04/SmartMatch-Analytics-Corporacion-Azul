import { useState } from "react";
import type { ProductFormData } from "../../types/ProductModal";

type Brand = {
  id: number;
  name: string;
};

interface ProductModalProps {
  isOpen: boolean;
  brands: Brand[];
  onClose: () => void;
  onSubmit: (data: ProductFormData) => void;
}

type LaravelValidationResponse = {
  message?: string;
  errors?: Record<string, string[]>;
};

const initialFormState: ProductFormData = {
  brand_id: "",
  sku: "",
  erp_name: "",
  technical_name: "",
  guarantee_years: "",
  volume_liters: "",
  base_type: "",
  is_fibrated: false,
  requires_separate_primer: false,
  price: "",
  currency: "MXN",
  surface_type: "general",
  consumption_per_m2: "",
  min_coverage_m2: "",
  max_coverage_m2: "",
};

export default function ProductModal({
  isOpen,
  brands,
  onClose,
  onSubmit,
}: ProductModalProps) {
  const [formData, setFormData] =
    useState<ProductFormData>(initialFormState);

  const [loading, setLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);

  if (!isOpen) {
    return null;
  }

  const handleChange = (
    event: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>
  ) => {
    const { name, value, type } = event.target;

    const fieldValue =
      type === "checkbox"
        ? (event.target as HTMLInputElement).checked
        : value;

    setFormData((current) => ({
      ...current,
      [name]: fieldValue,
    }));
  };

  const handleClose = () => {
    if (loading) {
      return;
    }

    setFormData(initialFormState);
    setError(null);
    onClose();
  };

  const handleLoadExample = () => {
  const cemixBrand = brands.find(
    (brand) => brand.name.toLowerCase() === "cemix"
  );

  setFormData({
    brand_id: cemixBrand ? cemixBrand.id : "",
    sku: "CX-EJEMPLO-19L",
    erp_name: "CEMIX PRODUCTO DE EJEMPLO 19 LITROS",
    technical_name: "PRODUCTO IMPERMEABILIZANTE DE EJEMPLO",
    guarantee_years: 5,
    volume_liters: 19,
    base_type: "ACRÍLICA",
    is_fibrated: false,
    requires_separate_primer: false,
    price: 1420,
    currency: "MXN",
    surface_type: "general",
    consumption_per_m2: 1,
    min_coverage_m2: 19,
    max_coverage_m2: 19,
  });

  setError(null);
};

  const handleSubmit = async (event: React.FormEvent<HTMLFormElement>) => {
    event.preventDefault();

    setLoading(true);
    setError(null);

    const payload = {
      ...formData,
      brand_id: Number(formData.brand_id),
      guarantee_years:
        formData.guarantee_years === ""
          ? null
          : Number(formData.guarantee_years),
      volume_liters: Number(formData.volume_liters),
      price: Number(formData.price),
      currency: formData.currency.toUpperCase(),
      consumption_per_m2: Number(formData.consumption_per_m2),
      min_coverage_m2: Number(formData.min_coverage_m2),
      max_coverage_m2: Number(formData.max_coverage_m2),
    };

    try {
      const response = await fetch("/api/v1/admin/products", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify(payload),
      });

      const responseData =
        (await response.json()) as LaravelValidationResponse;

      if (!response.ok) {
        const firstValidationError = responseData.errors
          ? Object.values(responseData.errors).flat()[0]
          : null;

        throw new Error(
          firstValidationError ??
            responseData.message ??
            "No se pudo crear el producto."
        );
      }

      onSubmit(formData);
      setFormData(initialFormState);
      onClose();
    } catch (requestError) {
      setError(
        requestError instanceof Error
          ? requestError.message
          : "Ocurrió un error inesperado al guardar el producto."
      );
    } finally {
      setLoading(false);
    }
  };

  return (
    <div
      className="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4"
      role="dialog"
      aria-modal="true"
      aria-labelledby="new-product-title"
      onMouseDown={(event) => {
        if (event.target === event.currentTarget) {
          handleClose();
        }
      }}
    >
      <div className="max-h-[90vh] w-full max-w-3xl overflow-y-auto rounded-2xl bg-white p-6 shadow-2xl">
      <div className="mb-6">
        <div className="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
          <div>
            <h2
              id="new-product-title"
              className="text-2xl font-bold text-slate-900"
            >
              Nuevo producto
            </h2>

            <p className="mt-1 text-sm text-slate-500">
              Registra los datos tal como aparecen en el ERP, ficha técnica y lista de
              precios.
            </p>
          </div>

          <button
            type="button"
            onClick={handleLoadExample}
            disabled={loading}
            className="shrink-0 rounded-xl border border-blue-200 bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700 transition hover:bg-blue-100 disabled:cursor-not-allowed disabled:opacity-50"
          >
            Cargar ejemplo
          </button>
        </div>
      </div>

      <div className="mt-4 rounded-xl border border-blue-100 bg-blue-50 p-4">
        <p className="text-sm font-semibold text-blue-900">
          Ejemplo de llenado
        </p>

        <p className="mt-1 text-sm text-blue-700">
          SKU: CX-IMPH-ECO-5Y-19L · Volumen: 19 L · Precio: 1420 MXN ·
          Consumo: 1 L/m² · Cobertura: 19 m²
        </p>
      </div>

        {error && (
          <div className="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm font-medium text-red-700">
            {error}
          </div>
        )}

        <form onSubmit={handleSubmit}>
          <div className="grid grid-cols-1 gap-4 md:grid-cols-2">
            <FormField label="Marca">
              <select
                name="brand_id"
                value={formData.brand_id}
                onChange={handleChange}
                required
                className={inputClassName}
              >
                <option value="">Selecciona una marca</option>

                {brands.map((brand) => (
                  <option key={brand.id} value={brand.id}>
                    {brand.name}
                  </option>
                ))}
              </select>
            </FormField>

            <FormField label="SKU">
              <input
                type="text"
                name="sku"
                value={formData.sku}
                onChange={handleChange}
                required
                maxLength={100}
                className={inputClassName}
                placeholder="Ej. CX-IMPH-ECO-5Y-19L"
              />
            </FormField>

            <FormField label="Nombre ERP">
            <input
              type="text"
              name="erp_name"
              value={formData.erp_name}
              onChange={handleChange}
              required
              maxLength={255}
              className={inputClassName}
              placeholder="Ej. CEMIX IMPERCOOL ECOLÓGICO BLANCO 5 AÑOS"
            />
            </FormField>

            <FormField label="Nombre técnico">
            <input
              type="text"
              name="technical_name"
              value={formData.technical_name}
              onChange={handleChange}
              required
              maxLength={255}
              className={inputClassName}
              placeholder="Ej. CEMIX IMPERCOOL ECOLÓGICO 19 LITROS"
            />
            </FormField>

            <FormField label="Años de garantía">
              <input
                type="number"
                name="guarantee_years"
                value={formData.guarantee_years}
                onChange={handleChange}
                min={0}
                max={30}
                className={inputClassName}
                placeholder="0"
              />
            </FormField>

            <FormField label="Volumen en litros">
            <input
              type="number"
              name="volume_liters"
              value={formData.volume_liters}
              onChange={handleChange}
              required
              min={0}
              step="0.01"
              className={inputClassName}
              placeholder="Ej. 19"
            />
            </FormField>

            <FormField label="Tipo de base">
              <input
                type="text"
                name="base_type"
                value={formData.base_type}
                onChange={handleChange}
                required
                maxLength={255}
                className={inputClassName}
                placeholder="Ej. Acrílica, cementosa o asfáltica"
              />
            </FormField>

            <FormField label="Tipo de superficie">
              <select
                name="surface_type"
                value={formData.surface_type}
                onChange={handleChange}
                required
                className={inputClassName}
              >
                <option value="general">General</option>
                <option value="liso">Liso</option>
                <option value="rugoso">Rugoso</option>
              </select>
            </FormField>

            <FormField label="Precio">
            <input
              type="number"
              name="price"
              value={formData.price}
              onChange={handleChange}
              required
              min={0}
              step="0.01"
              className={inputClassName}
              placeholder="Ej. 1420"
            />
            </FormField>

            <FormField label="Moneda">
              <select
                name="currency"
                value={formData.currency}
                onChange={handleChange}
                required
                className={inputClassName}
              >
                <option value="MXN">MXN — Peso mexicano</option>
                <option value="USD">USD — Dólar estadounidense</option>
              </select>
            </FormField>

            <FormField label="Consumo por m²">
              <input
                type="number"
                name="consumption_per_m2"
                value={formData.consumption_per_m2}
                onChange={handleChange}
                required
                min={0}
                step="0.01"
                className={inputClassName}
                placeholder="Ej. 1"
              />
            </FormField>

            <FormField label="Cobertura mínima (m²)">
              <input
                type="number"
                name="min_coverage_m2"
                value={formData.min_coverage_m2}
                onChange={handleChange}
                required
                min={0}
                step="0.01"
                className={inputClassName}
                placeholder="Ej. 19"
              />
            </FormField>

            <FormField label="Cobertura máxima (m²)">
              <input
                type="number"
                name="max_coverage_m2"
                value={formData.max_coverage_m2}
                onChange={handleChange}
                required
                min={0}
                step="0.01"
                className={inputClassName}
                placeholder="Ej. 19"
              />
            </FormField>
          </div>

          <div className="mt-5 grid grid-cols-1 gap-3 md:grid-cols-2">
            <CheckboxField
              name="is_fibrated"
              checked={formData.is_fibrated}
              onChange={handleChange}
              label="Producto fibratado"
              description="Indica si el producto contiene fibras integradas."
            />

            <CheckboxField
              name="requires_separate_primer"
              checked={formData.requires_separate_primer}
              onChange={handleChange}
              label="Requiere primario por separado"
              description="El primario debe adquirirse o aplicarse por separado."
            />
          </div>

          <div className="mt-7 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <button
              type="button"
              onClick={handleClose}
              disabled={loading}
              className="rounded-xl border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100 disabled:cursor-not-allowed disabled:opacity-50"
            >
              Cancelar
            </button>

            <button
              type="submit"
              disabled={loading || brands.length === 0}
              className="rounded-xl bg-blue-700 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-800 disabled:cursor-not-allowed disabled:opacity-50"
            >
              {loading ? "Guardando producto..." : "Guardar producto"}
            </button>
          </div>
        </form>
      </div>
    </div>
  );
}

function FormField({
  label,
  children,
}: {
  label: string;
  children: React.ReactNode;
}) {
  return (
    <label className="block">
      <span className="text-sm font-semibold text-slate-700">{label}</span>
      <div className="mt-1">{children}</div>
    </label>
  );
}

function CheckboxField({
  name,
  checked,
  onChange,
  label,
  description,
}: {
  name: string;
  checked: boolean;
  onChange: (event: React.ChangeEvent<HTMLInputElement>) => void;
  label: string;
  description: string;
}) {
  return (
    <label className="flex cursor-pointer gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4">
      <input
        type="checkbox"
        name={name}
        checked={checked}
        onChange={onChange}
        className="mt-1 h-4 w-4"
      />

      <span>
        <span className="block text-sm font-semibold text-slate-800">
          {label}
        </span>

        <span className="mt-1 block text-xs text-slate-500">
          {description}
        </span>
      </span>
    </label>
  );
}

const inputClassName =
  "w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-700 focus:ring-2 focus:ring-blue-700/20";