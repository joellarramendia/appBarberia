@extends('adminlte::page')

@vite('resources/css/app.css')
@vite('resources/js/app.js')

@section('title', 'Clientes Registrados')

@section('content_header')
    <h2 class="text-3xl font-semibold text-blue-600 flex items-center pb-2">
        <i class="fas fa-users mr-3"></i> Clientes Registrados
    </h2>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table id="users-table" class="table table-bordered table-striped table-hover shadow-lg rounded-lg w-full">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Registrado en</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800">
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
    <style>
        /* Estilos personalizados para la tabla */
        .dataTables_wrapper {
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        #users-table {
            border-radius: 8px;
        }
        #users-table thead {
            background-color: #1D4ED8; /* Azul oscuro */
        }
        #users-table th, #users-table td {
            padding: 12px 15px;
            text-align: left;
        }
        #users-table tr:hover {
            background-color: #F3F4F6; /* Gris claro al pasar el mouse */
        }
        #users-table th {
            font-weight: bold;
            text-transform: uppercase;
        }
    </style>
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('appointments.registeredClients') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data, type, row) {
                            return moment(data).format('DD/MM/YYYY');
                        }
                    }
                ],
                responsive: true,
                language: {
                    sProcessing:     "Procesando...",
                    sLengthMenu:     "Mostrar _MENU_ registros",
                    sZeroRecords:    "No se encontraron resultados",
                    sEmptyTable:     "Ningún dato disponible en esta tabla",
                    sInfo:           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    sInfoEmpty:      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    sInfoFiltered:   "(filtrado de un total de _MAX_ registros)",
                    sSearch:         "Buscar:",
                    sInfoThousands:  ",",
                    sLoadingRecords: "Cargando...",
                    oPaginate: {
                        sFirst:    "Primero",
                        sLast:     "Último",
                        sNext:     "Siguiente",
                        sPrevious: "Anterior"
                    },
                    oAria: {
                        sSortAscending:  ": Activar para ordenar la columna de manera ascendente",
                        sSortDescending: ": Activar para ordenar la columna de manera descendente"
                    }
                }
            });
        });
    </script>
@stop
