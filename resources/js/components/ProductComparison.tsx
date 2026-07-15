import ProductCard from "./ProductCard";
import type { SmartMatchProduct } from "../types/smartMatch";

type ProductComparisonProps = {
  ownProduct: SmartMatchProduct;
  competitorProduct: SmartMatchProduct;
};

export default function ProductComparison({
  ownProduct,
  competitorProduct,
}: ProductComparisonProps) {
  return (
    <section className="grid grid-cols-1 gap-5 lg:grid-cols-2">
      <ProductCard product={ownProduct} label="Own product" />
      <ProductCard product={competitorProduct} label="Competitor product" />
    </section>
  );
}