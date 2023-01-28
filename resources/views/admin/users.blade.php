@extends('layouts.dashboard')
@section('content')
    <!-- Page-header start -->
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h4>Control de usuarios</h4>
                        <span>Panel para control de accesos de los usuarios</span>
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
                            Mantenimiento
                        </li>
                        <li class="breadcrumb-item" style="float: left;">
                            <a href="{{ route('users.index') }}">usuarios</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Page-header end -->    
    <div class="card shadow">
        {{-- Add --}}
        <a href="{{route('users.create')}}" class="btn border-info m-3">Agregar</a>
        <div class="row align-items-center p-3 justify-content-center">
            {{-- Table --}}
            <div data-aos="fade-right" data-aos-delay="500" class="table-responsive text-light">
                <table id="table" class="table">
                    <caption>Tabla de usuarios</caption>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td class="d-flex text-center">
                                    <a class="btn btn-warning btn-sm" href="{{ route('users.edit', ['user'=> $user->id]) }}">Editar</a>
                                    <form action="{{route("users.destroy", ["user" => $user->id])}}" method="post"> 
                                        @csrf
                                        @method("DELETE")
                                        {{-- <a href="{{route("users.edit", ['user'=>$user->id])}}" class="btn btn-warning btn-sm">Editar</a> --}}
                                        <input class="btn btn-danger btn-sm" type="submit" value="Eliminar"> 
                                    </form>
                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        var table;
        $(document).ready( function () {
            $('#table').DataTable({
                stateSave: true,
                pagingType: 'full_numbers',
                lengthChange: false,
                pageLength: 10,
                language: {
                    lengthMenu: 'Mostrando _MENU_ filas por página',
                    zeroRecords: 'Nada que mostrar',
                    info: 'Página #_PAGE_ de _PAGES_',
                    infoEmpty: 'No hay coincidencias',
                    search: 'Buscar',
                    infoFiltered: '(Filtrado de _MAX_ registros)',
                }
            });
        } );
    </script>
@endsection