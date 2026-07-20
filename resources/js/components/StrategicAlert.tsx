// StrategicAlert.tsx
import type { SmartMatchAnalysis } from "../types/smartMatch";

type StrategicAlertProps = {
  analysis: SmartMatchAnalysis;
};

export default function StrategicAlert({ analysis }: StrategicAlertProps) {
  const statusLabel = getCommercialStatusLabel(analysis.commercial_status);
  const riskLabel = getRiskLabel(analysis.risk_level);
  const isHighRisk = analysis.risk_level === "high" || analysis.risk_level === "medium";

  return (
    <section className="mb-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
      <div className="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
        <div>
          <p className="text-sm font-semibold uppercase tracking-wide text-[#C8102E]">
            Diagnóstico Estratégico
          </p>

          <h2 className="mt-1 text-2xl font-bold text-[#1B2A56]">
            {statusLabel}
          </h2>

          <p className="mt-3 max-w-4xl leading-relaxed text-slate-700">
            {analysis.executive_summary}
          </p>
        </div>

        <div
          className={`min-w-[180px] rounded-xl px-5 py-4 text-center ${
            isHighRisk ? "bg-[#C8102E]/10" : "bg-[#EEF1F8]"
          }`}
        >
          <p className="text-xs font-semibold uppercase tracking-wide text-slate-500">
            Nivel de Riesgo
          </p>

          <p
            className={`mt-1 text-xl font-bold ${
              isHighRisk ? "text-[#C8102E]" : "text-[#1B2A56]"
            }`}
          >
            {riskLabel}
          </p>
        </div>
      </div>

      <div className="mt-5 grid grid-cols-1 gap-4 md:grid-cols-4">
        <Metric
          label="Ventaja"
          value={`${formatNumber(analysis.advantage_percentage)}%`}
        />

        <Metric
          label="Diferencia por m²"
          value={`$${formatNumber(analysis.price_gap_m2)}`}
        />

        <Metric
          label="Diferencia total"
          value={`$${formatNumber(analysis.difference_total_investment)}`}
        />

        <Metric
          label="Precio objetivo"
          value={`$${formatNumber(analysis.target_price)}`}
        />
      </div>
    </section>
  );
}

function Metric({ label, value }: { label: string; value: string }) {
  return (
    <div className="rounded-xl bg-[#EEF1F8] p-4">
      <p className="text-sm text-slate-500">{label}</p>
      <p className="mt-1 text-lg font-bold text-[#1B2A56]">{value}</p>
    </div>
  );
}

function getCommercialStatusLabel(status: string) {
  if (status === "advantage") {
    return "Cemix tiene la ventaja comercial.";
  }

  if (status === "risk") {
    return "Se detectó ventaja del competidor.";
  }

  if (status === "parity") {
    return "La comparación está en paridad comercial.";
  }

  return "Datos insuficientes para el diagnóstico estratégico.";
}

function getRiskLabel(riskLevel: string) {
  const labels: Record<string, string> = {
    low: "Bajo",
    medium_low: "Medio-Bajo",
    competitive_watch: "Vigilancia",
    medium: "Medio",
    high: "Alto",
    neutral: "Neutral",
    undefined: "Sin definir",
  };

  return labels[riskLevel] ?? riskLevel;
}

function formatNumber(value: number) {
  return value.toLocaleString("es-MX", {
    minimumFractionDigits: 0,
    maximumFractionDigits: 2,
  });
}