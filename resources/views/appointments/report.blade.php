@extends('adminlte::page')

@section('title', 'Reportes')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">📊 Reporte Mensual</h2>

    <form id="reportForm" class="p-3 shadow rounded bg-light">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="month" class="form-label fw-bold">📅 Seleccionar Mes:</label>
                <select name="month" id="month" class="form-select">
                    @foreach(range(1, 12) as $month)
                    <option value="{{ $month }}" {{ $month == $selectedMonth ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label for="year" class="form-label fw-bold">📆 Seleccionar Año:</label>
                <select name="year" id="year" class="form-select">
                    @for ($year = now()->year; $year >= now()->year - 5; $year--)
                    <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                    @endfor
                </select>
            </div>

            <div class="col-md-4 text-center">
                <button type="submit" class="btn btn-primary w-100 fw-bold">
                    🔍 Ver Reporte
                </button>
            </div>
        </div>
    </form>

    <div id="reportResults" class="row mt-4">
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-lg text-white bg-success">
                <div class="card-header text-center fw-bold">✅ Servicios Confirmados</div>
                <div class="card-body text-center">
                    <h2 class="fw-bold">{{ $confirmedAppointments }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-lg text-white bg-danger">
                <div class="card-header text-center fw-bold">❌ Servicios Cancelados</div>
                <div class="card-body text-center">
                    <h2 class="fw-bold">{{ $canceledAppointments }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-lg text-white bg-primary">
                <div class="card-header text-center fw-bold">💰 Total Recaudado</div>
                <div class="card-body text-center">
                    <h3 class="fw-bold">Gs. {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-lg text-white bg-info">
                <div class="card-header text-center fw-bold">🆕 Clientes Nuevos</div>
                <div class="card-body text-center">
                    <h2 class="fw-bold">{{ $newClients }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#reportForm').submit(function(e) {
            e.preventDefault(); // Evita la recarga de la página

            var month = $('#month').val();
            var year = $('#year').val();

            $.ajax({
                url: "{{ route('appointments.report') }}", // La misma ruta que tu formulario
                type: 'GET',
                data: {
                    month: month,
                    year: year
                },
                success: function(data) {
                    // Actualiza los datos en la sección de resultados
                    $('#reportResults').html(data);
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        });
    });
</script>
@endsection