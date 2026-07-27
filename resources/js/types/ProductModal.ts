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
}