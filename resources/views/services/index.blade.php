@extends('adminlte::page')

@vite ('resources/css/app.css')
@vite('resources/js/app.js')
@vite('resources/js/services.js')


@section('content_header')
    <h1>Listado de Servicios</h1>
  <!-- Button trigger modal -->
<div class="text-right">
    <button type="button" class="col-2.5 px-4 py-2 bg-cyan-600 text-white rounded-md hover:bg-cyan-700" data-toggle="modal" data-target="#cargarServicio">
        <i class="fa fa-plus"></i> Agregar Servicio
    </button>
</div>

    <!-- Modal Nueva Cita -->
    <div class="modal fade" id="cargarServicio" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="nuevaServicio" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-2xl font-semibold text-gray-800" id="nuevoServicio">Agregar Nuevo Servicio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body d-flex justify-content-center position-relative">
                    <!-- Spinner de carga -->
                    <div class="position-absolute justify-content-center" style="top: 50%; left: 50%; z-index: 5; display:none;" id="cargando">
                        <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>

                    <!-- Formulario para nuevo servicio -->
                    <form id="serviceForm" class="w-100">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nombre del Servicio</label>
                                <input type="text" id="name" name="name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-cyan-500 focus:border-cyan-500 sm:text-sm" required>
                            </div>
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700">Precio del Servicio</label>
                                <input type="number" id="price" name="price" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-cyan-500 focus:border-cyan-500 sm:text-sm" required>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Descripción del Servicio</label>
                                <textarea id="description" name="description" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-cyan-500 focus:border-cyan-500 sm:text-sm" required></textarea>
                            </div>
                            <div>
                                <label for="duration" class="block text-sm font-medium text-gray-700">Duración del Servicio (en minutos)</label>
                                <input type="number" id="duration" name="duration" step="0.01" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-cyan-500 focus:border-cyan-500 sm:text-sm" required>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end space-x-4">
                            <button type="button" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300" id="btnCancelar" data-dismiss="modal">
                                Cancelar
                            </button>
                            <button type="button" onclick="submitForm()" class="px-4 py-2 bg-cyan-600 text-white rounded-md hover:bg-cyan-700">
                                Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



@stop

@section('content')
<!-- Contenedor de los servicios -->
<div class="servicios-container flex justify-center align-center flex-wrap" >
    @foreach ($services as $service)
        <div class="servicio-content" id="service-{{ $service->service_id }}">
            <div class="relative flex flex-col my-6 bg-white shadow-sm border border-slate-200 rounded-lg w-80">
                <div class="p-4">
                    <div class="mb-2 flex items-center justify-between">
                        <p class="text-slate-800 text-xl font-semibold">{{ $service->name }}</p>
                        <p class="text-cyan-600 text-xl font-semibold">₲{{ number_format($service->price, 0, ',', '.') }}</p>
                    </div>
                    <p class="text-slate-600 leading-normal font-light">{{ $service->description }}</p>
                    <p class="text-slate-800 text-xl font-semibold">Duracion aprox {{$service->duration}} minutos</p>
                    <button class="rounded-md w-full mt-2 bg-yellow-600 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-yellow-700 focus:shadow-none active:bg-yellow-700 hover:bg-yellow-700 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button" onclick="openEditModal({{ $service->service_id }})">
                        Editar
                    </button>
                    <button class="rounded-md w-full mt-2 bg-red-600 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-red-700 focus:shadow-none active:bg-red-700 hover:bg-red-700 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button" onclick="deleteService({{ $service->service_id }})">
                        Eliminar
                    </button>
                </div>
            </div>
        </div>
    @endforeach 
</div>

@include('services.editService')
@stop


@section('js')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="{{ asset('js/services.js') }}"></script>
@stop

@section('css')
@stop
