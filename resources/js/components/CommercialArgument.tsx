import type {
  SmartMatchAnalysis,
  SmartMatchMatch,
} from "../types/smartMatch";

type CommercialArgumentProps = {
  match: SmartMatchMatch;
  analysis: SmartMatchAnalysis;
};

export default function CommercialArgument({
  match,
  analysis,
}: CommercialArgumentProps) {
  return (
    <section className="mt-5 space-y-5">
      <article className="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <p className="text-sm font-semibold uppercase tracking-wide text-slate-500">
          Matrix Context
        </p>

        <h2 className="mt-2 text-xl font-bold text-slate-900">{match.gama}</h2>

        <p className="mt-1 text-sm text-slate-500">
          {match.technical_segmentation}
        </p>

        <div className="mt-5 rounded-xl bg-slate-50 p-5">
          <p className="leading-relaxed text-slate-700">
            {match.strategic_analysis}
          </p>
        </div>
      </article>

      <article className="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <p className="text-sm font-semibold uppercase tracking-wide text-slate-500">
          Recommended Action
        </p>

        <p className="mt-3 leading-relaxed text-slate-700">
          {analysis.recommended_action}
        </p>
      </article>

      <article className="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <p className="text-sm font-semibold uppercase tracking-wide text-slate-500">
          Pricing Recommendation
        </p>

        <p className="mt-3 leading-relaxed text-slate-700">
          {analysis.pricing_recommendation}
        </p>

        <div className="mt-5 grid grid-cols-1 gap-4 md:grid-cols-2">
          <SmallMetric
            label="Target price"
            value={`$${formatNumber(analysis.target_price)} MXN`}
          />

          <SmallMetric
            label="Required adjustment"
            value={`$${formatNumber(analysis.required_adjustment)} MXN`}
          />
        </div>
      </article>

      <article className="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <p className="text-sm font-semibold uppercase tracking-wide text-slate-500">
          Sales Argument
        </p>

        <p className="mt-3 leading-relaxed text-slate-700">
          {analysis.sales_argument}
        </p>
      </article>
    </section>
  );
}

function SmallMetric({ label, value }: { label: string; value: string }) {
  return (
    <div className="rounded-xl bg-slate-50 p-4">
      <p className="text-xs font-semibold uppercase tracking-wide text-slate-500">
        {label}
      </p>
      <p className="mt-1 text-lg font-bold text-slate-900">{value}</p>
    </div>
  );
}

function formatNumber(value: number) {
  return value.toLocaleString("es-MX", {
    minimumFractionDigits: 0,
    maximumFractionDigits: 2,
  });
}