@extends('adminlte::page')

@section('plugins.Sweetalert2', true)

@section('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@stop

@section('title', __('message.manage_roles'))

@section('content_header')
    <div class="title mb-4">
        <h1>{{ __('message.manage_roles') }}</h1>
        <p>{{ __('message.manage_roles_description') }}</p>
    </div>
    @can('create_role')
        <div class="actions mb-4">
            <a id="createButton" href="#" data-toggle="modal" data-target="#modalForm">
                <i class="ti ti-library-plus"></i>
                {{ __('message.add_roles') }}
            </a>
        </div>
    @endcan
@stop

@section('content')
    <div class="body">
        <x-forms.table>
            <thead>
            <tr>
                <th>{{ __('message.function') }}</th>
                <th>{{ __('message.description') }}</th>
                <th class="center">{{ __('message.updated_at') }}</th>
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
                                        <i class="ti ti-adjustments-alt"></i>
                                    </a>
                                    <a id="editButton{{ $r->id }}" href="#" data-toggle="modal" data-target="#modalForm{{ $r->id }}" class="btnAction">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                    {{ \App\Http\Controllers\RolesController::edit($r->id) }}
                                @endcan
                                @can('delete_role')
                                    <x-forms.delete-button
                                        route="role.delete"
                                        id="{{ $r->id }}"
                                        title="{{ __('message.title_delete_role') }}"
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
