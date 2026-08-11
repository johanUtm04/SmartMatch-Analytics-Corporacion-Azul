import React, { useEffect } from 'react';

interface WelcomeModalProps {
  isOpen: boolean;
  onClose: () => void;
}

export default function WelcomeModal({ isOpen, onClose }: WelcomeModalProps) {
  useEffect(() => {
    const handleKeyDown = (e: KeyboardEvent) => {
      if (e.key === 'Escape') onClose();
    };

    if (isOpen) {
      window.addEventListener('keydown', handleKeyDown);
      document.body.style.overflow = 'hidden';
    }

    return () => {
      window.removeEventListener('keydown', handleKeyDown);
      document.body.style.overflow = 'unset';
    };
  }, [isOpen, onClose]);

  if (!isOpen) return null;

  return (
    <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
      <div 
        className="relative w-full max-w-lg flex flex-col rounded-2xl bg-white shadow-2xl border border-slate-200 overflow-hidden"
        onClick={(e) => e.stopPropagation()}
      >
        {/* Header */}
        <div className="flex items-center justify-between border-b border-slate-100 px-6 py-4 bg-slate-50">
          <div>
            <span className="text-xs font-semibold uppercase tracking-wider text-blue-600 bg-blue-50 px-2.5 py-0.5 rounded-full">
              Propuesta Módulo 3
            </span>
            <h2 className="mt-1 text-lg font-bold text-slate-900">
              Análisis Comparativo y Cuota de Mercado
            </h2>
          </div>
          <button
            onClick={onClose}
            className="rounded-lg p-1.5 text-slate-400 hover:bg-slate-200 hover:text-slate-600 transition-colors"
            aria-label="Cerrar modal"
          >
            <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        {/* Body simplificado */}
        <div className="p-6 space-y-4 text-slate-600 text-sm">
          
          {/* El Problema */}
          <div className="rounded-xl border border-amber-200 bg-amber-50/60 p-3.5">
            <h3 className="font-semibold text-amber-900 text-xs uppercase tracking-wide mb-1">
              El Problema: Evaluación Aislada (Silos)
            </h3>
            <p className="text-amber-800 text-xs leading-relaxed">
              Actualmente sabemos si una marca sube sus ventas, pero no si ese crecimiento le está quitando mercado a otra marca propia (ej. crecimiento de Sika a costa de Cemix).
            </p>
          </div>

          {/* El Objetivo Principal */}
          <div>
            <h3 className="font-semibold text-slate-900 mb-1">
              Objetivo del Módulo
            </h3>
            <p className="text-slate-600 text-xs leading-relaxed">
              Detectar en tiempo real la <strong>canibalización y el desplazamiento de marcas</strong> dentro del portafolio mediante un análisis comparativo por sucursal, categoría, ingresos y volumen.
            </p>
          </div>

          {/* Puntos Clave */}
          <div className="space-y-2 pt-1">
            <div className="flex items-start gap-2.5 text-xs text-slate-700">
              <span className="text-blue-600 font-bold">•</span>
              <span><strong>Métricas cruzadas:</strong> Compara desempeño en monto ($) y unidades vendidas.</span>
            </div>
            <div className="flex items-start gap-2.5 text-xs text-slate-700">
              <span className="text-blue-600 font-bold">•</span>
              <span><strong>Alertas de desplazamiento:</strong> Identifica marcas dominantes vs. marcas en riesgo.</span>
            </div>
          </div>

          {/* Footer de Autoría */}
          <div className="pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400">
            <span>Elaborado por: <strong className="text-slate-600">Johan Jael López Reyes</strong></span>
            <span>Analista de Datos | Marketing</span>
          </div>

        </div>

        {/* Action Button */}
        <div className="border-t border-slate-100 bg-slate-50 px-6 py-3 flex justify-end">
          <button
            onClick={onClose}
            className="w-full sm:w-auto rounded-xl bg-slate-900 px-5 py-2 font-semibold text-white transition hover:bg-slate-700 active:scale-95 text-xs"
          >
            Entendido
          </button>
        </div>
      </div>
    </div>
  );
}