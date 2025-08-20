@extends('home', ['activePage' => 'Vacantes', 'menuParent' => 'laravel', 'titlePage' => __('Vacantes')])

@section('contentJunzi')
<style>
    .modal-backdrop {
        backdrop-filter: blur(4px);
        animation: fadeIn 0.3s ease-out;
    }

    .modal-content {
        animation: slideIn 0.3s ease-out;
        transform-origin: center;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: scale(0.95) translateY(-20px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    .form-group {
        position: relative;
    }

    .floating-label {
        position: absolute;
        left: 12px;
        top: 12px;
        color: #6b7280;
        font-size: 0.875rem;
        transition: all 0.2s ease;
        pointer-events: none;
    }

    .form-input:focus + .floating-label,
    .form-input:not(:placeholder-shown) + .floating-label {
        top: -8px;
        left: 8px;
        font-size: 0.75rem;
        color: #3b82f6;
        background: white;
        padding: 0 4px;
    }

    .form-input {
        padding-top: 16px;
        padding-bottom: 8px;
    }

    .priority-high { background: linear-gradient(135deg, #fee2e2, #fecaca); }
    .priority-medium { background: linear-gradient(135deg, #fef3c7, #fde68a); }
    .priority-low { background: linear-gradient(135deg, #d1fae5, #a7f3d0); }

    .section-divider {
        background: linear-gradient(90deg, transparent, #e5e7eb, transparent);
        height: 1px;
        margin: 1.5rem 0;
    }

    .glass-effect {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
</style>
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 py-8 mt-5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
    <div class="bg-gradient-to-r from-teal-600 to-cyan-700 rounded-xl shadow-lg mb-6">

        <!-- Main Card -->
        <div class="bg-white shadow-xl rounded-lg overflow-hidden">

        <!-- Card Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6">
            <div class="flex items-center justify-between">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6M8 8v10a2 2 0 002 2h4a2 2 0 002-2V8m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v2"></path>
                </svg>
                <h1 class="text-2xl font-bold text-white py-4">
                Gestión de Vacantes
                </h1>
            </div>

            <!-- Header Buttons -->
            <div class="flex space-x-3">
                <button onclick="openModal()"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nueva Vacante
                </button>
            </div>
            </div>
        </div>

        <!-- Card Body -->
        <div class="p-6 pt-12">

            <!-- Custom Tabs -->
            <div class="w-full mt-8">
            <!-- Tab Buttons -->
            <div class="border-b border-gray-200 mb-8">
                <nav class="-mb-px flex space-x-8">
                <button class="custom-tab-button py-4 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600 whitespace-nowrap focus:outline-none focus:text-blue-600 focus:border-blue-500 transition duration-150 ease-in-out"
                        data-tab="enProceso">
                    <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    En Proceso
                    </div>
                </button>
                <button class="custom-tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out"
                        data-tab="enEspera">
                    <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    En Espera de Ingreso
                    </div>
                </button>
                <button class="custom-tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out"
                        data-tab="historico">
                    <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    Histórico
                    </div>
                </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="tab-content">

                <!-- En Proceso -->
                <div id="enProceso" class="custom-tab-content active">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200" style="min-height: 600px;">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                        <th scope="col" class="px-6 py-5 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            <div class="flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2"/>
                            </svg>
                            Prioridad
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-5 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            <div class="flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                            </svg>
                            # Candidatos
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-5 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Puesto</th>
                        <th scope="col" class="px-6 py-5 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Proceso</th>
                        <th scope="col" class="px-6 py-5 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Tiempo Abierta</th>
                        <th scope="col" class="px-6 py-5 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Seguimiento</th>
                        <th scope="col" class="px-6 py-5 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($vacantesEnProceso as $vac)
                        {{-- datos reales --}}
                        @include('vacantes.partials.row', ['vac' => $vac, 'tab' => 'enProceso'])
                        @endforeach
                    </tbody>
                    </table>
                </div>
                </div>

                <!-- En Espera -->
                <div id="enEspera" class="custom-tab-content hidden">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200" style="min-height: 600px;">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                        <th scope="col" class="px-6 py-5 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            <div class="flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2"/>
                            </svg>
                            Prioridad
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-5 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            <div class="flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                            </svg>
                            # Candidatos
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-5 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Puesto</th>
                        <th scope="col" class="px-6 py-5 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Proceso</th>
                        <th scope="col" class="px-6 py-5 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Tiempo Abierta</th>
                        <th scope="col" class="px-6 py-5 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Seguimiento</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($vacantesEnEspera as $vac)
                        <!-- <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                            <td class="px-6 py-5 whitespace-nowrap text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Media
                            </span>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-center">
                            <span class="text-sm font-medium text-gray-900">2</span>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-center">
                            <span class="text-sm text-gray-900">Analista de Datos</span>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Aprobado
                            </span>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-center">
                            <span class="text-sm text-gray-500">8 días</span>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-center">
                            <button class="inline-flex items-center justify-center w-9 h-9 border border-transparent rounded-lg text-white bg-orange-500 hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition duration-150 ease-in-out shadow-sm" title="En espera">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </button>
                            </td>
                        </tr> -->
                        {{-- Aquí van los datos reales del foreach --}}
                        @include('vacantes.partials.row', ['vac' => $vac, 'tab' => 'enEspera'])
                        @endforeach
                    </tbody>
                    </table>
                </div>
                </div>

                <!-- Histórico -->
                <div id="historico" class="custom-tab-content hidden">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200" style="min-height: 600px;">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2"/>
                            </svg>
                            Prioridad
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            <div class="flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                            </svg>
                            # Candidatos
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Puesto</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Proceso</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Tiempo Abierta</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Seguimiento</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($vacantesHistorico as $vac)
                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                            <td class="px-6 py-5 whitespace-nowrap text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                Baja
                            </span>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-center">
                            <span class="text-sm font-medium text-gray-900">1</span>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-center">
                            <span class="text-sm text-gray-900">Asistente Administrativo</span>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                Cerrado
                            </span>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-center">
                            <span class="text-sm text-gray-500">45 días</span>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-center">
                            <button class="inline-flex items-center justify-center w-9 h-9 border border-transparent rounded-lg text-white bg-gray-500 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 ease-in-out shadow-sm" title="Archivado">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8l6 6 6-6"/>
                                </svg>
                            </button>
                            </td>
                        </tr>
                        {{-- Aquí van los datos reales del foreach --}}
                        @include('vacantes.partials.row', ['vac' => $vac, 'tab' => 'historico'])
                        @endforeach
                    </tbody>
                    </table>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>
</div>

<!-- Modal Crear Vacante -->
<div id="vacantesModal" class="fixed inset-0 bg-black bg-opacity-40 modal-backdrop overflow-y-auto h-full w-full hidden z-50">
  <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
    <!-- Modal Header -->
    <div class="flex items-center justify-between pb-3 border-b">
      <h3 class="text-xl font-semibold text-gray-900">Nueva Vacante</h3>
      <button onclick="closeModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
        </svg>
      </button>
    </div>

    <!-- Modal Body -->
    <div class="pt-4">
        <form action="{{ route('vacantes.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
            <div>
                <label for="company_id" class="block text-sm font-medium text-gray-700 mb-2">Empresa</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="company_id" name="company_id" required>
                <option value="">Seleccione una empresa</option>
                @foreach($empresas as $empresa)
                    <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                @endforeach
                </select>
            </div>

            <div>
                <label for="departamento_id" class="block text-sm font-medium text-gray-700 mb-2">Departamento</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="departamento_id" name="departamento_id" required>
                <option value="">Seleccione un departamento</option>
                @foreach ($departamentos as $departamento)
                    <option value="{{ $departamento->id }}">{{ $departamento->departamento }}</option>
                @endforeach
                </select>
            </div>

            <div>
                <label for="solicitadas" class="block text-sm font-medium text-gray-700 mb-2">Solicitadas</label>
                <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="solicitadas" name="solicitadas" required>
            </div>

            <div>
                <label for="prioridad" class="block text-sm font-medium text-gray-700 mb-2">Prioridad</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="prioridad" name="prioridad">
                <option value="Alta">Alta</option>
                <option value="Media">Media</option>
                <option value="Baja">Baja</option>
                </select>
            </div>

            <div>
                <label for="nivel" class="block text-sm font-medium text-gray-700 mb-2">Nivel</label>
                <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="nivel" name="nivel" min="2" required>
            </div>
            </div>

            <div class="space-y-4">
            <div>
                <label for="puesto_id" class="block text-sm font-medium text-gray-700 mb-2">Puesto</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="puesto_id" name="puesto_id" required>
                <option value="">Seleccione un puesto</option>
                @foreach ($puestos as $puesto)
                    <option value="{{ $puesto->id }}">{{ $puesto->puesto }}</option>
                @endforeach
                </select>
            </div>

            <div>
                <label for="completadas" class="block text-sm font-medium text-gray-700 mb-2">Completadas</label>
                <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="completadas" name="completadas">
            </div>

            <div>
                <label for="jefe" class="block text-sm font-medium text-gray-700 mb-2">Jefe directo</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="jefe" name="jefe">
                <option value="">Seleccione un jefe directo</option>
                @foreach ($colaboradores as $colaborador)
                    <option value="{{ $colaborador->id }}">{{ $colaborador->nombre }} {{ $colaborador->apellido_paterno }} {{ $colaborador->apellido_materno }}</option>
                @endforeach
                </select>
            </div>

            <div>
                <label for="area_id" class="block text-sm font-medium text-gray-700 mb-2">Centro de costo</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="area_id" name="area_id" required>
                <option value="">Seleccione un centro de costo</option>
                @foreach ($centros as $centro)
                    <option value="{{ $centro->id }}">{{ $centro->centro_de_costo }}</option>
                @endforeach
                </select>
            </div>

            <div>
                <label for="fecha" class="block text-sm font-medium text-gray-700 mb-2">Fecha</label>
                <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="fecha" name="fecha" required>
            </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="flex items-center justify-end pt-6 border-t border-gray-200 space-x-2">
            <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-150 ease-in-out">
            Cancelar
            </button>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150 ease-in-out">
            Crear Vacante
            </button>
        </div>
        </form>
    </div>
  </div>
</div>

<!-- Modal de Edición de Vacante -->
<div id="editVacantesModal" class="fixed inset-0 bg-black bg-opacity-40 modal-backdrop overflow-y-auto h-full w-full hidden z-50">
  <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
    <!-- Modal Header -->
    <div class="flex items-center justify-between pb-3 border-b">
      <h3 class="text-xl font-semibold text-gray-900">Editar Vacante</h3>
      <button onclick="closeEditModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
        </svg>
      </button>
    </div>

    <!-- Modal Body -->
    <div class="pt-4">
        <form id="editVacanteForm" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
            <div>
                <label for="edit_company_id" class="block text-sm font-medium text-gray-700 mb-2">Empresa</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="edit_company_id" name="company_id" required>
                <option value="">Seleccione una empresa</option>
                @foreach($empresas as $empresa)
                    <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                @endforeach
                </select>
            </div>

            <div>
                <label for="edit_departamento_id" class="block text-sm font-medium text-gray-700 mb-2">Departamento</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="edit_departamento_id" name="departamento_id" required>
                <option value="">Seleccione un departamento</option>
                @foreach ($departamentos as $departamento)
                    <option value="{{ $departamento->id }}">{{ $departamento->departamento }}</option>
                @endforeach
                </select>
            </div>

            <div>
                <label for="edit_solicitadas" class="block text-sm font-medium text-gray-700 mb-2">Solicitadas</label>
                <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="edit_solicitadas" name="solicitadas" required>
            </div>

            <div>
                <label for="edit_prioridad" class="block text-sm font-medium text-gray-700 mb-2">Prioridad</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="edit_prioridad" name="prioridad">
                <option value="Alta">Alta</option>
                <option value="Media">Media</option>
                <option value="Baja">Baja</option>
                </select>
            </div>

            <div>
                <label for="edit_nivel" class="block text-sm font-medium text-gray-700 mb-2">Nivel</label>
                <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="edit_nivel" name="nivel" min="2" required>
            </div>
            </div>

            <div class="space-y-4">
            <div>
                <label for="edit_puesto_id" class="block text-sm font-medium text-gray-700 mb-2">Puesto</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="edit_puesto_id" name="puesto_id" required>
                <option value="">Seleccione un puesto</option>
                @foreach ($puestos as $puesto)
                    <option value="{{ $puesto->id }}">{{ $puesto->puesto }}</option>
                @endforeach
                </select>
            </div>

            <div>
                <label for="edit_completadas" class="block text-sm font-medium text-gray-700 mb-2">Completadas</label>
                <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="edit_completadas" name="completadas">
            </div>

            <div>
                <label for="edit_jefe" class="block text-sm font-medium text-gray-700 mb-2">Jefe directo</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="edit_jefe" name="jefe">
                <option value="">Seleccione un jefe directo</option>
                @foreach ($colaboradores as $colaborador)
                    <option value="{{ $colaborador->id }}">{{ $colaborador->nombre }} {{ $colaborador->apellido_paterno }} {{ $colaborador->apellido_materno }}</option>
                @endforeach
                </select>
            </div>

            <div>
                <label for="edit_area_id" class="block text-sm font-medium text-gray-700 mb-2">Centro de costo</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="edit_area_id" name="area_id" required>
                <option value="">Seleccione un centro de costo</option>
                @foreach ($centros as $centro)
                    <option value="{{ $centro->id }}">{{ $centro->centro_de_costo }}</option>
                @endforeach
                </select>
            </div>

            <div>
                <label for="edit_fecha" class="block text-sm font-medium text-gray-700 mb-2">Fecha</label>
                <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="edit_fecha" name="fecha" required>
            </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
            <!-- Botón Eliminar a la izquierda -->
            <button type="button" onclick="deleteVacante()" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H9a1 1 0 00-1 1v1M4 7h16"></path>
                </svg>
                Eliminar
            </button>

            <!-- Botones de acción a la derecha -->
            <div class="flex space-x-2">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                Guardar Cambios
                </button>
            </div>
        </div>
        </form>
    </div>
  </div>
</div>

<!-- Modal de Confirmación de Eliminación -->
<div id="deleteConfirmModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-60">
  <div class="flex items-center justify-center min-h-screen">
    <div class="bg-white rounded-lg p-6 m-4 max-w-md w-full">
      <div class="flex items-center mb-4">
        <svg class="w-6 h-6 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
        </svg>
        <h3 class="text-lg font-semibold text-gray-900">Confirmar Eliminación</h3>
      </div>
      <p class="text-gray-700 mb-6">¿Está seguro que desea eliminar esta vacante? Esta acción no se puede deshacer.</p>
      <div class="flex justify-end space-x-3">
        <button onclick="closeDeleteConfirmModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-150 ease-in-out">
          Cancelar
        </button>
        <button onclick="confirmDelete()" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition duration-150 ease-in-out">
          Eliminar
        </button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
document.addEventListener('DOMContentLoaded', () => {

  const buttons = document.querySelectorAll('.custom-tab-button');
  const contents = document.querySelectorAll('.custom-tab-content');

  buttons.forEach(button => {
    button.addEventListener('click', () => {
      const targetTab = button.getAttribute('data-tab');

      // Remover estado activo de todos los botones
      buttons.forEach(btn => {
        btn.classList.remove('text-blue-600', 'border-blue-500');
        btn.classList.add('text-gray-500', 'border-transparent');
      });

      // Ocultar todos los contenidos
      contents.forEach(content => {
        content.classList.add('hidden');
        content.classList.remove('active');
      });

      // Activar el botón seleccionado
      button.classList.remove('text-gray-500', 'border-transparent');
      button.classList.add('text-blue-600', 'border-blue-500');

      // Mostrar el contenido seleccionado
      const targetContent = document.getElementById(targetTab);
      targetContent.classList.remove('hidden');
      targetContent.classList.add('active');
    });
  });
});

// Función para editar vacante usando el ID
function editVacante(vacanteId) {
    // Buscar el botón que tiene el data-vacante-id correspondiente
    const editButton = document.querySelector(`button[data-vacante-id="${vacanteId}"]`);

    if (!editButton) {
        alert('No se pudo encontrar la información de la vacante');
        return;
    }

    // Extraer todos los datos del botón
    const vacanteData = {
        id: vacanteId,
        company_id: editButton.dataset.companyId || '',
        departamento_id: editButton.dataset.departamentoId || '',
        puesto_id: editButton.dataset.puestoId || '',
        solicitadas: editButton.dataset.solicitadas || '',
        completadas: editButton.dataset.completadas || '',
        prioridad: editButton.dataset.prioridad || 'Media',
        jefe: editButton.dataset.jefe || '',
        area_id: editButton.dataset.areaId || '',
        nivel: editButton.dataset.nivel || '',
        fecha: editButton.dataset.fecha || ''
    };

    console.log('Datos de la vacante:', vacanteData); // Para debug

    // Abrir el modal con los datos
    openEditModal(vacanteData);
}

// Variables globales para el modal de edición
let currentVacanteId = null;
let deleteForm = null;

// Funciones del modal de edición
function openEditModal(vacanteData) {
    currentVacanteId = vacanteData.id;

    // Configurar la acción del formulario
    document.getElementById('editVacanteForm').action = `/vacantes/${vacanteData.id}`;

    // Rellenar los campos del formulario
    document.getElementById('edit_company_id').value = vacanteData.company_id || '';
    document.getElementById('edit_departamento_id').value = vacanteData.departamento_id || '';
    document.getElementById('edit_puesto_id').value = vacanteData.puesto_id || '';
    document.getElementById('edit_solicitadas').value = vacanteData.solicitadas || '';
    document.getElementById('edit_completadas').value = vacanteData.completadas || '';
    document.getElementById('edit_prioridad').value = vacanteData.prioridad || 'Media';
    document.getElementById('edit_jefe').value = vacanteData.jefe || '';
    document.getElementById('edit_area_id').value = vacanteData.area_id || '';
    document.getElementById('edit_nivel').value = vacanteData.nivel || '';
    document.getElementById('edit_fecha').value = vacanteData.fecha || '';

    // Mostrar el modal
    document.getElementById('editVacantesModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeEditModal() {
    document.getElementById('editVacantesModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    currentVacanteId = null;
}

// Función para manejar la eliminación
function deleteVacante() {
    if (!currentVacanteId) return;

    // Crear formulario de eliminación dinámicamente
    deleteForm = document.createElement('form');
    deleteForm.method = 'POST';
    deleteForm.action = `/vacantes/${currentVacanteId}`;

    // Agregar token CSRF
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Agregar método DELETE
    const methodInput = document.createElement('input');
    methodInput.type = 'hidden';
    methodInput.name = '_method';
    methodInput.value = 'DELETE';

    deleteForm.appendChild(csrfInput);
    deleteForm.appendChild(methodInput);

    // Mostrar modal de confirmación
    document.getElementById('deleteConfirmModal').classList.remove('hidden');
}

function closeDeleteConfirmModal() {
    document.getElementById('deleteConfirmModal').classList.add('hidden');
    deleteForm = null;
}

function confirmDelete() {
    if (deleteForm) {
        document.body.appendChild(deleteForm);
        deleteForm.submit();
    }
    closeDeleteConfirmModal();
    closeEditModal();
}

// Cerrar modales al hacer click fuera de ellos
document.getElementById('editVacantesModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModal();
    }
});

document.getElementById('deleteConfirmModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteConfirmModal();
    }
});

// Cerrar modales con tecla ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        if (!document.getElementById('deleteConfirmModal').classList.contains('hidden')) {
            closeDeleteConfirmModal();
        } else if (!document.getElementById('editVacantesModal').classList.contains('hidden')) {
            closeEditModal();
        }
    }
});

// Funciones del modal
function openModal() {
  document.getElementById('vacantesModal').classList.remove('hidden');
  document.body.style.overflow = 'hidden'; // Prevenir scroll del body
}

function closeModal() {
  document.getElementById('vacantesModal').classList.add('hidden');
  document.body.style.overflow = 'auto'; // Restaurar scroll del body
}

function closeEditModal() {
    document.getElementById('editVacantesModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    currentVacanteId = null;
}

// Función para manejar la eliminación
function deleteVacante() {
    if (!currentVacanteId) return;

    // Crear formulario de eliminación dinámicamente
    deleteForm = document.createElement('form');
    deleteForm.method = 'POST';
    deleteForm.action = `/vacantes/${currentVacanteId}`;

    // Agregar token CSRF
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Agregar método DELETE
    const methodInput = document.createElement('input');
    methodInput.type = 'hidden';
    methodInput.name = '_method';
    methodInput.value = 'DELETE';

    deleteForm.appendChild(csrfInput);
    deleteForm.appendChild(methodInput);

    // Mostrar modal de confirmación
    document.getElementById('deleteConfirmModal').classList.remove('hidden');
}

function closeDeleteConfirmModal() {
    document.getElementById('deleteConfirmModal').classList.add('hidden');
    deleteForm = null;
}

function confirmDelete() {
    if (deleteForm) {
        document.body.appendChild(deleteForm);
        deleteForm.submit();
    }
    closeDeleteConfirmModal();
    closeEditModal();
}

// Cerrar modales al hacer click fuera de ellos
document.getElementById('editVacantesModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModal();
    }
});

document.getElementById('deleteConfirmModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteConfirmModal();
    }
});

// Cerrar modal al hacer click fuera de él
document.getElementById('vacantesModal').addEventListener('click', function(e) {
  if (e.target === this) {
    closeModal();
  }
});

// Cerrar modales con tecla ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        if (!document.getElementById('deleteConfirmModal').classList.contains('hidden')) {
            closeDeleteConfirmModal();
        } else if (!document.getElementById('editVacantesModal').classList.contains('hidden')) {
            closeEditModal();
        }
    }
});




</script>
@endsection
