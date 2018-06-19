@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    @if ($alarmeAtivo)
                        <h2>Alarme ativo!</h2>
                        {{-- <a href="{{config('arduino').'/desativar'}}" class="btn btn-danger">Desativar alarme</a> --}}
                        <a href="{{route('desativar')}}?token={{config('app.token')}}" class="btn btn-danger">Desativar alarme</a>
                    @else
                        <h2>Alarme inativo!</h2>
                        <a href="{{route('ativar')}}?token={{config('app.token')}}" class="btn btn-success">Ativar alarme</a>
                        {{-- <a href="{{config('arduino').'/ativar'}}" class="btn btn-success">Ativar alarme</a> --}}
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
