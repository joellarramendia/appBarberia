@extends('adminlte::page')

@section('title', 'Dashboard')

@vite ('resources/css/app.css')
@vite('resources/js/app.js')
@vite('resources/js/echo.js')


@section('content_header')
    @role('admin')
    <h1>Administrador</h1>
    @endrole
    <div class="text-right">
      <a href="{{ url('services/index') }}" class="col-2.5 px-4 py-2 bg-cyan-600 text-white rounded-md hover:bg-cyan-700">
      <i class='fa fa-plus'> </i> Nueva cita
      </a>
    </div>
@stop


@section('content')
    <div id='calendar'></div>
    
    <div class="modal fade" id="mostrarTurno" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="nuevoTurno" aria-hidden="true"> 
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-2xl font-semibold text-gray-800" id="nuevoTurno">Turno Reservado</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body d-flex justify-content-center position-relative ">
                    
                    <div class="flex items-center justify-center p-4">
                        <div class="mx-auto w-full max-w-[550px]">
                            <form>
                                @csrf  
                                <div class="-mx-3 flex flex-wrap">
                                    <div class="w-full px-3 sm:w-1/2">
                                        <div class="mb-5">
                                            <label
                                            for="fName"
                                            class="mb-3 block text-base font-medium text-[#07074D]"
                                            >
                                            Cliente
                                            </label>
                                            <input
                                            type="text"
                                            name="user"
                                            id="user"
                                            placeholder="Cliente"
                                            class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                                            readonly
                                            />
                                        </div>
                                    </div> <!--Cliente-->
        
                                    <div class="w-full px-3 sm:w-1/2">
                                        <div class="mb-5">
                                            <label
                                            for="date"
                                            class="mb-3 block text-base font-medium text-[#07074D]"
                                            >
                                            Fecha
                                            </label>
                                            <input
                                            type="date"
                                            name="date"
                                            id="date"
                                            class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                                            />
                                        </div>
                                    </div> <!--Fecha-->
                                </div>
                            
                                <div class="mb-5">
                                    <label for="selectedServices" class="mb-3 block text-base font-medium text-[#07074D]">
                                        Servicios seleccionados
                                    </label>
                                    <div id="servicio" name="servicio" class="flex flex-wrap gap-2">
                                    </div>
                                </div> <!--Servicios-->
        
                                
                                    
                                <div class="-mx-3 flex flex-wrap">
                                    <div class="w-full px-3 sm:w-1/2">
                                        <div class="mb-5">
                                            <label
                                            for="time"
                                            class="mb-3 block text-base font-medium text-[#07074D]"
                                            >
                                            Hora Inicio
                                            </label>
                                            <input
                                            type="time"
                                            name="hora"
                                            id="hora"
                                            class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                                            />
                                        </div>
                                    </div> <!--Hora Inicio-->
        
                                    <div class="w-full px-3 sm:w-1/2">
                                        <div class="mb-5">
                                            <label
                                            for="time"
                                            class="mb-3 block text-base font-medium text-[#07074D]"
                                            >
                                            Hora Fin
                                            </label>
                                            <input
                                            type="time"
                                            name="horaFin"
                                            id="horaFin"
                                            class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                                            readonly
                                            />
                                        </div>
                                    </div><!--Hora Fin-->
                                </div>
                               
                                <div class="flex justify-center">
                                    @role('admin')
                                    <button type="button" class="btn btn-success me-2" id="btnConfirmar">Confirmar</button>
                                    @endrole
                                    <button type="button" class="btn btn-primary me-2" id="btnReagendar">Reagendar</button>
                                    <button type="button" class="btn btn-danger" id="btnEliminar">Eliminar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    
@stop



@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js"></script>
    <script src="{{asset('js/appointments.js')}}"></script>
@stop