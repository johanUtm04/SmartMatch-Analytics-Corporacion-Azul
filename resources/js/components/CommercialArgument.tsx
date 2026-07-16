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
    <section className="mt-5 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
      <p className="text-sm font-semibold uppercase tracking-wide text-slate-500">
        Argumento Comercial
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

      <div className="mt-5 rounded-xl border border-slate-200 p-5">
        <h3 className="font-bold text-slate-900">Lectura sugerida</h3>

        <p className="mt-2 leading-relaxed text-slate-700">
          {getSuggestedReading(analysis)}
        </p>
      </div>
    </section>
  );
}

function getSuggestedReading(analysis: SmartMatchAnalysis) {
  if (analysis.winner === "own_product") {
    return `Cemix currently has a cost advantage of ${analysis.advantage_percentage}%. Marketing and sales can use this as a strong argument focused on savings, performance, and total project investment.`;
  }

  if (analysis.winner === "competitor_product") {
    return `The competitor currently has a cost advantage of ${analysis.advantage_percentage}%. Cemix should evaluate price adjustment, bundle strategy, technical support, availability, or brand value arguments.`;
  }

  if (analysis.winner === "tie") {
    return "Both products are very close in cost performance. The commercial strategy should focus on availability, trust, technical support, warranty, and brand positioning.";
  }

  return "There is not enough information to produce a complete commercial recommendation. Price, volume, and performance data should be reviewed.";
}