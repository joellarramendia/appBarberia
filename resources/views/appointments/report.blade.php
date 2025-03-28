@extends('adminlte::page')

@section('title', 'Reportes')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">📊 Reportes</h2>

    <div class="text-center mb-3">
        <button id="monthlyReportBtn" class="btn btn-primary active">Reporte Mensual</button>
        <button id="annualReportBtn" class="btn btn-secondary">Reporte Anual</button>
    </div>

    <form id="reportForm" class="p-3 shadow rounded bg-light">
        <div class="row g-3 align-items-end" id="monthlyFields">
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
        </div>

        <div class="row g-3 align-items-end" id="annualFields" style="display: none;">
        </div>

        <div class="row g-3 align-items-end">
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
        </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        let reportType = 'monthly'; // Inicialmente, el tipo de reporte es mensual

        $('#monthlyReportBtn').click(function() {
            reportType = 'monthly';
            $('#monthlyReportBtn').addClass('active').removeClass('secondary');
            $('#annualReportBtn').addClass('secondary').removeClass('active');
            $('#monthlyFields').show();
            $('#annualFields').hide();
        });

        $('#annualReportBtn').click(function() {
            reportType = 'annual';
            $('#annualReportBtn').addClass('active').removeClass('secondary');
            $('#monthlyReportBtn').addClass('secondary').removeClass('active');
            $('#monthlyFields').hide();
            $('#annualFields').show();
        });

        $('#reportForm').submit(function(e) {
            e.preventDefault();

            let url = "{{ route('appointments.report') }}";
            let data = {
                year: $('#year').val()
            };

            if (reportType === 'monthly') {
                data.month = $('#month').val();
            }

            $.ajax({
                url: url,
                type: 'GET',
                data: data,
                success: function(data) {
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