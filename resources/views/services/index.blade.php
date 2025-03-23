@extends('adminlte::page')

@vite ('resources/css/app.css')
@vite('resources/js/app.js')
@vite('resources/js/echo.js')



@section('content_header')
    <h1>Servicios</h1>
  <!-- Button trigger modal -->
<div class="text-right">
    @role('admin')
    <button type="button" class="col-2.5 px-4 py-2 bg-cyan-600 text-white rounded-md hover:bg-cyan-700" data-toggle="modal" data-target="#cargarServicio">
        <i class="fa fa-plus"></i> Agregar Servicio
    </button>
    @endrole
    <button type="button" class="col-2.5 px-4 py-2 bg-cyan-600 text-white rounded-md hover:bg-cyan-700" data-toggle="modal" data-target="#cargarTurno">
        <i class="fa fa-plus"></i> Agendar Turno
    </button>
</div>
@stop

@section('content')
<!-- Contenedor de los servicios -->
<div class="servicios-container flex justify-center align-center flex-wrap">
    @foreach ($services as $service)
        <div class="servicio-content m-2" id="service-{{ $service->service_id }}" onclick="toggleSelection({{ $service->service_id }}, '{{ $service->name }}', '{{ $service->duration }}')">
            <div class="relative flex flex-col my-2 bg-white shadow-sm border border-slate-200 rounded-lg w-80">
                <div class="p-4">
                    <div class="mb-2 flex items-center justify-between">
                        <p class="text-slate-800 text-xl font-semibold editName">{{ ucwords($service->name) }}</p>
                        <p class="text-cyan-600 text-xl font-semibold editPrice">₲{{ number_format($service->price, 0, ',', '.') }}</p>
                    </div>
                    <p class="text-slate-600 leading-normal font-light editDescription">{{ ucwords($service->description) }}</p>
                    <p class="text-slate-800 text-xl font-semibold editDuration">Duración aprox {{ $service->duration }} minutos</p>
                    @role('admin')
                    <button class="rounded-md w-full mt-2 bg-yellow-600 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-yellow-700 focus:shadow-none active:bg-yellow-700 hover:bg-yellow-700 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button" onclick="openEditModal({{ $service->service_id }})">
                        Editar
                    </button>
                    <button class="rounded-md w-full mt-2 bg-red-600 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-red-700 focus:shadow-none active:bg-red-700 hover:bg-red-700 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button" onclick="deleteService({{ $service->service_id }})">
                        Eliminar
                    </button>
                    @endrole
                </div>
            </div>
        </div>
    @endforeach
</div>

@include('services.createService')
@include('services.editService')
@include('services.modalShift')
@stop

@section('css')
<style>
    .servicio-content {
        cursor: pointer;
        transition: transform 0.2s ease-in-out;
    }

    .selected {
        transform: scale(1.03);
       
    }


</style>
@stop


@section('js')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js"></script>
<script src="{{ asset('js/services.js') }}"></script>
<script src="{{ asset('js/appointments.js') }}"></script>
@stop