
@extends('home', ['activePage' => 'Puestos', 'menuParent' => 'laravel', 'titlePage' => __('Puestos')])

@section('contentJunzi')
<style>
/* Estilos para el modal */
#editAuditoriaModal {
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
}

#editAuditoriaModal .bg-white {
    transition: all 0.3s ease-out;
}

/* Estilos para selects */
select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 1rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 3rem;
}

select:disabled {
    background-color: #f9fafb;
    color: #6b7280;
    cursor: not-allowed;
    opacity: 0.6;
}

/* Estados de focus */
input:focus,
select:focus {
    outline: none;
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    transform: translateY(-1px);
}

/* Efectos para botones */
button {
    transition: all 0.2s ease-in-out;
}

button:hover:not(:disabled) {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

button:active:not(:disabled) {
    transform: translateY(0);
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

button:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}


/* Estilos específicos para el campo criticidad */
#criticidad {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 1rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 3rem;
}

/* Opciones del select criticidad con colores */
#criticidad option[value="baja"] {
    background-color: #f0fdf4;
    color: #15803d;
}

#criticidad option[value="media"] {
    background-color: #fefce8;
    color: #a16207;
}

#criticidad option[value="alta"] {
    background-color: #fef2f2;
    color: #dc2626;
}

/* Indicador visual para el campo criticidad cuando está seleccionado */
#criticidad[data-selected="baja"] {
    border-color: #22c55e;
    box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1);
}

#criticidad[data-selected="media"] {
    border-color: #eab308;
    box-shadow: 0 0 0 3px rgba(234, 179, 8, 0.1);
}

#criticidad[data-selected="alta"] {
    border-color: #ef4444;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
}

/* Animación para transición de colores */
#criticidad {
    transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

/* Badge de criticidad para mostrar en la tabla (opcional) */
.criticidad-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.criticidad-baja {
    background-color: #dcfce7;
    color: #166534;
    border: 1px solid #bbf7d0;
}

.criticidad-media {
    background-color: #fef3c7;
    color: #92400e;
    border: 1px solid #fde68a;
}

.criticidad-alta {
    background-color: #fee2e2;
    color: #991b1b;
    border: 1px solid #fecaca;
}

/* Tooltip para explicar los niveles de criticidad */
.criticidad-tooltip {
    position: relative;
    display: inline-block;
}

.criticidad-tooltip .tooltip-content {
    visibility: hidden;
    width: 280px;
    background-color: #374151;
    color: #fff;
    text-align: left;
    border-radius: 8px;
    padding: 12px;
    position: absolute;
    z-index: 1000;
    bottom: 125%;
    left: 50%;
    margin-left: -140px;
    opacity: 0;
    transition: opacity 0.3s;
    font-size: 0.875rem;
    line-height: 1.4;
}

.criticidad-tooltip .tooltip-content::after {
    content: "";
    position: absolute;
    top: 100%;
    left: 50%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: #374151 transparent transparent transparent;
}

.criticidad-tooltip:hover .tooltip-content {
    visibility: visible;
    opacity: 1;
}

/* Animaciones */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }

    to {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes fadeOut {
    from {
        opacity: 1;
        transform: scale(1);
    }

    to {
        opacity: 0;
        transform: scale(0.95);
    }
}

/* Responsive */
@media (max-width: 640px) {
    #editAuditoriaModal .max-w-md {
        max-width: 95%;
        margin: 1rem;
    }
}

/* Animaciones personalizadas */
@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInScale {
    from {
        opacity: 0;
        transform: scale(0.95);
    }

    to {
        opacity: 1;
        transform: scale(1);
    }
}

/* Aplicar animaciones */
.animate-slide-up {
    animation: slideInUp 0.6s ease-out;
}

.animate-fade-scale {
    animation: fadeInScale 0.4s ease-out;
}

/* Estilos mejorados para selects */
select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 1rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 3rem;
}

select:disabled {
    background-color: #f9fafb;
    color: #6b7280;
    cursor: not-allowed;
    opacity: 0.6;
}

/* Tooltips mejorados */
.group:hover .group-hover\:visible {
    visibility: visible;
    opacity: 1;
    transform: translateY(-5px);
    transition: all 0.3s ease-in-out;
}

/* Estados de loading */
.loading {
    position: relative;
    overflow: hidden;
}

.loading::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.8), transparent);
    animation: loading-shimmer 1.5s infinite;
}

@keyframes loading-shimmer {
    0% {
        left: -100%;
    }

    100% {
        left: 100%;
    }
}

/* Mejoras responsivas */
@media (max-width: 768px) {
    .table-container {
        font-size: 0.75rem;
    }

    .px-6 {
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .py-4 {
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
    }
}

/* Estados de focus mejorados */
input:focus,
select:focus,
textarea:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    transform: translateY(-1px);
}

/* Botones con efectos */
button {
    transition: all 0.2s ease-in-out;
}

button:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

button:active:not(:disabled) {
    transform: translateY(0);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

/* Indicadores de estado */
.status-indicator {
    position: relative;
}

.status-indicator::before {
    content: '';
    position: absolute;
    top: 50%;
    left: -8px;
    width: 4px;
    height: 4px;
    border-radius: 50%;
    transform: translateY(-50%);
}

.status-cerrado::before {
    background-color: #10b981;
}

.status-pendiente::before {
    background-color: #f59e0b;
}

/* Scrollbar personalizado */
.overflow-y-auto::-webkit-scrollbar {
    width: 6px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

#createHallazgoModal {
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    transition: opacity 0.3s ease-out;
}

#createHallazgoModal .bg-white {
    transition: all 0.3s ease-out;
    transform: scale(0.95);
    opacity: 0;
}

#createHallazgoModal.active .bg-white {
    transform: scale(1);
    opacity: 1;
}

/* Estilos para selects mejorados */
select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 1rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 3rem;
}

select:disabled {
    background-color: #f9fafb;
    color: #6b7280;
    cursor: not-allowed;
    opacity: 0.6;
}

/* Estados de focus mejorados */
input:focus,
select:focus,
textarea:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    transform: translateY(-1px);
}

/* Efectos para botones */
button {
    transition: all 0.2s ease-in-out;
}

button:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

button:active:not(:disabled) {
    transform: translateY(0);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

button:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.table-row.cursor-pointer:hover {
    background-color: #f8fafc !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.table-row.cursor-pointer:active {
    transform: translateY(0);
}

/* Animaciones personalizadas */
@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInScale {
    from {
        opacity: 0;
        transform: scale(0.95);
    }

    to {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes shimmer {
    0% {
        background-position: -468px 0;
    }

    100% {
        background-position: 468px 0;
    }
}

/* Aplicar animaciones */
.animate-slide-up {
    animation: slideInUp 0.6s ease-out;
}

.animate-fade-scale {
    animation: fadeInScale 0.4s ease-out;
}

/* Estados de loading */
.loading {
    position: relative;
    overflow: hidden;
}

.loading::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.8), transparent);
    animation: shimmer 1.5s infinite;
}

/* Estilos para el archivo input */
.file-input {
    position: relative;
    overflow: hidden;
}

.file-input input[type="file"] {
    position: absolute;
    left: -9999px;
    opacity: 0;
}

.file-input-label {
    display: inline-block;
    cursor: pointer;
    background: #3b82f6;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    transition: all 0.2s ease-in-out;
}

.file-input-label:hover {
    background: #2563eb;
    transform: translateY(-1px);
}

/* Indicadores de estado */
.status-indicator {
    position: relative;
}

.status-indicator::before {
    content: '';
    position: absolute;
    top: 50%;
    left: -8px;
    width: 4px;
    height: 4px;
    border-radius: 50%;
    transform: translateY(-50%);
}

.status-success::before {
    background-color: #10b981;
}

.status-error::before {
    background-color: #ef4444;
}

.status-warning::before {
    background-color: #f59e0b;
}

