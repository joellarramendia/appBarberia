@extends('adminlte::page')

@vite ('resources/css/app.css')


@section('content_header')
    <h1>Hola</h1>
     <!-- Button trigger modal -->
    <div class="text-right">
        <button type="button" class="btn btn-success col-2.5" data-toggle="modal" data-target="#cargarCita">
            <i class='fa fa-plus'> </i> Nuevo Servicio
        </button>
    </div>
@stop

@section('content')
<div class="servicios-container flex justify-center align-center flex-wrap">
    <div class="servicio-content">
        <div class="relative flex flex-col my-6 bg-white shadow-sm border border-slate-200 rounded-lg w-80">
            <div class="relative p-2.5 h-40 overflow-hidden rounded-xl bg-clip-border">
                <img
                src="{{ asset('img/prueba.jpg') }}"
                alt="card-image"
                class="h-full w-full object-cover rounded-md"
                />
            </div>
            <div class="p-4">
                <div class="mb-2 flex items-center justify-between">
                <p class="text-slate-800 text-xl font-semibold">
                    Apple AirPods
                </p>
                <p class="text-cyan-600 text-xl font-semibold">
                    $10.000
                </p>
                </div>
                <p class="text-slate-600 leading-normal font-light">
                With plenty of talk and listen time, voice-activated Siri access, and
                an available wireless charging case.
                </p>
                <button class="rounded-md w-full mt-6 bg-cyan-600 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-cyan-700 focus:shadow-none active:bg-cyan-700 hover:bg-cyan-700 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button">
                Add to Cart
                </button>
            </div>
        </div>
    </div>

    <div class="servicio-content">
        <div class="relative flex flex-col my-6 bg-white shadow-sm border border-slate-200 rounded-lg w-80">
            <div class="relative p-2.5 h-40 overflow-hidden rounded-xl bg-clip-border">
                <img
                src="{{ asset('img/1.jpg') }}"
                alt="card-image"
                class="h-full w-full object-cover rounded-md"
                />
            </div>
            <div class="p-4">
                <div class="mb-2 flex items-center justify-between">
                <p class="text-slate-800 text-xl font-semibold">
                    Afeitado clasico
                </p>
                <p class="text-cyan-600 text-xl font-semibold">
                    $95.00
                </p>
                </div>
                <p class="text-slate-600 leading-normal font-light">
                With plenty of talk and listen time, voice-activated Siri access, and
                an available wireless charging case.
                </p>
                <button class="rounded-md w-full mt-6 bg-cyan-600 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-cyan-700 focus:shadow-none active:bg-cyan-700 hover:bg-cyan-700 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button">
                Add to Cart
                </button>
            </div>
        </div>
    </div>

    <div class="servicio-content">
        <div class="relative flex flex-col my-6 bg-white shadow-sm border border-slate-200 rounded-lg w-80">
        <div class="relative p-2.5 h-40 overflow-hidden rounded-xl bg-clip-border">
            <img
            src="https://images.unsplash.com/photo-1629367494173-c78a56567877?ixlib=rb-4.0.3&amp;ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;auto=format&amp;fit=crop&amp;w=927&amp;q=80"
            alt="card-image"
            class="h-full w-full object-cover rounded-md"
            />
        </div>
        <div class="p-4">
            <div class="mb-2 flex items-center justify-between">
            <p class="text-slate-800 text-xl font-semibold">
                Apple AirPods
            </p>
            <p class="text-cyan-600 text-xl font-semibold">
                $95.00
            </p>
            </div>
            <p class="text-slate-600 leading-normal font-light">
            With plenty of talk and listen time, voice-activated Siri access, and
            an available wireless charging case.
            </p>
            <button class="rounded-md w-full mt-6 bg-cyan-600 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-cyan-700 focus:shadow-none active:bg-cyan-700 hover:bg-cyan-700 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button">
            Add to Cart
            </button>
        </div>
        </div>
    </div>

    <div class="servicio-content">
        <div class="relative flex flex-col my-6 bg-white shadow-sm border border-slate-200 rounded-lg w-80">
        <div class="relative p-2.5 h-40 overflow-hidden rounded-xl bg-clip-border">
            <img
            src="https://images.unsplash.com/photo-1629367494173-c78a56567877?ixlib=rb-4.0.3&amp;ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;auto=format&amp;fit=crop&amp;w=927&amp;q=80"
            alt="card-image"
            class="h-full w-full object-cover rounded-md"
            />
        </div>
        <div class="p-4">
            <div class="mb-2 flex items-center justify-between">
            <p class="text-slate-800 text-xl font-semibold">
                Apple AirPods
            </p>
            <p class="text-cyan-600 text-xl font-semibold">
                $95.00
            </p>
            </div>
            <p class="text-slate-600 leading-normal font-light">
            With plenty of talk and listen time, voice-activated Siri access, and
            an available wireless charging case.
            </p>
            <button class="rounded-md w-full mt-6 bg-cyan-600 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-cyan-700 focus:shadow-none active:bg-cyan-700 hover:bg-cyan-700 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button">
            Add to Cart
            </button>
        </div>
        </div>
    </div>

    
@stop

