export type AdminBrand = {
  id: number;
  name: string;
};

export type AdminProduct = {
  id: number;
  brand_id: number;
  brand: string;
  sku: string;
  erp_name: string;
  technical_name: string;
  guarantee_years: number;
  volume_liters: number;
  base_type: string | null;
  is_fibrated: boolean;
  requires_separate_primer: boolean;
  price: number;
  currency: string;
  surface_type: string;
  consumption_per_m2: number;
  min_coverage_m2: number;
  max_coverage_m2: number;
};

export type AdminEquivalenceMatch = {
  id: number;
  own_product_id: number;
  competitor_product_id: number;
  match_type: string;
  gama: string;
  technical_segmentation: string;
  strategic_analysis: string;
  priority: number;
  is_active: boolean;
  own_sku: string;
  own_product: string;
  competitor_sku: string;
  competitor_product: string;
};

export type AdminApiResponse<T> = {
  status: "success";
  data: T;
};

export type AdminApiErrorResponse = {
  status: "error";
  message: string;
  debug?: string;
};