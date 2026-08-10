import type {
  CalculateSmartMatchParams,
  SmartMatchErrorResponse,
  SmartMatchResponse,
} from "../types/smartMatch";

//Define the what one Smartmatch comparasion option looks like
export type SmartMatchOption = {
  id: number;
  label: string;
  own_product: string;
  competitor_product: string;
  gama: string;
  match_type: string;
};
// example
// example
// {
//   id: 5,
//   label: "Cruz Azul vs Competitor",
//   own_product: "Cemento Cruz Azul",
//   competitor_product: "Product B",
//   gama: "Cemento",
//   match_type: "equivalence"
// }

// means the function performs asynchronous work and returns a Promise
export async function calculateSmartMatch(
  // the variable that receives the input parameters
  params: CalculateSmartMatchParams,
  //conceptually is something like this:
  // params = {
  //   matchId,
  //   ownSku,
  //   competitorSku,
  //   areaM2
  //variables used to control/cancel the HTTP request
  signal?: AbortSignal

  //Promise: means the result will arrive asynchronously
    //the function eventually returns a SmartMatchResponse
): Promise<SmartMatchResponse> {
  //Is used for creating URL query parameters
    //somthing like that ?match_id=5&area_m2=500
  const searchParams = new URLSearchParams();

  //Conditions to check if the parameters are provided
  if (params.matchId) {
    searchParams.append("match_id", String(params.matchId));
  }
  //params.matchId = 7

  if (params.ownSku && params.competitorSku) {
    searchParams.append("own_sku", params.ownSku);
    searchParams.append("competitor_sku", params.competitorSku);
  }

  if (params.areaM2) {
    searchParams.append("area_m2", String(params.areaM2));
  }
  //params.areaM2 = 500


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
