@extends('adminlte::page')

@vite ('resources/css/app.css')

@section('content_header')
    <h1>Listado de Servicios</h1>
  <!-- Button trigger modal -->
<div class="text-right">
    <button type="button" class="btn btn-success col-2.5" data-toggle="modal" data-target="#cargarServicio">
        <i class="fa fa-plus"></i> Nuevo Servicio
    </button>

    <!-- Modal Nueva Cita -->
    <div class="modal fade" id="cargarServicio" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="nuevaServicio" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevoServicio">Nuevo Servicio</h5>
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-left" for="name">Nombre del Servicio</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price">Precio del Servicio</label>
                                    <input type="number" class="form-control" id="price" name="price" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description">Descripción del Servicio</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="duration">Duración del Servicio (en minutos)</label>
                                    <input type="number" class="form-control" id="duration" name="duration" step="0.01" required>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="btnCancelar" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="submitForm()">Guardar Servicio</button>
                </div>
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
                        <p class="text-cyan-600 text-xl font-semibold">${{ $service->price }}</p>
                    </div>
                    <p class="text-slate-600 leading-normal font-light">{{ $service->description }}</p>
                    <p class="text-slate-800 text-xl font-semibold">Duracion aprox {{$service->duration}} minutos</p>
                    <button class="rounded-md w-full mt-6 bg-cyan-600 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-cyan-700 focus:shadow-none active:bg-cyan-700 hover:bg-cyan-700 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button">
                        Add to Cart
                    </button>
                    <button class="rounded-md w-full mt-2 bg-red-600 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-red-700 focus:shadow-none active:bg-red-700 hover:bg-red-700 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button" onclick="deleteService({{ $service->service_id }})">
                        Eliminar
                    </button>
                    <button class="rounded-md w-full mt-2 bg-yellow-600 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-yellow-700 focus:shadow-none active:bg-yellow-700 hover:bg-yellow-700 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button" onclick="openEditModal({{ $service->service_id }})">
                        Editar
                    </button>
                </div>
            </div>
        </div>
    @endforeach
</div>

@include('services.editService')
@stop


@section('js')
<script src="{{ asset('js/services.js') }}"></script>
@stop

@section('css')
@stop
