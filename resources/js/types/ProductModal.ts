export interface ProductFormData {
  brand_id: number | '';
  sku: string;
  erp_name: string;
  technical_name: string;
  guarantee_years: number | '';
  volume_liters: number | '';
  base_type: string;
  is_fibrated:boolean;
  requires_separate_primer:boolean;
  price: number | '';
  currency: string;
  surface_type: string;
  consumption_per_m2: number | '';
  min_coverage_m2: number | '';
  max_coverage_m2: number | '';
}