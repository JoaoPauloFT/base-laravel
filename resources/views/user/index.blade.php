@extends('adminlte::page')

@section('plugins.Sweetalert2', true)

@section('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@stop

@section('title', 'Funcionários')

@section('content_header')
    <div class="title mb-3">
        <h1>Funcionários</h1>
        <p>Listagem e cadastro de funcionários que tem acesso a plataforma web</p>
    </div>
    @can('create_user')
        <div class="actions mb-3">
            <a id="createButton" href="#" data-toggle="modal" data-target="#modalForm">
                <i class="fa-solid fa-plus br"></i>
                Cadastrar funcionários
            </a>
        </div>
    @endcan
@stop

@section('content')
    <div class="body">
        <x-forms.table :dropdownFilter="[2]">
            <thead>
            <tr>
                <th>{{ __('message.name') }}</th>
                <th>{{ __('message.user') }}</th>
                <th>{{ __('message.function') }}</th>
                <th class="center">{{ __('message.date_create') }}</th>
                @if (Auth::user()->can('edit_user') || Auth::user()->can('delete_user'))
                    <th class="center">{{ __('message.actions') }}</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach($users as $u)
                <tr>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->role->name }}</td>
                    <td class="center">{{ date('d/m/Y', strtotime($u->created_at)) }}</td>
                @if (Auth::user()->can('edit_user') || Auth::user()->can('delete_user'))
                        <td>
                            <div class="divActions">
                                @can('edit_user')
                                    <a id="changePassword{{ $u->id }}" href="#" data-toggle="modal" data-target="#changePasswordModal{{ $u->id }}" class="btnAction">
                                        <i class="fa-solid fa-key"></i>
                                    </a>
                                    {{ \App\Http\Controllers\UserController::edit_password($u->id) }}
                                    <a id="editButton{{ $u->id }}" href="#" data-toggle="modal" data-target="#modalForm{{ $u->id }}" class="btnAction">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                    {{ \App\Http\Controllers\UserController::edit($u->id) }}
                                @endcan
                                @can('delete_user')
                                    <x-forms.delete-button
                                        route="user.delete"
                                        id="{{ $u->id }}"
                                        title="Deseja excluir esse funcionário?"
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
    @can('create_user')
        {{ \App\Http\Controllers\UserController::create() }}
    @endcan
@stop
