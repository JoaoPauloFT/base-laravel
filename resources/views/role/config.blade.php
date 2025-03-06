@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/permissions.css') }}">
@stop

@section('title', 'Funções')

@section('content_header')
    <div class="title mb-4">
        <h1>{{ __('message.permissions_of')." ".$role->name }}</h1>
        <p>{{ __('message.permissions_config_description')." ".$role->name }}</p>
    </div>
    @can('create_role')
        <div class="actions mb-4">
            <a id="createButton" href="#">
                <i class="ti ti-device-floppy"></i>
                {{ __('message.save_permission') }}
            </a>
        </div>
    @endcan
@stop

@section('content')
    <div class="body p-3">
        <form id="formPermission" action="{{ route('role.save_permission', $role->id) }}" method="POST">
            @csrf()
            <div class="container-wrapper">
                <div class="card-permission">
                    <h2>{{ __('message.'.$first_view) }}</h2>
                    @foreach($permissions as $p)
                        @if($first_view != $p->view)
                            @php
                                $first_view = $p->view;
                            @endphp
                            </div>
                            <div class="card-permission">
                            <h2>{{ __('message.'.$first_view) }}</h2>
                        @endif
                        <p><input type="checkbox" name="permission[]" value="{{ $p->id }}" {{ $my_permissions->contains($p->code) ? "checked" : "" }}><span>{{ __('message.'.$p->code) }}</span></p>
                    @endforeach
                </div>
            </div>
        </form>
    </div>
    <script>
        document.getElementById('createButton').onclick = function () {
            document.getElementById('formPermission').submit();
        }
    </script>
@stop
