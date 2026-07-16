type MatchOption = {
  id: number;
  label: string;
};

type MatchSelectorProps = {
  selectedMatchId: number;
  onChange: (matchId: number) => void;
};

//this are previously defined matchups, but the intention is 
//make a dynamic list of matchups that can be fetched from the backend
const MATCH_OPTIONS: MatchOption[] = [
  {
    id: 31,
    label: "Hogar 18L vs Iron Home 19L",
  },
  {
    id: 32,
    label: "Fibratado 3 años vs Acril Techo 3 PRO",
  },
  {
    id: 33,
    label: "Fibratado 5 años vs Acril Techo 5 Ultra",
  },
  {
    id: 34,
    label: "Ecológico 19L vs Green Power 19L",
  },
  {
    id: 35,
    label: "Fibratado 7 años vs Power 6/8 años",
  },
];

export default function MatchSelector({
  selectedMatchId,
  onChange,
}: MatchSelectorProps) {
  return (
    <section className="mb-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
      <div className="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
          <h2 className="text-lg font-bold text-slate-900">
            Selecciona un matchup de productos
          </h2>
          <p className="text-sm text-slate-500">
            Escoge un matchup de productos para analizar y comparar. Cada matchup representa dos productos equivalentes de diferentes marcas.
          </p>
        </div>

        <select
          value={selectedMatchId}
          onChange={(event) => onChange(Number(event.target.value))}
          className="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 md:w-[420px]"
        >
          {MATCH_OPTIONS.map((match) => (
            <option key={match.id} value={match.id}>
              {match.label}
            </option>
          ))}
        </select>
      </div>
    </section>
  );
}