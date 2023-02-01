@extends('layouts.dashboard')
@section('content')
    <!-- Page-header start -->
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h4>Reportes SOS</h4>
                        <span>Reportes de alertas de sos por hora, fecha y responsable</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item" style="float: left;">
                            <a href="index.html"> <i class="feather icon-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item" style="float: left;">
                            Reportes
                        </li>
                        <li class="breadcrumb-item" style="float: left;">
                            <a href="{{ route('sos.report') }}">sos</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Page-header end -->
    
    {{-- Contenedor de cards --}}
    <div class="d-flex justify-content-evenly flex-wrap">
        <!-- customar project  start -->
        {{-- <div class="col-xl-3 col-md-6"> --}}
            <div class="card shadow">
                <div class="card-block">
                    <div class="row align-items-center m-l-0">
                        <div class="col-auto">
                            <i class="fa fa-send-o f-30 text-c-lite-green"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10">Enviadas</h6>
                            <h2 class="m-b-0">20</h2>
                        </div>
                    </div>
                </div>
            </div>
        {{-- </div> --}}
        {{-- <div class="col-xl-3 col-md-6"> --}}
            <div class="card shadow">
                <div class="card-block">
                    <div class="row align-items-center m-l-0">
                        <div class="col-auto">
                            <i class="fa fa-hourglass-1 f-30 text-c-green"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10">Por definir</h6>
                            <h2 class="m-b-0">0</h2>
                        </div>
                    </div>
                </div>
            </div>
        {{-- </div> --}}
        {{-- <div class="col-xl-3 col-md-6"> --}}
            <div class="card shadow">
                <div class="card-block">
                    <div class="row align-items-center m-l-0">
                        <div class="col-auto">
                            <i class="fa fa-hourglass-1 f-30 text-c-green"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10">Por definir</h6>
                            <h2 class="m-b-0">0</h2>
                        </div>
                    </div>
                </div>
            </div>
        {{-- </div> --}}
        {{-- <div class="col-xl-3 col-md-6"> --}}
            <div class="card shadow">
                <div class="card-block">
                    <div class="row align-items-center m-l-0">
                        <div class="col-auto">
                            <i class="fa fa-hourglass-1 f-30 text-c-green"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10">Por definir</h6>
                            <h2 class="m-b-0">0</h2>
                        </div>
                    </div>
                </div>
            </div>
        {{-- </div> --}}
        <!-- customar project  end -->
    </div>
    <hr>
    <div class="card shadow">
        <div class="page-header-title mt-2 mb-3">
            <div class="d-inline">
                <h4>SOS hechos</h4>
            </div>
        </div>
        {{-- Table --}}
        <table id="table" class="table">
            <caption>Tabla de sos hechos</caption>
            <thead>
                <tr>
                    <th>Responsable</th>
                    <th>Fecha/hora</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sos as $item)
                    <tr>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>
                            @if ($item->checked == true)
                                Atendida
                            @else
                            <span class="visually-hidden">No atendida</span>
                                <form action="{{ route('sos.checked') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                    <button class="btn btn-success" type="submit">Atender</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{-- End table --}}
    </div>

    <script>
        window.onload = () =>{ 
            table = $('#table').DataTable({
                dom: 'Bfrtip',
                stateSave: true,
                pagingType: 'full_numbers',
                // scrollY: '200px',
                // scrollCollapse: true,
                language: {
                    lengthMenu: 'Mostrando _MENU_ filas por página',
                    zeroRecords: 'Nada que mostrar',
                    info: 'Página #_PAGE_ de _PAGES_',
                    infoEmpty: 'No hay coincidencias',
                    search: 'Buscar',
                    infoFiltered: '(Filtrado de _MAX_ registros)',
                },
                buttons: [
                    // 'copy',
                    // {
                    //     extend: 'copy',
                    //     exportOptions: {
                    //         columns: ':visible'
                    //     }
                    // },
                    // 'excel',
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    // 'pdf',
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    // 'print',
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    'colvis',
                ],
                columnDefs: [ {
                    // targets: -1,
                    visible: false,
                } ]
            });   
        }
    </script>
@endsection
