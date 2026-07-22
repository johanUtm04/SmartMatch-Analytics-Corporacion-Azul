import type {
  AdminApiErrorResponse,
  AdminApiResponse,
  AdminBrand,
  AdminEquivalenceMatch,
  AdminProduct,
} from "../types/admin";

async function requestAdminData<T>(
  url: string,
  signal?: AbortSignal
): Promise<T> {
  const response = await fetch(url, {
    method: "GET",
    headers: {
      Accept: "application/json",
    },
    signal,
  });

  const json = (await response.json()) as
    | AdminApiResponse<T>
    | AdminApiErrorResponse;

  if (!response.ok || json.status === "error") {
    throw new Error(
      "message" in json ? json.message : "Admin request failed."
    );
  }

  return json.data;
}

export function getAdminBrands(signal?: AbortSignal) {
  return requestAdminData<AdminBrand[]>("/api/v1/admin/brands", signal);
}

export function getAdminProducts(signal?: AbortSignal) {
  return requestAdminData<AdminProduct[]>("/api/v1/admin/products", signal);
}

export function getAdminEquivalenceMatches(signal?: AbortSignal) {
  return requestAdminData<AdminEquivalenceMatch[]>(
    "/api/v1/admin/equivalence-matches",
    signal
  );
}