/* Tooltips mejorados */
.tooltip {
    position: absolute;
    z-index: 1000;
    padding: 0.5rem 0.75rem;
    background: #374151;
    color: white;
    border-radius: 0.375rem;
    font-size: 0.75rem;
    white-space: nowrap;
    opacity: 0;
    transform: translateY(-5px);
    transition: all 0.2s ease-in-out;
    pointer-events: none;
}

.tooltip.show {
    opacity: 1;
    transform: translateY(0);
}

/* Responsive */
@media (max-width: 768px) {
    #createHallazgoModal .max-w-4xl {
        max-width: 95%;
        margin: 1rem;
    }

    .grid-cols-1.md\\:grid-cols-2 {
        grid-template-columns: 1fr;
    }
}

.table-container {
    position: relative;
    border-radius: 0.5rem;
    overflow: hidden;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

.table-scroll-wrapper {
    position: relative;
    overflow: hidden;
}

.table-scroll-content {
    overflow-x: auto;
    scrollbar-width: thin;
    scrollbar-color: #cbd5e1 #f1f5f9;
    scroll-behavior: smooth;
}

.table-scroll-content::-webkit-scrollbar {
    height: 8px;
}

.table-scroll-content::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
}

.table-scroll-content::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

.table-scroll-content::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Botones de scroll */
.scroll-btn {
    position: absolute;
    top: 60px; /* Posicionado cerca del inicio de la tabla */
    z-index: 10;
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: rgba(59, 130, 246, 0.9);
    color: white;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    backdrop-filter: blur(4px);
}

.scroll-btn:hover {
    background: rgba(37, 99, 235, 0.9);
    transform: scale(1.1);
    box-shadow: 0 8px 15px -3px rgba(0, 0, 0, 0.2);
}

.scroll-btn:active {
    transform: scale(0.95);
}

.scroll-btn.hidden {
    opacity: 0;
    pointer-events: none;
}

.scroll-btn-left {
    left: 12px;
}

.scroll-btn-right {
    right: 12px;
}

/* Indicadores de scroll */
.scroll-indicator {
    position: absolute;
    top: 0;
    bottom: 0;
    width: 24px;
    pointer-events: none;
    z-index: 5;
    transition: opacity 0.3s ease;
}

.scroll-indicator-left {
    left: 0;
    background: linear-gradient(to right, rgba(0, 0, 0, 0.1), transparent);
}

.scroll-indicator-right {
    right: 0;
    background: linear-gradient(to left, rgba(0, 0, 0, 0.1), transparent);
}

.scroll-indicator.hidden {
    opacity: 0;
}

/* Paginación personalizada */
.pagination-container {
    background: white;
    border-top: 1px solid #e5e7eb;
    padding: 1rem 1.5rem;
    display: flex;
    items-center: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
}

.pagination-info {
    color: #6b7280;
    font-size: 0.875rem;
}

.pagination-controls {
    display: flex;
    items-center;
    gap: 0.5rem;
}

.pagination-btn {
    min-width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #d1d5db;
    background: white;
    color: #374151;
    text-decoration: none;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.2s ease;
}

.pagination-btn:hover:not(.disabled) {
    background: #f3f4f6;
    border-color: #9ca3af;
    transform: translateY(-1px);
}

.pagination-btn.active {
    background: #3b82f6;
    border-color: #3b82f6;
    color: white;
}

.pagination-btn.disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.pagination-select {
    padding: 0.5rem;
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    background: white;
    font-size: 0.875rem;
    min-width: 80px;
}

/* Responsive */
@media (max-width: 768px) {
    .pagination-container {
        flex-direction: column;
        text-align: center;
    }
    
    .scroll-btn {
        width: 40px;
        height: 40px;
        top: 40px; /* Ajuste para móviles */
    }
    
    .table-scroll-content {
        font-size: 0.75rem;
    }
    
    .pagination-controls {
        flex-wrap: wrap;
        justify-content: center;
    }
}

/* Animaciones */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.table-container {
    animation: fadeIn 0.6s ease-out;
}

/* Estados de hover para filas */
.table-row {
    transition: all 0.2s ease;
}

.table-row:hover {
    background-color: #f8fafc;
    transform: translateX(2px);
}

/* Estilos adicionales para tooltips y otros elementos existentes */
.group:hover .group-hover\:visible {
    visibility: visible;
    opacity: 1;
    transform: translateY(-5px);
    transition: all 0.3s ease-in-out;
}

