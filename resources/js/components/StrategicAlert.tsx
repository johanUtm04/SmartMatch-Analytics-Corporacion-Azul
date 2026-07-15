import type { SmartMatchAnalysis } from "../types/smartMatch";

type StrategicAlertProps = {
  analysis: SmartMatchAnalysis;
};

export default function StrategicAlert({ analysis }: StrategicAlertProps) {
  const message = getAlertMessage(analysis.winner);
  const riskLabel = getRiskLabel(analysis.advantage_percentage);

  return (
    <section className="mb-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
      <div className="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
          <p className="text-sm font-semibold uppercase tracking-wide text-slate-500">
            Strategic Diagnosis
          </p>

          <h2 className="mt-1 text-2xl font-bold text-slate-900">
            {message}
          </h2>

          <p className="mt-2 text-slate-600">
            Advantage difference:{" "}
            <span className="font-bold text-slate-900">
              {analysis.advantage_percentage}%
            </span>
          </p>
        </div>

        <div className="rounded-xl bg-slate-100 px-5 py-4 text-center">
          <p className="text-xs font-semibold uppercase tracking-wide text-slate-500">
            Risk Level
          </p>

          <p className="mt-1 text-xl font-bold text-slate-900">{riskLabel}</p>
        </div>
      </div>

      <div className="mt-5 grid grid-cols-1 gap-4 md:grid-cols-3">
        <Metric
          label="Gap per m²"
          value={`$${formatNumber(analysis.price_gap_m2)}`}
        />

        <Metric label="Percentage gap" value={`${analysis.percentage_gap}%`} />

        <Metric
          label="Total difference"
          value={`$${formatNumber(analysis.difference_total_investment)}`}
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

function getAlertMessage(winner: SmartMatchAnalysis["winner"]) {
  if (winner === "own_product") {
    return "Cemix has the commercial advantage.";
  }

  if (winner === "competitor_product") {
    return "Competitor has the commercial advantage.";
  }

  if (winner === "tie") {
    return "Both products are technically tied.";
  }

  return "There is not enough data to calculate a winner.";
}

function getRiskLabel(advantagePercentage: number) {
  if (advantagePercentage >= 30) return "High";
  if (advantagePercentage >= 10) return "Medium";
  if (advantagePercentage > 0) return "Low";
  return "Neutral";
}

function formatNumber(value: number) {
  return value.toLocaleString("es-MX", {
    minimumFractionDigits: 0,
    maximumFractionDigits: 2,
  });
}