import type {
  CalculateSmartMatchParams,
  SmartMatchErrorResponse,
  SmartMatchResponse,
} from "../types/smartMatch";

export type SmartMatchOption = {
  id: number;
  label: string;
  own_product: string;
  competitor_product: string;
  gama: string;
  match_type: string;
};

export async function calculateSmartMatch(
  params: CalculateSmartMatchParams,
  signal?: AbortSignal
): Promise<SmartMatchResponse> {
  const searchParams = new URLSearchParams();

  if (params.matchId) {
    searchParams.append("match_id", String(params.matchId));
  }

  if (params.ownSku && params.competitorSku) {
    searchParams.append("own_sku", params.ownSku);
    searchParams.append("competitor_sku", params.competitorSku);
  }

  if (params.areaM2) {
    searchParams.append("area_m2", String(params.areaM2));
  }

  const response = await fetch(
    `/api/v1/equivalence/calculate?${searchParams.toString()}`,
    {
      method: "GET",
      headers: {
        Accept: "application/json",
      },
      signal,
    }
  );

  const json = (await response.json()) as
    | SmartMatchResponse
    | SmartMatchErrorResponse;

  if (!response.ok || json.status === "error") {
    throw new Error(
      "message" in json ? json.message : "SmartMatch request failed."
    );
  }

  return json;
}

export async function getSmartMatchMatches(
  signal?: AbortSignal
): Promise<SmartMatchOption[]> {
  const response = await fetch("/api/v1/equivalence/matches", {
    method: "GET",
    headers: {
      Accept: "application/json",
    },
    signal,
  });

  const json = (await response.json()) as
    | { status: "success"; data: SmartMatchOption[] }
    | SmartMatchErrorResponse;

  if (!response.ok || json.status === "error") {
    throw new Error(
      "message" in json ? json.message : "SmartMatch matches request failed."
    );
  }

  return json.data;
}