/* Scrollbar personalizado */
.overflow-y-auto::-webkit-scrollbar {
    width: 6px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Mejoras para campos requeridos */
.required-field {
    border-color: #ef4444 !important;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
}

.required-label::after {
    content: " *";
    color: #ef4444;
    font-weight: bold;
}

/* Animación de pulsación para botones */
.pulse-animation {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

@keyframes pulse {

    0%,
    100% {
        opacity: 1;
    }

    50% {
        opacity: .5;
    }
}

/* Estilos para validaciones */
.validation-message {
    display: none;
    color: #ef4444;
    font-size: 0.75rem;
    margin-top: 0.25rem;
}

.validation-message.show {
    display: block;
}

/* Estilos para multi-select */
select[multiple] {
    height: auto;
    min-height: 100px;
}

select[multiple] option {
    padding: 0.5rem;
    margin: 0.125rem;
}

select[multiple] option:checked {
    background-color: #3b82f6;
    color: white;
}
</style>

<div class="bg-gray-50 min-h-screen py-8 mt-5">
    <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 py-4">
        <!-- Alert de éxito -->
        @if (session('success'))
        <div id="success-alert"
            class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-r-lg shadow-md transition-all duration-500">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Header principal -->
        <div class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 px-6 py-6 rounded-t-lg">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h1 class="text-3xl font-bold text-white">Hallazgos de la Auditoría</h1>
                        <p class="text-white text-lg mt-1">
                            {{ ($auditoria->tipo ?? '') . '-' . ($auditoria->area ?? '') . '-' . ($auditoria->anio ?? '') . '-' . ($auditoria->folio ?? '') }}
                        </p>
                    </div>
                </div>

                <!-- Botón Editar Auditoría-->
                @if(auth()->user()->auditoria == '1')
                <div class="mb-6 py-4 flex justify-end">
                    <div class="flex items-center space-x-4"> 
                        <button onclick="openEditModal()"
                            class="inline-flex items-center px-4 py-2 bg-green-500 border border-green-400 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-400 active:bg-green-600 focus:outline-none focus:border-green-400 focus:ring ring-green-200 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                            Editar Auditoría
                        </button>
                        <!-- Botón Crear Hallazgo -->
                        <button onclick="openCreateModal()"
                            class="inline-flex items-center px-4 py-2 bg-blue-500 border border-blue-400 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-400 active:bg-blue-600 focus:outline-none focus:border-blue-400 focus:ring ring-blue-200 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Crear Hallazgo
                        </button>
                        <!-- Botón Crear Eliminar -->
                        <button onclick="openDeleteModal()"
                            class="inline-flex items-center px-4 py-2 bg-red-500 border border-red-400 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-400 active:bg-red-600 focus:outline-none focus:border-red-400 focus:ring ring-red-200 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                            Eliminar Auditoría
                        </button>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Tabla de hallazgos -->
        <div class="table-container bg-white shadow-xl mb-8">
            <div class="table-scroll-wrapper">
                <!-- Botones de scroll -->
                <button id="scrollLeft" class="scroll-btn scroll-btn-left hidden" onclick="scrollTable('left')">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                
                <button id="scrollRight" class="scroll-btn scroll-btn-right" onclick="scrollTable('right')">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

                <!-- Indicadores de scroll -->
                <div id="scrollIndicatorLeft" class="scroll-indicator scroll-indicator-left hidden"></div>
                <div id="scrollIndicatorRight" class="scroll-indicator scroll-indicator-right"></div>

                <!-- Contenido de la tabla -->
                <div id="tableScrollContent" class="table-scroll-content" onscroll="updateScrollButtons()">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-800">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider min-w-32">Días Tolerancia</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider min-w-24">Estatus</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider min-w-48">Respuesta</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider min-w-32">Área</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider min-w-32">Sub área</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider min-w-48">Hallazgo</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider min-w-24">Tipo</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider min-w-32">F. Presentación</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider min-w-32">F. Compromiso</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider min-w-32">F. Identificación</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider min-w-48">Comentarios</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider min-w-48">Auditados</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider min-w-32">Jefe Auditado</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider min-w-24">F. Cierre</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider min-w-32">Opciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                $currentPage = request()->get('page', 1);
                                $perPage = request()->get('per_page', 10);
                                $paginatedHallazgos = $hallazgos->forPage($currentPage, $perPage);
                            @endphp
                            
                            @foreach($paginatedHallazgos as $hallazgo)
                            @php
                            $responsableIds = explode(',', $hallazgo->responsable);
                            $auditados = array_map(function ($id) {
                                return qcolab($id);
                            }, $responsableIds);
                            $nombresAuditados = implode(', ', $auditados);
                            $jefeAuditadoId = $hallazgo->jefe;
                            $fechaCompromiso = \Carbon\Carbon::parse($hallazgo->fecha_compromiso);
                            $fechaCierre = \Carbon\Carbon::parse($hallazgo->fecha_cierre);
                            $fechaActual = \Carbon\Carbon::now();
                            $diasSinCerrar = null;
                            $diasCerrado = null;

                            if (!$hallazgo->fecha_cierre) {
                                $diasSinCerrar = $fechaActual->diffInDays($fechaCompromiso, false);
                            } else {
                                $diasCerrado = $fechaCierre->diffInDays($fechaCompromiso, false);
                            }

                            $isUserResponsible = auth()->user()->auditoria != "1" && in_array(auth()->user()->colaborador_id, $responsableIds);
                            $canEdit = $hallazgo->estatus != 'Cerrado' || auth()->user()->auditoria == '1';
                            @endphp

                            <tr class="table-row {{ $isUserResponsible ? 'border-l-4 border-blue-500 bg-blue-50' : 'hover:bg-gray-50' }} transition-all duration-200 {{ $canEdit ? 'cursor-pointer' : '' }}" 
                                    @if($canEdit) onclick="window.location.href='/hallazgo/{{ $hallazgo->id }}/edit'" @endif>                                
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold">
                                    @if(is_null($diasSinCerrar))
                                    <span class="text-gray-600">{{ $diasCerrado }}</span>
                                    @else
                                    <span class="px-2 py-1 rounded-full text-xs {{ $diasSinCerrar >= 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $diasSinCerrar }}
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $hallazgo->estatus == 'Cerrado' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $hallazgo->estatus }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700 max-w-xs overflow-hidden text-ellipsis">
                                    {{ $hallazgo->respuesta ?? '' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $hallazgo->titysubtit->area ?? '' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $hallazgo->titysubtit->titulo ?? '' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700 max-w-xs overflow-hidden text-ellipsis relative group">
                                    <span class="cursor-help">
                                        @php
                                            $subtitulo = $hallazgo->titysubtit->subtitulo ?? '';
                                            $palabras = explode(' ', $subtitulo);
                                            $subtitulo_corto = count($palabras) > 3 
                                                ? implode(' ', array_slice($palabras, 0, 3)) . '...' 
                                                : $subtitulo;
                                        @endphp
                                        {{ $subtitulo_corto }}
                                    </span>
                                    <div class="absolute z-20 invisible group-hover:visible bg-gray-900 text-white text-xs rounded-lg py-2 px-3 bottom-full left-0 mb-2 w-80 shadow-lg">
                                        {{ $hallazgo->titysubtit->subtitulo ?? '' }}
                                        <div class="absolute top-full left-4 w-0 h-0 border-l-4 border-r-4 border-t-4 border-transparent border-t-gray-900"></div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800">
                                        {{ $hallazgo->tipo }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ \Carbon\Carbon::parse($hallazgo->fecha_presentacion)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ \Carbon\Carbon::parse($hallazgo->fecha_compromiso)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ \Carbon\Carbon::parse($hallazgo->fecha_identificacion)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700 max-w-xs overflow-hidden text-ellipsis relative group">                                     
                                    <span class="cursor-help">
                                        @php
                                            $palabras = explode(' ', $hallazgo->comentarios);
                                            $texto_corto = count($palabras) > 3 
                                                ? implode(' ', array_slice($palabras, 0, 3)) . '...' 
                                                : $hallazgo->comentarios;
                                        @endphp
                                        {{ $texto_corto }}
                                    </span>                                     
                                    <div class="absolute z-20 invisible group-hover:visible bg-gray-900 text-white text-xs rounded-lg py-2 px-3 bottom-full left-0 mb-2 w-80 shadow-lg">                                         
                                        {!! nl2br(e($hallazgo->comentarios)) !!}                                         
                                        <div class="absolute top-full left-4 w-0 h-0 border-l-4 border-r-4 border-t-4 border-transparent border-t-gray-900"></div>                                     
                                    </div>                                 
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700 relative group">
                                    @if(count($auditados) > 2)
                                    <span class="cursor-pointer text-blue-600 hover:text-blue-800 font-medium">{{ count($responsableIds) }} auditados</span>
                                    <div class="absolute z-20 invisible group-hover:visible bg-gray-900 text-white text-xs rounded-lg py-2 px-3 bottom-full left-0 mb-2 w-64 shadow-lg">
                                        {{ $nombresAuditados }}
                                        <div class="absolute top-full left-4 w-0 h-0 border-l-4 border-r-4 border-t-4 border-transparent border-t-gray-900"></div>
                                    </div>
                                    @else
                                    {{ $nombresAuditados }}
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $jefeAuditadoId ? qcolab($jefeAuditadoId) : '' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $hallazgo->fecha_cierre ? \Carbon\Carbon::parse($hallazgo->fecha_cierre)->format('d/m/Y') : '' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    @if($hallazgo->estatus != 'Cerrado' || auth()->user()->auditoria == '1')
                                    <a href="/hallazgo/{{ $hallazgo->id }}/edit"
                                        class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Ver
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Paginación -->
            <div class="pagination-container">
                <div class="pagination-info">
                    @php
                        $total = $hallazgos->count();
                        $start = ($currentPage - 1) * $perPage + 1;
                        $end = min($currentPage * $perPage, $total);
                        $totalPages = ceil($total / $perPage);
                    @endphp
                    Mostrando {{ $start }} a {{ $end }} de {{ $total }} resultados
                </div>

                <div class="flex items-center gap-4">
                    <!-- Selector de registros por página -->
                    <div class="flex items-center gap-2">
                        <label for="perPage" class="text-sm text-gray-600">Mostrar:</label>
                        <select id="perPage" class="pagination-select" onchange="changePerPage(this.value)">
                            <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                        </select>
                    </div>

                    <!-- Controles de paginación -->
                    <div class="pagination-controls">
                        <!-- Primer página -->
                        <a href="{{ request()->fullUrlWithQuery(['page' => 1]) }}" 
                           class="pagination-btn {{ $currentPage == 1 ? 'disabled' : '' }}" 
                           {{ $currentPage == 1 ? 'onclick="return false"' : '' }}>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                            </svg>
                        </a>

                        <!-- Página anterior -->
                        <a href="{{ request()->fullUrlWithQuery(['page' => max(1, $currentPage - 1)]) }}" 
                           class="pagination-btn {{ $currentPage == 1 ? 'disabled' : '' }}"
                           {{ $currentPage == 1 ? 'onclick="return false"' : '' }}>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>

                        <!-- Números de página -->
                        @php
                            $startPage = max(1, $currentPage - 2);
                            $endPage = min($totalPages, $currentPage + 2);
                        @endphp

                        @if($startPage > 1)
                            <a href="{{ request()->fullUrlWithQuery(['page' => 1]) }}" class="pagination-btn">1</a>
                            @if($startPage > 2)
                                <span class="pagination-btn disabled">...</span>
                            @endif
                        @endif

                        @for($i = $startPage; $i <= $endPage; $i++)
                            <a href="{{ request()->fullUrlWithQuery(['page' => $i]) }}" 
                               class="pagination-btn {{ $i == $currentPage ? 'active' : '' }}">
                                {{ $i }}
                            </a>
                        @endfor

                        @if($endPage < $totalPages)
                            @if($endPage < $totalPages - 1)
                                <span class="pagination-btn disabled">...</span>
                            @endif
                            <a href="{{ request()->fullUrlWithQuery(['page' => $totalPages]) }}" class="pagination-btn">{{ $totalPages }}</a>
                        @endif

                        <!-- Página siguiente -->
                        <a href="{{ request()->fullUrlWithQuery(['page' => min($totalPages, $currentPage + 1)]) }}" 
                           class="pagination-btn {{ $currentPage == $totalPages ? 'disabled' : '' }}"
                           {{ $currentPage == $totalPages ? 'onclick="return false"' : '' }}>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>

                        <!-- Última página -->
                        <a href="{{ request()->fullUrlWithQuery(['page' => $totalPages]) }}" 
                           class="pagination-btn {{ $currentPage == $totalPages ? 'disabled' : '' }}"
                           {{ $currentPage == $totalPages ? 'onclick="return false"' : '' }}>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Modal para Editar Auditoría -->
@if(auth()->user()->auditoria == '1')
<div id="editAuditoriaModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div
        class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0">
        <div class="p-6">
            <!-- Header del modal -->
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                    Editar Auditoría
                </h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Contenido del modal -->
            <form action="{{ route('auditoria.update', $auditoria->id) }}" method="post" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                            </path>
                        </svg>
                        Tipo de Auditoría
                    </label>
                    <select
                        class="block w-full px-4 py-3 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                        name="tipo">
                        <option value="Programada" {{ $auditoria->tipo == 'PRO' ? 'selected' : '' }}>📅
                            Programada</option>
                        <option value="Especial" {{ $auditoria->tipo == 'ESP' ? 'selected' : '' }}>⭐ Especial
                        </option>
                        <option value="Extraordinaria" {{ $auditoria->tipo == 'EXT' ? 'selected' : '' }}>🚨
                            Extraordinaria</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                        Empresa
                    </label>
                    <select
                        class="block w-full px-4 py-3 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                        name="area">
                        <option value="" disabled>Seleccionar empresa</option>
                        @foreach($claves as $clave)
                        <option value="{{ $clave->clave }}" {{ $auditoria->area == $clave->clave ? 'selected' : '' }}>
                            {{ $clave->nombre }} [{{ $clave->clave }}]
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Información adicional -->
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                <span class="font-medium">Auditoría actual:</span>
                                {{ ($auditoria->tipo ?? '') . '-' . ($auditoria->area ?? '') . '-' . ($auditoria->anio ?? '') . '-' . ($auditoria->folio ?? '') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Botones del modal -->
                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancelar
                    </button>
                    <button type="submit"
                        class="inline-flex items-center px-6 py-2 border border-transparent rounded-lg shadow-sm bg-green-600 text-base font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 transform hover:scale-105">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                        </svg>
                        Actualizar Auditoría
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Modal para Crear Hallazgo -->
<div id="createHallazgoModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div
        class="bg-white rounded-lg shadow-xl max-w-4xl w-full mx-4 max-h-screen overflow-y-auto transform transition-all duration-300 scale-95 opacity-0">
        <div class="p-6">
            <!-- Header del modal -->
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Crear Hallazgo
                </h3>
                <button onclick="closeCreateModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Contenido del modal -->
            <form action="{{ route('crear_hallazgo') }}" method="post" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Columna izquierda -->
                    <div class="space-y-4">
                        <div>
                            <label for="colaborador_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Colaborador
                            </label>
                            <select id="colaborador_name" name="colaborador_id[]" multiple
                                class="block w-full px-4 py-3 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                @foreach($colaboradores as $col)
                                <option value="{{ $col->id }}">
                                    {{ $col->nombre . ' ' . $col->apellido_paterno . ' ' . $col->apellido_materno }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="areaseleccionada" class="block text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                                Área
                            </label>
                            <select name="area" id="areaseleccionada"
                                class="block w-full px-4 py-3 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                onchange="filtrarTitulos()">
                                <option value="">Selecciona</option>
                                @foreach($areash as $areach)
                                <option value="{{ $areach }}">{{ $areach }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="tituloseleccionado" class="block text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                    </path>
                                </svg>
                                Título
                            </label>
                            <select name="titulo" id="tituloseleccionado"
                                class="block w-full px-4 py-3 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                onchange="filtrarSubTitulos()">
                                <option value="">Selecciona</option>
                            </select>
                        </div>

                        <div>
                            <label for="subtituloseleccionado" class="block text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z">
                                    </path>
                                </svg>
                                Hallazgo
                            </label>
                            <select name="hallazgo" id="subtituloseleccionado"
                                class="block w-full px-4 py-3 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                <option value="">Selecciona</option>
                            </select>
                        </div>

                        <!-- NUEVO CAMPO CRITICIDAD -->
                        <div>
                            <label for="criticidad" class="block text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z">
                                    </path>
                                </svg>
                                Nivel de Criticidad
                            </label>
                            <select id="criticidad" name="criticidad" 
                                class="block w-full px-4 py-3 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                required>
                                <option value="">Selecciona el nivel</option>
                                <option value="baja" class="text-green-700">🟢 Baja</option>
                                <option value="media" class="text-yellow-700">🟡 Media</option>
                                <option value="alta" class="text-red-700">🔴 Alta</option>
                            </select>
                            <p class="mt-1 text-xs text-gray-500">
                                Indica el nivel de impacto y urgencia del hallazgo
                            </p>
                        </div>

                        <div>
                            <label for="sugerencia" class="block text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                    </path>
                                </svg>
                                Sugerencia
                            </label>
                            <textarea id="sugerencia" name="sugerencia"
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none"
                                rows="3" placeholder="Escriba su sugerencia aquí..."></textarea>
                        </div>
                    </div>

                    <!-- Columna derecha -->
                    <div class="space-y-4">
                        <div>
                            <label for="plan_de_accion" class="block text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                    </path>
                                </svg>
                                Plan de acción
                            </label>
                            <textarea id="plan_de_accion" name="plan_de_accion"
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none"
                                rows="3" placeholder="Describa el plan de acción..."></textarea>
                        </div>

                        <div>
                            <label for="fecha_presentacion" class="block text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                Fecha presentación
                            </label>
                            <input type="date" id="fecha_presentacion" name="fecha_presentacion"
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        </div>

                        <div>
                            <label for="fecha_compromiso" class="block text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                Fecha compromiso
                            </label>
                            <input type="date" id="fecha_compromiso" name="fecha_compromiso"
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        </div>

                        <div>
                            <label for="fecha_identificacion" class="block text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                Fecha identificación
                            </label>
                            <input type="date" id="fecha_identificacion" name="fecha_identificacion"
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        </div>

                        <div>
                            <label for="comentarios" class="block text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                                    </path>
                                </svg>
                                Comentarios
                            </label>
                            <textarea id="comentarios" name="comentarios"
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none"
                                rows="3" placeholder="Comentarios adicionales..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Sección de evidencia (ancho completo) -->
                <div class="pt-4 border-t">
                    <div>
                        <label for="evidencia" class="block text-sm font-semibold text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                                </path>
                            </svg>
                            Evidencia de auditoría
                        </label>
                        <input type="file" id="evidencia" name="evidencia"
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="mt-2 text-xs text-gray-500">Tamaño máximo: 60MB.</p>
                        <div id="file-info" class="mt-2 hidden"></div>
                    </div>
                </div>

                <!-- Campos ocultos -->
                <input type="hidden" name="tipo" value="{{ $auditoria->tipo }}">
                <input type="hidden" name="area" value="{{ $auditoria->area }}">
                <input type="hidden" name="ubicacion" value="{{ $auditoria->ubicacion }}">
                <input type="hidden" name="anio" value="{{ $auditoria->anio }}">
                <input type="hidden" name="folio" value="{{ $auditoria->folio }}">
                <input type="hidden" name="auditoria_id" value="{{ $auditoria->id }}">

                <!-- Botones del modal -->
                <div class="flex justify-end space-x-3 pt-6 border-t">
                    <button type="button" onclick="closeCreateModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancelar
                    </button>
                    <button type="submit"
                        class="inline-flex items-center px-6 py-2 border border-transparent rounded-lg shadow-sm bg-blue-600 text-base font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:scale-105">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Crear Hallazgo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de Confirmación para Eliminar Auditoría -->
<div id="deleteAuditoriaModal"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div
        class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0">
        <div class="p-6">
            <!-- Header del modal -->
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-red-600 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z">
                        </path>
                    </svg>
                    Confirmar Eliminación
                </h3>
                <button onclick="closeDeleteModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Contenido del modal -->
            <div class="mb-6">
                <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h4 class="text-sm font-medium text-red-800">
                                ¿Está seguro de que desea eliminar esta auditoría?
                            </h4>
                            <div class="mt-2 text-sm text-red-700">
                                <p>Esta acción no se puede deshacer. Se eliminarán:</p>
                                <ul class="list-disc list-inside mt-2 space-y-1">
                                    <li>La auditoría completa</li>
                                    <li>Todos los hallazgos asociados</li>
                                    <li>Toda la documentación relacionada</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                <span class="font-medium">Auditoría a eliminar:</span><br>
                                {{ ($auditoria->tipo ?? '') . '-' . ($auditoria->area ?? '') . '-' . ($auditoria->anio ?? '') . '-' . ($auditoria->folio ?? '') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones del modal -->
            <div class="flex justify-end space-x-3 pt-4 border-t">
                <button type="button" onclick="closeDeleteModal()"
                    class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors font-medium">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                    Cancelar
                </button>
                <form action="{{ route('eliminar_auditoria') }}" method="post" class="inline">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" value="{{ $auditoria->id }}" name="auditoria_id">
                    <button type="submit" id="confirmDeleteBtn"
                        class="inline-flex items-center px-6 py-2 border border-transparent rounded-lg shadow-sm bg-red-600 text-base font-semibold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 transform hover:scale-105">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                        Sí, Eliminar Auditoría
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Scripts -->
@push('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Inicializar botones de scroll
    updateScrollButtons();
    
    // Observer para detectar cambios en el tamaño de la tabla
    const resizeObserver = new ResizeObserver(updateScrollButtons);
    const tableContainer = document.getElementById('tableScrollContent');
    const criticidicadSelect = document.getElementById('criticidad');
    if (tableContainer) {
        resizeObserver.observe(tableContainer);
    }

     if (criticidicadSelect) {
        // Manejar cambio de criticidad
        criticidicadSelect.addEventListener('change', function() {
            const value = this.value;
            
            // Remover clases anteriores
            this.removeAttribute('data-selected');
            this.classList.remove('border-green-500', 'border-yellow-500', 'border-red-500');
            
            // Aplicar estilo según la criticidad seleccionada
            if (value) {
                this.setAttribute('data-selected', value);
                
                // Opcional: cambiar el color del borde según la criticidad
                switch (value) {
                    case 'baja':
                        this.classList.add('border-green-500');
                        showCriticidicadInfo('baja');
                        break;
                    case 'media':
                        this.classList.add('border-yellow-500');
                        showCriticidicadInfo('media');
                        break;
                    case 'alta':
                        this.classList.add('border-red-500');
                        showCriticidicadInfo('alta');
                        break;
                }
            }
        });
        
        // Validación en tiempo real
        criticidicadSelect.addEventListener('blur', function() {
            if (!this.value) {
                showValidationMessage(this, 'Debe seleccionar un nivel de criticidad');
                this.classList.add('border-red-300');
            } else {
                clearValidationMessage(this);
                this.classList.remove('border-red-300');
            }
        });
    }
});

function showCriticidicadInfo(nivel) {
    const infoMessages = {
        'baja': {
            title: '🟢 Criticidad Baja',
            description: 'Impacto mínimo - Se puede abordar en el ciclo normal de trabajo.',
            color: 'text-green-600'
        },
        'media': {
            title: '🟡 Criticidad Media', 
            description: 'Impacto moderado - Requiere atención prioritaria en el corto plazo.',
            color: 'text-yellow-600'
        },
        'alta': {
            title: '🔴 Criticidad Alta',
            description: 'Impacto severo - Requiere acción inmediata y seguimiento estrecho.',
            color: 'text-red-600'
        }
    };
    
    const info = infoMessages[nivel];
    if (info) {
        // Remover notificación anterior si existe
        const existingNotification = document.getElementById('criticidad-notification');
        if (existingNotification) {
            existingNotification.remove();
        }
        
        // Crear nueva notificación
        const notification = document.createElement('div');
        notification.id = 'criticidad-notification';
        notification.className = `mt-2 p-3 bg-gray-50 rounded-lg border-l-4 border-${nivel === 'baja' ? 'green' : nivel === 'media' ? 'yellow' : 'red'}-400 transition-all duration-300`;
        notification.innerHTML = `
            <div class="flex">
                <div class="ml-3">
                    <p class="text-sm font-medium ${info.color}">
                        ${info.title}
                    </p>
                    <p class="text-xs text-gray-600 mt-1">
                        ${info.description}
                    </p>
                </div>
            </div>
        `;
        
        // Insertar la notificación después del campo criticidad
        const criticidicadField = document.getElementById('criticidad');
        const parent = criticidicadField.parentNode;
        parent.appendChild(notification);
        
        // Auto-remover después de 5 segundos
        setTimeout(() => {
            if (notification && notification.parentNode) {
                notification.style.opacity = '0';
                notification.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }
        }, 5000);
    }
}

// Función para actualizar la visibilidad de los botones de scroll
function updateScrollButtons() {
    const container = document.getElementById('tableScrollContent');
    const scrollLeftBtn = document.getElementById('scrollLeft');
    const scrollRightBtn = document.getElementById('scrollRight');
    const indicatorLeft = document.getElementById('scrollIndicatorLeft');
    const indicatorRight = document.getElementById('scrollIndicatorRight');
    
    if (!container || !scrollLeftBtn || !scrollRightBtn) return;
    
    const { scrollLeft, scrollWidth, clientWidth } = container;
    const maxScrollLeft = scrollWidth - clientWidth;
    
    // Botón izquierdo
    if (scrollLeft > 0) {
        scrollLeftBtn.classList.remove('hidden');
        indicatorLeft.classList.remove('hidden');
    } else {
        scrollLeftBtn.classList.add('hidden');
        indicatorLeft.classList.add('hidden');
    }
    
    // Botón derecho
    if (scrollLeft < maxScrollLeft - 1) {
        scrollRightBtn.classList.remove('hidden');
        indicatorRight.classList.remove('hidden');
    } else {
        scrollRightBtn.classList.add('hidden');
        indicatorRight.classList.add('hidden');
    }
}

// Función para hacer scroll en la tabla
function scrollTable(direction) {
    const container = document.getElementById('tableScrollContent');
    if (!container) return;
    
    const scrollAmount = 300; // pixels a desplazar
    const currentScroll = container.scrollLeft;
    
    if (direction === 'left') {
        container.scrollTo({
            left: Math.max(0, currentScroll - scrollAmount),
            behavior: 'smooth'
        });
    } else {
        container.scrollTo({
            left: currentScroll + scrollAmount,
            behavior: 'smooth'
        });
    }
}

// Función para cambiar registros por página
function changePerPage(perPage) {
    const currentUrl = new URL(window.location);
    currentUrl.searchParams.set('per_page', perPage);
    currentUrl.searchParams.set('page', 1); // Resetear a la primera página
    window.location.href = currentUrl.toString();
}

function openEditModal() {
    const modal = document.getElementById('editAuditoriaModal');
    const modalContent = modal.querySelector('.bg-white');

    if (modal) {
        // Mostrar modal
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        // Animar entrada
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
    }
}

function closeEditModal() {
    const modal = document.getElementById('editAuditoriaModal');
    const modalContent = modal.querySelector('.bg-white');

    if (modal) {
        // Animar salida
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');

        // Ocultar modal después de la animación
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 300);
    }
}

// Cerrar modal con tecla ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeEditModal();
    }
});

// Cerrar modal al hacer clic en el fondo
document.addEventListener('click', function(e) {
    if (e.target.id === 'editAuditoriaModal') {
        closeEditModal();
    }
});

// Prevenir cierre accidental del formulario
document.querySelector('#editAuditoriaModal form')?.addEventListener('submit', function(e) {
    const submitBtn = this.querySelector('button[type="submit"]');
    if (submitBtn && !submitBtn.disabled) {
        submitBtn.disabled = true;
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Actualizando...
        `;

        // Reactivar después de 5 segundos por seguridad
        setTimeout(() => {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        }, 5000);
    }
});

// Auto-hide success alert con animación mejorada
setTimeout(function() {
    let alert = document.getElementById('success-alert');
    if (alert) {
        alert.style.transform = 'translateX(100%)';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
    }
}, 3000);

// Toggle collapse functionality mejorado
function toggleCollapse(elementId) {
    const element = document.getElementById(elementId);
    const icon = document.getElementById('icon-' + elementId.split('-')[1]);

    if (element.classList.contains('hidden')) {
        element.classList.remove('hidden');
        element.style.maxHeight = 'none';
        element.style.opacity = '1';
        element.style.transform = 'translateY(0)';
        icon.style.transform = 'rotate(180deg)';
    } else {
        element.style.maxHeight = '0';
        element.style.opacity = '0';
        element.style.transform = 'translateY(-10px)';
        icon.style.transform = 'rotate(0deg)';
        setTimeout(() => {
            element.classList.add('hidden');
        }, 300);
    }
}

// Filtrar títulos con loading state
function filtrarTitulos() {
    var areaSeleccionada = document.getElementById('areaseleccionada').value;
    var selectTitulo = document.getElementById('tituloseleccionado');

    console.log('Área seleccionada:', areaSeleccionada);

    if (areaSeleccionada) {
        // Mostrar loading
        selectTitulo.innerHTML = '<option value="">Cargando...</option>';
        selectTitulo.disabled = true;

        $.ajax({
            url: "{{ route('obtener-titulos') }}",
            method: 'POST',
            data: {
                area: areaSeleccionada,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log('Titulos filtrados:', response);
                selectTitulo.disabled = false;

                if (Array.isArray(response)) {
                    selectTitulo.innerHTML = '<option value="">Selecciona</option>';

                    response.forEach(function(titulo) {
                        var option = document.createElement('option');
                        option.value = titulo;
                        option.textContent = titulo;
                        selectTitulo.appendChild(option);
                    });

                    // Animación de éxito
                    selectTitulo.classList.add('border-green-300');
                    setTimeout(() => selectTitulo.classList.remove('border-green-300'), 1000);
                } else {
                    console.error("La respuesta no es un arreglo:", response);
                    selectTitulo.innerHTML = '<option value="">Error al cargar</option>';
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en la petición:', error);
                selectTitulo.disabled = false;
                selectTitulo.innerHTML = '<option value="">Error al cargar</option>';
                selectTitulo.classList.add('border-red-300');
            }
        });
    }
}

// Objeto para guardar la configuración de cada subtítulo
var configSubtitulos = {};

function filtrarSubTitulos() {
    var tituloSeleccionado = document.getElementById('tituloseleccionado').value;
    var selectSubtitulo = document.getElementById('subtituloseleccionado');

    console.log('Título seleccionado:', tituloSeleccionado);

    if (tituloSeleccionado) {
        // Mostrar loading
        selectSubtitulo.innerHTML = '<option value="">Cargando...</option>';
        selectSubtitulo.disabled = true;

        $.ajax({
            url: "{{ route('obtener-subtitulos') }}",
            method: 'POST',
            data: {
                area: tituloSeleccionado,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log('Subtítulos filtrados:', response);
                selectSubtitulo.disabled = false;

                if (Array.isArray(response)) {
                    selectSubtitulo.innerHTML = '<option value="">Selecciona</option>';

                    // Limpiar config anterior
                    configSubtitulos = {};

                    response.forEach(function(item) {
                        var option = document.createElement('option');
                        option.value = item.subtitulo;
                        option.textContent = item.subtitulo;
                        selectSubtitulo.appendChild(option);

                        // Guardar la config
                        configSubtitulos[item.subtitulo] = item.obligatorio;
                    });

                    // Animación de éxito
                    selectSubtitulo.classList.add('border-green-300');
                    setTimeout(() => selectSubtitulo.classList.remove('border-green-300'), 1000);
                } else {
                    console.error("La respuesta no es un arreglo:", response);
                    selectSubtitulo.innerHTML = '<option value="">Error al cargar</option>';
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en la petición:', error);
                selectSubtitulo.disabled = false;
                selectSubtitulo.innerHTML = '<option value="">Error al cargar</option>';
                selectSubtitulo.classList.add('border-red-300');
            }
        });
    }
}

// Ejecutar al cargar el documento
document.addEventListener('DOMContentLoaded', function() {
    var selectSubtitulo = document.getElementById('subtituloseleccionado');
    var fechaInput = document.getElementById('fecha_compromiso');

    if (selectSubtitulo && fechaInput) {
        selectSubtitulo.addEventListener('change', function() {
            var subtituloSeleccionado = this.value;
            var obligatorio = configSubtitulos[subtituloSeleccionado];

            if (parseInt(obligatorio) === 1) {
                fechaInput.setAttribute('required', 'required');
                fechaInput.classList.add('border-red-300', 'ring-red-500');
                fechaInput.classList.remove('border-gray-300');
                console.log("Campo 'fecha_compromiso' es obligatorio.");

                // Añadir indicador visual
                const label = fechaInput.previousElementSibling;
                if (label && !label.querySelector('.text-red-500')) {
                    label.innerHTML += ' <span class="text-red-500">*</span>';
                }
            } else {
                fechaInput.removeAttribute('required');
                fechaInput.classList.remove('border-red-300', 'ring-red-500');
                fechaInput.classList.add('border-gray-300');
                console.log("Campo 'fecha_compromiso' es opcional.");

                // Remover indicador visual
                const label = fechaInput.previousElementSibling;
                if (label) {
                    const asterisk = label.querySelector('.text-red-500');
                    if (asterisk) asterisk.remove();
                }
            }
        });
    }

    // Validación de archivos mejorada
    const evidenciaInput = document.getElementById('evidencia');
    if (evidenciaInput) {
        evidenciaInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            const fileInfo = document.getElementById('file-info');

            if (file) {
                const maxSize = 60 * 1024 * 1024; // 60MB
                if (file.size > maxSize) {
                    // Error de tamaño
                    this.value = '';
                    this.classList.add('border-red-300');
                    fileInfo.className = 'mt-2 flex items-center text-sm text-red-600';
                    fileInfo.innerHTML = `
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Error: El archivo es demasiado grande. Máximo: 60MB
                    `;
                    fileInfo.classList.remove('hidden');
                    return;
                }

                // Archivo válido
                const fileName = file.name;
                const fileSize = (file.size / 1024 / 1024).toFixed(2);

                this.classList.remove('border-red-300');
                this.classList.add('border-green-300');
                fileInfo.className = 'mt-2 flex items-center text-sm text-green-600';
                fileInfo.innerHTML = `
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    ${fileName} (${fileSize} MB)
                `;
                fileInfo.classList.remove('hidden');
            } else {
                fileInfo.classList.add('hidden');
                this.classList.remove('border-red-300', 'border-green-300');
            }
        });
    }

    // Animaciones de entrada para las cards
    const cards = document.querySelectorAll('.bg-white.shadow-xl');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease-out';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 150);
    });

    // Mejorar tooltips con mejor posicionamiento
    const tooltipElements = document.querySelectorAll('.group');
    tooltipElements.forEach(element => {
        element.addEventListener('mouseenter', function() {
            const tooltip = this.querySelector('.group-hover\\:visible');
            if (tooltip) {
                // Verificar si el tooltip se sale de la pantalla
                const rect = tooltip.getBoundingClientRect();
                if (rect.right > window.innerWidth) {
                    tooltip.style.left = 'auto';
                    tooltip.style.right = '0';
                }
                if (rect.bottom > window.innerHeight) {
                    tooltip.style.top = 'auto';
                    tooltip.style.bottom = '100%';
                    tooltip.style.marginBottom = '5px';
                }
            }
        });
    });
});

// Prevenir envío accidental de formularios
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        if (submitBtn && !submitBtn.disabled) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = submitBtn.innerHTML.replace(/([^>]+)(<\/button>)/, `
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Procesando...
            `);

            // Reactivar después de 5 segundos por seguridad
            setTimeout(() => {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    location.reload(); // Recargar si toma mucho tiempo
                }
            }, 5000);
        }
    });
});


// Función para abrir el modal
function openCreateModal() {
    const modal = document.getElementById('createHallazgoModal');
    const modalContent = modal.querySelector('.bg-white');

    if (modal) {
        // Mostrar modal
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        // Animar entrada
        setTimeout(() => {
            modal.classList.add('active');
            modalContent.classList.add('animate-fade-scale');
        }, 10);

        // Inicializar campos
        initializeModalFields();
    }
}

// Función para cerrar el modal
function closeCreateModal() {
    const modal = document.getElementById('createHallazgoModal');
    const modalContent = modal.querySelector('.bg-white');

    if (modal) {
        // Animar salida
        modal.classList.remove('active');
        modalContent.classList.remove('animate-fade-scale');

        // Ocultar modal después de la animación
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            resetModalForm();
        }, 300);
    }
}

// Función para inicializar campos del modal
function initializeModalFields() {
    // Inicializar select múltiple si existe
    const multiSelect = document.getElementById('colaborador_name');
    if (multiSelect) {
        enhanceMultiSelect(multiSelect);
    }

    // Inicializar validaciones
    initializeValidations();

    // Configurar eventos de archivos
    setupFileInputEvents();
}

// Función para resetear el formulario
function resetModalForm() {
    const form = document.querySelector('#createHallazgoModal form');
    if (form) {
        form.reset();
        
        // Limpiar validaciones
        clearValidationMessages();
        
        // Resetear estilos
        resetFieldStyles();
        
        // Limpiar criticidad
        const criticidicadSelect = document.getElementById('criticidad');
        if (criticidicadSelect) {
            criticidicadSelect.removeAttribute('data-selected');
            criticidicadSelect.classList.remove('border-green-500', 'border-yellow-500', 'border-red-500');
        }
        
        // Remover notificación de criticidad si existe
        const notification = document.getElementById('criticidad-notification');
        if (notification) {
            notification.remove();
        }
        
        // Limpiar selects dependientes
        clearSelect(document.getElementById('tituloseleccionado'));
        clearSelect(document.getElementById('subtituloseleccionado'));
    }
}

// Funciones auxiliares
function showLoadingState(select, message) {
    select.innerHTML = `<option value="">${message}</option>`;
    select.disabled = true;
    select.classList.add('loading');
}

function hideLoadingState(select) {
    select.disabled = false;
    select.classList.remove('loading');
}

function populateSelect(select, options) {
    select.innerHTML = '<option value="">Selecciona</option>';
    options.forEach(option => {
        const optionElement = document.createElement('option');
        optionElement.value = option;
        optionElement.textContent = option;
        select.appendChild(optionElement);
    });
}

function clearSelect(select) {
    select.innerHTML = '<option value="">Selecciona</option>';
}

function clearSubTitulos() {
    const selectSubtitulo = document.getElementById('subtituloseleccionado');
    if (selectSubtitulo) {
        clearSelect(selectSubtitulo);
    }
}

function showSuccessAnimation(element) {
    element.classList.add('border-green-300');
    setTimeout(() => {
        element.classList.remove('border-green-300');
    }, 1000);
}

function configureRequiredFields(value) {
    const fechaCompromiso = document.getElementById('fecha_compromiso');
    if (fechaCompromiso) {
        // Ejemplo: hacer requerido basado en el valor
        if (value === 'Título 1') {
            makeFieldRequired(fechaCompromiso);
        } else {
            makeFieldOptional(fechaCompromiso);
        }
    }
}

function makeFieldRequired(field) {
    field.setAttribute('required', 'required');
    field.classList.add('required-field');

    const label = field.previousElementSibling;
    if (label) {
        label.classList.add('required-label');
    }
}

function makeFieldOptional(field) {
    field.removeAttribute('required');
    field.classList.remove('required-field');

    const label = field.previousElementSibling;
    if (label) {
        label.classList.remove('required-label');
    }
}

function enhanceMultiSelect(select) {
    // Agregar funcionalidad mejorada para select múltiple
    select.addEventListener('change', function() {
        const selectedOptions = Array.from(this.selectedOptions);
        console.log('Colaboradores seleccionados:', selectedOptions.map(opt => opt.text));
    });
}

function initializeValidations() {
    // Configurar validaciones en tiempo real
    const inputs = document.querySelectorAll(
        '#createHallazgoModal input, #createHallazgoModal select, #createHallazgoModal textarea');

    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });

        input.addEventListener('input', function() {
            clearValidationMessage(this);
        });
    });
}

function validateField(field) {
    const isValid = field.checkValidity();

    if (!isValid) {
        showValidationMessage(field, field.validationMessage);
        field.classList.add('border-red-300');
    } else {
        clearValidationMessage(field);
        field.classList.remove('border-red-300');
    }
}

function showValidationMessage(field, message) {
    let validationDiv = field.nextElementSibling;

    if (!validationDiv || !validationDiv.classList.contains('validation-message')) {
        validationDiv = document.createElement('div');
        validationDiv.className = 'validation-message';
        field.parentNode.insertBefore(validationDiv, field.nextSibling);
    }

    validationDiv.textContent = message;
    validationDiv.classList.add('show');
}

function clearValidationMessage(field) {
    const validationDiv = field.nextElementSibling;
    if (validationDiv && validationDiv.classList.contains('validation-message')) {
        validationDiv.classList.remove('show');
    }
}

function clearValidationMessages() {
    const messages = document.querySelectorAll('#createHallazgoModal .validation-message');
    messages.forEach(message => {
        message.classList.remove('show');
    });
}

function resetFieldStyles() {
    const fields = document.querySelectorAll(
        '#createHallazgoModal input, #createHallazgoModal select, #createHallazgoModal textarea');
    fields.forEach(field => {
        field.classList.remove('border-red-300', 'border-green-300', 'required-field');
    });
}

function setupFileInputEvents() {
    const fileInput = document.getElementById('evidencia');
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            handleFileSelection(e);
        });
    }
}

function handleFileSelection(event) {
    const file = event.target.files[0];
    const fileInput = event.target;

    if (file) {
        const maxSize = 60 * 1024 * 1024; // 60MB
        const allowedTypes = ['application/pdf', 'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'image/jpeg', 'image/png'
        ];

        if (file.size > maxSize) {
            showFileError(fileInput, 'El archivo es demasiado grande. Máximo: 60MB');
            return;
        }

        if (!allowedTypes.includes(file.type)) {
            showFileError(fileInput, 'Tipo de archivo no permitido');
            return;
        }

        showFileSuccess(fileInput, file);
    }
}

function showFileError(input, message) {
    input.value = '';
    input.classList.add('border-red-300');
    showValidationMessage(input, message);
}

function showFileSuccess(input, file) {
    input.classList.remove('border-red-300');
    input.classList.add('border-green-300');

    const fileName = file.name;
    const fileSize = (file.size / 1024 / 1024).toFixed(2);

    // Mostrar información del archivo
    let fileInfo = document.getElementById('file-info');
    if (!fileInfo) {
        fileInfo = document.createElement('div');
        fileInfo.id = 'file-info';
        fileInfo.className = 'mt-2 text-sm text-green-600';
        input.parentNode.appendChild(fileInfo);
    }

    fileInfo.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    ${fileName} (${fileSize} MB)
                </div>
            `;
    fileInfo.classList.remove('hidden');
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Cerrar modal con ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCreateModal();
        }
    });

    // Cerrar modal al hacer clic fuera
    document.addEventListener('click', function(e) {
        if (e.target.id === 'createHallazgoModal') {
            closeCreateModal();
        }
    });

    // Configurar eventos del formulario
    const form = document.getElementById('createHallazgoForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            handleFormSubmit(this);
        });
    }
});

// Función para validar el formulario antes del envío 
function validateCreateHallazgoForm() {
    const form = document.querySelector('#createHallazgoModal form');
    const requiredFields = [
        { id: 'colaborador_name', name: 'Colaborador' },
        { id: 'areaseleccionada', name: 'Área' },
        { id: 'tituloseleccionado', name: 'Título' },
        { id: 'subtituloseleccionado', name: 'Hallazgo' },
        { id: 'criticidad', name: 'Criticidad' },
        { id: 'fecha_presentacion', name: 'Fecha de presentación' },
        { id: 'fecha_identificacion', name: 'Fecha de identificación' }
    ];
    
    let isValid = true;
    const errors = [];
    
    requiredFields.forEach(field => {
        const element = document.getElementById(field.id);
        if (element) {
            let value = element.value;
            
            // Para select múltiple, verificar si hay opciones seleccionadas
            if (field.id === 'colaborador_name') {
                value = Array.from(element.selectedOptions).length > 0;
            }
            
            if (!value) {
                isValid = false;
                errors.push(field.name);
                element.classList.add('border-red-300', 'required-field');
                showValidationMessage(element, `El campo ${field.name} es requerido`);
            } else {
                element.classList.remove('border-red-300', 'required-field');
                clearValidationMessage(element);
            }
        }
    });
    
    // Validación específica para criticidad
    const criticidicadSelect = document.getElementById('criticidad');
    if (criticidicadSelect && criticidicadSelect.value) {
        const validValues = ['baja', 'media', 'alta'];
        if (!validValues.includes(criticidicadSelect.value)) {
            isValid = false;
            errors.push('Nivel de criticidad inválido');
            showValidationMessage(criticidicadSelect, 'Debe seleccionar un nivel de criticidad válido');
        }
    }
    
    // Validación de fechas
    const fechaPresentacion = document.getElementById('fecha_presentacion');
    const fechaIdentificacion = document.getElementById('fecha_identificacion');
    const fechaCompromiso = document.getElementById('fecha_compromiso');
    
    if (fechaPresentacion && fechaIdentificacion && fechaPresentacion.value && fechaIdentificacion.value) {
        const presentacion = new Date(fechaPresentacion.value);
        const identificacion = new Date(fechaIdentificacion.value);
        
        if (presentacion > identificacion) {
            isValid = false;
            errors.push('La fecha de presentación no puede ser posterior a la fecha de identificación');
            showValidationMessage(fechaPresentacion, 'La fecha de presentación debe ser anterior o igual a la fecha de identificación');
        }
    }
    
    if (fechaCompromiso && fechaCompromiso.value && fechaIdentificacion && fechaIdentificacion.value) {
        const compromiso = new Date(fechaCompromiso.value);
        const identificacion = new Date(fechaIdentificacion.value);
        
        if (compromiso < identificacion) {
            isValid = false;
            errors.push('La fecha de compromiso no puede ser anterior a la fecha de identificación');
            showValidationMessage(fechaCompromiso, 'La fecha de compromiso debe ser posterior a la fecha de identificación');
        }
    }
    
    // Mostrar resumen de errores si hay
    if (!isValid) {
        showFormErrors(errors);
    }
    
    return isValid;
}

// Función para mostrar errores del formulario
function showFormErrors(errors) {
    // Remover notificación anterior si existe
    const existingError = document.getElementById('form-error-notification');
    if (existingError) {
        existingError.remove();
    }
    
    // Crear notificación de error
    const errorNotification = document.createElement('div');
    errorNotification.id = 'form-error-notification';
    errorNotification.className = 'fixed top-4 right-4 z-50 max-w-md bg-red-50 border border-red-200 rounded-lg p-4 shadow-lg';
    errorNotification.innerHTML = `
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">
                    Errores en el formulario
                </h3>
                <div class="mt-2 text-sm text-red-700">
                    <ul class="list-disc list-inside space-y-1">
                        ${errors.map(error => `<li>${error}</li>`).join('')}
                    </ul>
                </div>
            </div>
            <div class="ml-auto pl-3">
                <div class="-mx-1.5 -my-1.5">
                    <button type="button" onclick="this.parentElement.parentElement.parentElement.parentElement.remove()" class="inline-flex bg-red-50 rounded-md p-1.5 text-red-500 hover:bg-red-100">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    `;
    
    document.body.appendChild(errorNotification);
    
    // Auto-remover después de 10 segundos
    setTimeout(() => {
        if (errorNotification && errorNotification.parentNode) {
            errorNotification.remove();
        }
    }, 10000);
}

function handleFormSubmit(form) {
    // Prevenir envío por defecto
    event.preventDefault();
    
    // Validar formulario
    if (!validateCreateHallazgoForm()) {
        return false;
    }
    
    const submitBtn = form.querySelector('button[type="submit"]');
    
    if (submitBtn) {
        // Deshabilitar botón y mostrar loading
        submitBtn.disabled = true;
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Creando hallazgo...
        `;
        
        // Enviar formulario
        form.submit();
        
        // Restaurar botón después de un tiempo por seguridad
        setTimeout(() => {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        }, 5000);
    }
}

// Función para agregar tooltips informativos sobre criticidad
function addCriticidicadTooltips() {
    const criticidicadLabel = document.querySelector('label[for="criticidad"]');
    if (criticidicadLabel) {
        // Agregar icono de información
        const infoIcon = document.createElement('span');
        infoIcon.className = 'criticidad-tooltip ml-1 cursor-help';
        infoIcon.innerHTML = `
            <svg class="w-4 h-4 inline text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div class="tooltip-content">
                <strong>Niveles de Criticidad:</strong><br><br>
                <strong>🟢 Baja:</strong> Hallazgos menores que no afectan significativamente las operaciones. Pueden resolverse en el ciclo normal de trabajo.<br><br>
                <strong>🟡 Media:</strong> Hallazgos que requieren atención prioritaria y pueden impactar moderadamente las operaciones si no se atienden.<br><br>
                <strong>🔴 Alta:</strong> Hallazgos críticos que requieren acción inmediata debido a su alto impacto en la seguridad, calidad o cumplimiento.
            </div>
        `;
        
        criticidicadLabel.appendChild(infoIcon);
    }
}

// Funciones para el modal de eliminar
function openDeleteModal() {
    const modal = document.getElementById('deleteAuditoriaModal');
    const modalContent = modal.querySelector('.bg-white');

    if (modal) {
        // Mostrar modal
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        // Animar entrada
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
    }
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteAuditoriaModal');
    const modalContent = modal.querySelector('.bg-white');

    if (modal) {
        // Animar salida
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');

        // Ocultar modal después de la animación
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 300);
    }
}

// Event listeners para el modal de eliminar
document.addEventListener('DOMContentLoaded', function() {
    // Cerrar modal con tecla ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });

    // Cerrar modal al hacer clic en el fondo
    document.addEventListener('click', function(e) {
        if (e.target.id === 'deleteAuditoriaModal') {
            closeDeleteModal();
        }
    });

    // Manejar envío del formulario de eliminación
    const deleteForm = document.querySelector('#deleteAuditoriaModal form');
    if (deleteForm) {
        deleteForm.addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('confirmDeleteBtn');
            if (submitBtn && !submitBtn.disabled) {
                submitBtn.disabled = true;
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Eliminando...
                `;

                // Reactivar después de 10 segundos por seguridad
                setTimeout(() => {
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    }
                }, 10000);
            }
        });
    }
});

// Función de utilidad para mostrar notificaciones
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className =
        `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white`;
    notification.textContent = message;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>


@endpush
