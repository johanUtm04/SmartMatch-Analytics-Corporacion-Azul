import type { SmartMatchAnalysis } from "../types/smartMatch";

type StrategicAlertProps = {
  analysis: SmartMatchAnalysis;
};

export default function StrategicAlert({ analysis }: StrategicAlertProps) {
  const statusLabel = getCommercialStatusLabel(analysis.commercial_status);
  const riskLabel = getRiskLabel(analysis.risk_level);

  return (
    <section className="mb-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
      <div className="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
        <div>
          <p className="text-sm font-semibold uppercase tracking-wide text-slate-500">
            Strategic Diagnosis
          </p>

          <h2 className="mt-1 text-2xl font-bold text-slate-900">
            {statusLabel}
          </h2>

          <p className="mt-3 max-w-4xl leading-relaxed text-slate-700">
            {analysis.executive_summary}
          </p>
        </div>

        <div className="min-w-[180px] rounded-xl bg-slate-100 px-5 py-4 text-center">
          <p className="text-xs font-semibold uppercase tracking-wide text-slate-500">
            Risk Level
          </p>

          <p className="mt-1 text-xl font-bold text-slate-900">{riskLabel}</p>
        </div>
      </div>

      <div className="mt-5 grid grid-cols-1 gap-4 md:grid-cols-4">
        <Metric
          label="Advantage"
          value={`${formatNumber(analysis.advantage_percentage)}%`}
        />

        <Metric
          label="Gap per m²"
          value={`$${formatNumber(analysis.price_gap_m2)}`}
        />

        <Metric
          label="Total difference"
          value={`$${formatNumber(analysis.difference_total_investment)}`}
        />

        <Metric
          label="Target price"
          value={`$${formatNumber(analysis.target_price)}`}
        />
      </div>
    </section>
  );
}

function Metric({ label, value }: { label: string; value: string }) {
  return (
    <div className="rounded-xl bg-slate-50 p-4">
      <p className="text-sm text-slate-500">{label}</p>
      <p className="mt-1 text-lg font-bold text-slate-900">{value}</p>
    </div>
  );
}

function getCommercialStatusLabel(status: string) {
  if (status === "advantage") {
    return "Cemix has the commercial advantage.";
  }

  if (status === "risk") {
    return "Competitor advantage detected.";
  }

  if (status === "parity") {
    return "The comparison is in commercial parity.";
  }

  return "Insufficient data for strategic diagnosis.";
}

function getRiskLabel(riskLevel: string) {
  const labels: Record<string, string> = {
    low: "Low",
    medium_low: "Medium-Low",
    competitive_watch: "Watch",
    medium: "Medium",
    high: "High",
    neutral: "Neutral",
    undefined: "Undefined",
  };

  return labels[riskLevel] ?? riskLevel;
}

function formatNumber(value: number) {
  return value.toLocaleString("es-MX", {
    minimumFractionDigits: 0,
    maximumFractionDigits: 2,
  });
}