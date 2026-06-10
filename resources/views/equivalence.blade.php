<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartMatch - Panel Comercial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">

    <div class="container bg-white p-4 rounded shadow-sm">
        
        <div class="border-bottom pb-2 mb-4">
            <h1 class="h3 fw-bold text-dark m-0">SmartMatch Analytics</h1>
            <small class="text-muted">Corporacion Azul | Calculo: {{ $calculated_at }}</small>
        </div>

        @foreach($matchups as $years => $segment)
            @if(isset($segment['cemix']) && isset($segment['sika']))
                
                <div class="mb-5">
                    <h5 class="fw-bold text-primary">Garantia: {{ $years }} Anos</h5>
                    
                    <div class="row g-2 mb-2 small text-muted">
                        <div class="col-6"><strong>Cemix:</strong> {{ $segment['cemix']->technical_name }} (${{ number_format($segment['cemix']->bucket_price, 2) }})</div>
                        <div class="col-6"><strong>Sika:</strong> {{ $segment['sika']->technical_name }} (${{ number_format($segment['sika']->bucket_price, 2) }})</div>
                    </div>

                    <table class="table table-bordered align-middle">
                        <thead class="table-light small text-uppercase">
                            <tr>
                                <th>Superficie</th>
                                <th class="text-end">Costo Cemix m²</th>
                                <th class="text-end">Costo Sika m²</th>
                                <th class="text-end">Brecha</th>
                                <th class="text-end">Sobreprecio Sika</th>
                                <th class="text-center">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="small">
                            @foreach(['liso', 'rugoso'] as $surface)
                                @if(isset($segment['analysis'][$surface]))
                                    @php 
                                        $analysis = $segment['analysis'][$surface];
                                        $isVulnerable = $analysis['status'] === 'CRITICAL_VULNERABILITY';
                                    @endphp
                                    <tr>
                                        <td class="fw-bold text-capitalize">{{ $surface }}</td>
                                        <td class="text-end">${{ number_format($analysis['cemix_cost'], 2) }}</td>
                                        <td class="text-end">${{ number_format($analysis['sika_cost'], 2) }}</td>
                                        <td class="text-end fw-bold">${{ number_format($analysis['price_gap'], 2) }}</td>
                                        <td class="text-end fw-bold {{ $isVulnerable ? 'text-danger' : 'text-success' }}">
                                            +{{ number_format($analysis['percentage_gap'], 1) }}%
                                        </td>
                                        <td class="text-center">
                                            @if($isVulnerable)
                                                <span class="badge bg-danger">ATACAR</span>
                                            @else
                                                <span class="badge bg-success">COMPETITIVO</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

            @endif
        @endforeach
    </div>

</body>
</html>