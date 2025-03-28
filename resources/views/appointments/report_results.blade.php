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