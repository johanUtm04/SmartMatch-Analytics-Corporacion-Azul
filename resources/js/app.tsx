import React, { useState, useEffect, useMemo } from 'react';
import { createRoot } from 'react-dom/client';

interface ProductBattle {
    name: string;
    sku: string;
    bucket_price: number;
    volume: number;
    consumption: number;
    cost_m2: number;
    image_path?: string; // Propiedad opcional para la ruta de la imagen dinámica
}

interface BattlegroundPayload {
    cemix: ProductBattle;
    sika: ProductBattle;
    analysis: {
        price_gap: number;
        percentage_gap: number;
    };
}

const App = () => {
    const [originalData, setOriginalData] = useState<BattlegroundPayload | null>(null);
    const [loading, setLoading] = useState<boolean>(true);

    // Estados para la simulación interactiva de precios
    const [cemixSimPrice, setCemixSimPrice] = useState<number>(0);
    const [sikaSimPrice, setSikaSimPrice] = useState<number>(0);

    useEffect(() => {
        fetch('/api/v1/equivalence/calculate')
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    setOriginalData(data.battleground);
                    // Inicializar simulador con los precios reales del backend
                    setCemixSimPrice(data.battleground.cemix.bucket_price);
                    setSikaSimPrice(data.battleground.sika.bucket_price);
                }
                setLoading(false);
            })
            .catch(() => setLoading(false));
    }, []);

    // Motor de cálculo en tiempo real
    const simulation = useMemo(() => {
        if (!originalData) return null;

        const { cemix, sika } = originalData;

        const cemix_m2 = (cemixSimPrice / cemix.volume) * cemix.consumption;
        const sika_m2 = (sikaSimPrice / sika.volume) * sika.consumption;

        const gap_m2 = sika_m2 - cemix_m2;
        const gap_percentage = (cemix_m2 > 0) ? (gap_m2 / cemix_m2) * 100 : 0;

        return {
            cemix_m2: roundTo(cemix_m2, 2),
            sika_m2: roundTo(sika_m2, 2),
            gap_m2: roundTo(gap_m2, 2),
            gap_percentage: roundTo(gap_percentage, 1)
        };
    }, [originalData, cemixSimPrice, sikaSimPrice]);

    function roundTo(num: number, decimals: number) {
        return Number(num.toFixed(decimals));
    }

    if (loading || !originalData || !simulation) {
        return (
            <div className="container p-5 text-center" style={{ marginTop: '15%' }}>
                <div className="spinner-border text-primary" role="status"></div>
                <p className="text-muted mt-3 fw-bold">Cargando zona de combate SmartMatch...</p>
            </div>
        );
    }

    const isCemixWinner = simulation.gap_m2 > 0;

    return (
        <div className="container-fluid px-4 py-4" style={{ backgroundColor: '#f4f6f9', minHeight: '100vh' }}>
            
            {/* Encabezado Principal */}
            <div className="d-flex justify-content-between align-items-center bg-white p-3 rounded shadow-sm border-start border-primary border-4 mb-4">
                <div>
                    <h1 className="h4 fw-extrabold text-dark m-0">SmartMatch: Cara a Cara de Volumen Masivo</h1>
                    <small className="text-muted">Analisis Tactico de Desplazamiento en Mercado | Categoria Impermeabilizantes Hogar</small>
                </div>
                <div className="text-end">
                    <span className="badge bg-dark px-3 py-2">MODO ENFRENTAMIENTO DIRECTO</span>
                </div>
            </div>

            <div className="row g-4">
                
                {/* Panel de Controles de Simulacion */}
                <div className="col-12 col-lg-4">
                    <div className="card border-0 shadow-sm bg-dark text-white h-100">
                        <div className="card-body p-4 d-flex flex-column justify-content-between">
                            <div>
                                <h5 className="fw-bold text-warning mb-2">Simulador de Ataque Comercial</h5>
                                <p className="text-muted small mb-4">
                                    Modifica los precios de las cubetas para simular agresiones de la competencia o descuentos de volumen de Cemix.
                                </p>

                                {/* Slider Cemix */}
                                <div className="mb-4">
                                    <div className="d-flex justify-content-between small mb-1">
                                        <span className="text-info fw-bold">Precio Cubeta CEMIX</span>
                                        <span className="fw-bold text-white fs-5">${cemixSimPrice} MXN</span>
                                    </div>
                                    <input 
                                        type="range" 
                                        className="form-range" 
                                        min="400" 
                                        max="2000" 
                                        step="10" 
                                        value={cemixSimPrice}
                                        onChange={(e) => setCemixSimPrice(Number(e.target.value))}
                                    />
                                    <div className="d-flex justify-content-between text-muted" style={{ fontSize: '11px' }}>
                                        <span>Min: $400</span>
                                        <span>Base: ${originalData.cemix.bucket_price}</span>
                                        <span>Max: $2000</span>
                                    </div>
                                </div>

                                {/* Slider Sika */}
                                <div className="mb-4">
                                    <div className="d-flex justify-content-between small mb-1">
                                        <span className="text-warning fw-bold">Precio Cubeta SIKA</span>
                                        <span className="fw-bold text-white fs-5">${sikaSimPrice} MXN</span>
                                    </div>
                                    <input 
                                        type="range" 
                                        className="form-range" 
                                        min="400" 
                                        max="2000" 
                                        step="10" 
                                        value={sikaSimPrice}
                                        onChange={(e) => setSikaSimPrice(Number(e.target.value))}
                                    />
                                    <div className="d-flex justify-content-between text-muted" style={{ fontSize: '11px' }}>
                                        <span>Min: $400</span>
                                        <span>Base: ${originalData.sika.bucket_price}</span>
                                        <span>Max: $2000</span>
                                    </div>
                                </div>
                            </div>

                            <button 
                                className="btn btn-outline-light btn-sm w-100 mt-3"
                                onClick={() => {
                                    setCemixSimPrice(originalData.cemix.bucket_price);
                                    setSikaSimPrice(originalData.sika.bucket_price);
                                }}
                            >
                                Resetear a Precios Reales de ERP
                            </button>
                        </div>
                    </div>
                </div>

                {/* Panel de Metricas de Duelo */}
                <div className="col-12 col-lg-8">
                    <div className="row g-3">
                        
                        {/* Status de Margen */}
                        <div className="col-12">
                            <div className={`card border-0 shadow-sm text-white ${isCemixWinner ? 'bg-success' : 'bg-danger'}`}>
                                <div className="card-body p-4 text-center">
                                    <h6 className="text-uppercase small fw-bold mb-1">DIAGNOSTICO ESTRATEGICO ACTUAL</h6>
                                    <h2 className="fw-extrabold m-0">
                                        {isCemixWinner 
                                            ? `CEMIX ES ${simulation.gap_percentage.toFixed(1)}% MAS RENTABLE EN RENDIMIENTO`
                                            : `ALERTA: SIKA TIENE VENTANA DE VENTAJA (${Math.abs(simulation.gap_percentage).toFixed(1)}%)`
                                        }
                                    </h2>
                                    <p className="small m-0 mt-1 opacity-75">
                                        {isCemixWinner 
                                            ? 'Posicion de ataque optima para el equipo comercial.' 
                                            : 'Riesgo de perdida de mercado. Ajusta el precio de Cemix para recuperar paridad.'
                                        }
                                    </p>
                                </div>
                            </div>
                        </div>

                        {/* Tarjeta Cemix */}
                        <div className="col-md-6">
                            <div className="card border-0 shadow-sm h-100 bg-white border-top border-info border-4">
                                <div className="card-body p-4 text-center">
                                    <span className="badge bg-info bg-opacity-10 text-info px-3 py-1 rounded-pill fw-bold small mb-3">Nuestra Alternativa</span>
                                    
                                    {/* Espacio reservado para la imagen de Cemix */}
                                    <div className="mb-3 bg-light rounded d-block mx-auto text-center p-2" style={{ height: '160px', width: '100%', maxWidth: '200px' }}>
                                        <img 
                                            src={originalData.cemix.image_path || "/images/products/cemix-hogar.jpg"} 
                                            alt={originalData.cemix.name}
                                            className="img-fluid h-100"
                                            style={{ objectFit: 'contain' }}
                                        />
                                    </div>

                                    <h5 className="fw-bold text-dark mb-1">{originalData.cemix.name}</h5>
                                    <p className="text-muted mb-3" style={{ fontSize: '11px' }}>SKU: {originalData.cemix.sku} | Cubeta {originalData.cemix.volume}L</p>
                                    
                                    <div className="bg-light p-3 rounded">
                                        <div className="text-muted small">Costo por m2</div>
                                        <div className="display-6 fw-bold text-info">${simulation.cemix_m2}</div>
                                        <div className="text-secondary mt-1" style={{ fontSize: '11px' }}>Rendimiento: {originalData.cemix.consumption} L/m2</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {/* Tarjeta Sika */}
                        <div className="col-md-6">
                            <div className="card border-0 shadow-sm h-100 bg-white border-top border-warning border-4">
                                <div className="card-body p-4 text-center">
                                    <span className="badge bg-warning bg-opacity-10 text-warning px-3 py-1 rounded-pill fw-bold small mb-3">Competencia Directa</span>
                                    
                                    {/* Espacio reservado para la imagen de Sika */}
                                    <div className="mb-3 bg-light rounded d-block mx-auto text-center p-2" style={{ height: '160px', width: '100%', maxWidth: '200px' }}>
                                        <img 
                                            src={originalData.sika.image_path || "/images/products/sika-home.jpg"} 
                                            alt={originalData.sika.name}
                                            className="img-fluid h-100"
                                            style={{ objectFit: 'contain' }}
                                        />
                                    </div>

                                    <h5 className="fw-bold text-dark mb-1">{originalData.sika.name}</h5>
                                    <p className="text-muted mb-3" style={{ fontSize: '11px' }}>SKU: {originalData.sika.sku} | Cubeta {originalData.sika.volume}L</p>

                                    <div className="bg-light p-3 rounded">
                                        <div className="text-muted small">Costo por m2</div>
                                        <div className="display-6 fw-bold text-warning">${simulation.sika_m2}</div>
                                        <div className="text-secondary mt-1" style={{ fontSize: '11px' }}>Rendimiento: {originalData.sika.consumption} L/m2</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {/* Proyeccion en Obra */}
                        <div className="col-12">
                            <div className="card border-0 shadow-sm bg-white">
                                <div className="card-body p-4">
                                    <h6 className="fw-bold text-secondary mb-3">Argumento de Cierre Comercial (Muestra Tipo Obra: 500 m2)</h6>
                                    <div className="row text-center align-items-center">
                                        <div className="col-md-4 mb-3 mb-md-0">
                                            <div className="small text-muted">Inversion Cemix</div>
                                            <h4 className="fw-bold text-dark">${(simulation.cemix_m2 * 500).toFixed(2)}</h4>
                                        </div>
                                        <div className="col-md-4 mb-3 mb-md-0 border-start border-end">
                                            <div className="small text-muted">Inversion Sika</div>
                                            <h4 className="fw-bold text-dark">${(simulation.sika_m2 * 500).toFixed(2)}</h4>
                                        </div>
                                        <div className="col-md-4">
                                            <div className="small text-muted">Ahorro Neto Cliente</div>
                                            <h4 className={`fw-extrabold ${simulation.gap_m2 > 0 ? 'text-success' : 'text-danger'}`}>
                                                {simulation.gap_m2 > 0 
                                                    ? `$${(simulation.gap_m2 * 500).toFixed(2)} MXN`
                                                    : `-$${Math.abs(simulation.gap_m2 * 500).toFixed(2)} MXN`
                                                }
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    );
};

const container = document.getElementById('root');
if (container) {
    const root = createRoot(container);
    root.render(<App />);
}