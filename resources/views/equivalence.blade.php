<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartMatch - Panel de Control Comercial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            color: #333333;
        }
        .card-enterprise {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border-radius: 0.5rem;
        }
        .table-enterprise thead {
            background-color: #f8f9fa;
        }
        .badge-sika {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }
        .badge-cemix {
            background-color: #cce5ff;
            color: #004085;
            border: 1px solid #b8daff;
        }
        .border-sika {
            border-left: 4px solid #ffc107 !important;
        }
        .border-cemix {
            border-left: 4px solid #0d6efd !important;
        }
    </style>
</head>
<body class="py-5">

    <div class="container-xl">
        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom bg-white p-4 rounded card-enterprise">
            <div>
                <h1 class="h2 fw-bold text-dark m-0">SmartMatch Analytics</h1>
                <p class="text-muted small m-0 mt-1">
                    Estado del Motor: <span class="text-success fw-semibold">● Activo (V1)</span> | 
                    Último Cálculo: <span class="font-monospace">{{ $calculated_at }}</span>
                </p>
            </div>
            <div>
                <span class="badge bg-secondary px-3 py-2 rounded-pill font-monospace">
                    Corporación Azul
                </span>
            </div>
        </div>

        <div class="card card-enterprise overflow-hidden bg-white">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="m-0 fw-bold text-secondary">Matriz de Rendimiento y Equivalencias Técnicas</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-enterprise align-middle m-0 table-hover">
                    <thead>
                        <tr class="text-secondary small fw-bold text-uppercase border-bottom">
                            <th class="ps-4 py-3">SKU</th>
                            <th class="py-3">Marca</th>
                            <th class="py-3">Nombre Técnico</th>
                            <th class="py-3 text-end">Precio Cubeta</th>
                            <th class="py-3">Condición de Superficie</th>
                            <th class="py-3 text-center">Rendimiento Declarado</th>
                            <th class="py-3 text-end pe-4 text-primary">Costo Real por m²</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        @foreach($products as $product)
                            @foreach($product['surfaces'] as $index => $surface)
                                <tr class="{{ $product['brand'] === 'SIKA' ? 'border-sika' : 'border-cemix' }}">
                                    @if($index === 0)
                                        <td class="ps-4 fw-bold font-monospace text-dark" rowspan="{{ count($product['surfaces']) }}">
                                            {{ $product['sku'] }}
                                        </td>
                                        <td rowspan="{{ count($product['surfaces']) }}">
                                            <span class="badge {{ $product['brand'] === 'SIKA' ? 'badge-sika' : 'badge-cemix' }} fw-bold px-2 py-1">
                                                {{ $product['brand'] }}
                                            </span>
                                        </td>
                                        <td class="fw-semibold text-dark" rowspan="{{ count($product['surfaces']) }}">
                                            {{ $product['name'] }}
                                        </td>
                                        <td class="text-end font-monospace text-secondary" rowspan="{{ count($product['surfaces']) }}">
                                            ${{ number_format($product['bucket_price'], 2) }}
                                        </td>
                                    @endif
                                    
                                    <td class="text-muted">
                                        @if($surface['surface_type'] === 'liso')
                                            Liso
                                        @elseif($surface['surface_type'] === 'rugoso')
                                            Rugoso
                                        @else
                                            General
                                        @endif
                                    </td>
                                    <td class="text-center font-monospace text-muted">
                                        {{ $surface['min_m2'] }}m² - {{ $surface['max_m2'] }}m²
                                    </td>
                                    <td class="text-end font-monospace fw-bold text-dark pe-4 table-active">
                                        ${{ number_format($surface['cost_per_m2']['worst_case'], 2) }} <span class="text-muted small fw-normal">MXN</span>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>