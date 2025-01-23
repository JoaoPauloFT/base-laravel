@extends('adminlte::page')

@section('plugins.Sweetalert2', true)

@section('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@stop

@section('title', 'Funções')

@section('content_header')
    <div class="title mb-3">
        <h1>Funções</h1>
        <p>Listagem e cadastro de funções de funcionários no sistema</p>
    </div>
    @can('create_role')
        <div class="actions mb-3">
            <a id="createButton" href="#" data-toggle="modal" data-target="#modalForm">
                <i class="fa-solid fa-plus br"></i>
                Cadastrar funções
            </a>
        </div>
    @endcan
@stop

@section('content')
    <div class="body">
        <x-forms.table :dropdownFilter="[]">
            <thead>
            <tr>
                <th>Função</th>
                <th>Descrição</th>
                <th class="center">Atualizado em</th>
                @if (Auth::user()->can('edit_role') || Auth::user()->can('delete_role'))
                    <th class="center">{{ __('message.actions') }}</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach($roles as $r)
                <tr>
                    <td>{{ $r->name }}</td>
                    <td>{{ $r->description }}</td>
                    <td class="center">{{ date('d/m/Y', strtotime($r->updated_at)) }}</td>
                    @if (Auth::user()->can('edit_role') || Auth::user()->can('delete_role'))
                        <td>
                            <div class="divActions">
                                @can('edit_role')
                                    <a href="{!! asset('settings/role/'.$r->id) !!}" class="btnAction">
                                        <i class="fa-solid fa-sliders"></i>
                                    </a>
                                    <a id="editButton{{ $r->id }}" href="#" data-toggle="modal" data-target="#modalForm{{ $r->id }}" class="btnAction">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                    {{ \App\Http\Controllers\RolesController::edit($r->id) }}
                                @endcan
                                @can('delete_role')
                                    <x-forms.delete-button
                                        route="role.delete"
                                        id="{{ $r->id }}"
                                        title="Deseja excluir essa função?"
                                    />
                                @endcan
                            </div>
                        </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </x-forms.table>
    </div>
    @can('create_role')
        {{ \App\Http\Controllers\RolesController::create() }}
    @endcan
@stop
