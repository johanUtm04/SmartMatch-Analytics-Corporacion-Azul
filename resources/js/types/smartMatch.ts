export type SmartMatchWinner =
  | "own_product"
  | "competitor_product"
  | "tie"
  | "insufficient_data";

export type SmartMatchProduct = {
  id: number;
  brand: string;
  name: string;
  erp_name: string;
  sku: string;
  bucket_price: number;
  currency: string;
  volume_liters: number;
  consumption_per_m2: number;
  min_coverage_m2: number;
  max_coverage_m2: number;
  cost_m2: number;
  total_investment: number;
};

export type SmartMatchAnalysis = {
  winner: SmartMatchWinner;
  price_gap_m2: number;
  percentage_gap: number;
  advantage_percentage: number;
  difference_total_investment: number;
};

export type SmartMatchMatch = {
  id: number;
  match_type: string;
  gama: string;
  technical_segmentation: string;
  strategic_analysis: string;
  priority: number;
};

export type SmartMatchResponse = {
  status: "success";
  calculated_at: string;
  match: SmartMatchMatch;
  battlefield: {
    area_m2: number;
    own_product: SmartMatchProduct;
    competitor_product: SmartMatchProduct;
    analysis: SmartMatchAnalysis;
  };
};

export type SmartMatchErrorResponse = {
  status: "error";
  message: string;
  examples?: {
    by_match_id?: string;
    by_skus?: string;
  };
};

export type CalculateSmartMatchParams = {
  matchId?: number;
  ownSku?: string;
  competitorSku?: string;
  areaM2?: number;
};