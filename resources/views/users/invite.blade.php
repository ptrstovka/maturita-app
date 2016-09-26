@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Invite user


                    </div>

                    <div class="panel-body">

                        {!! Form::open(['route' => 'users.invite', 'method' => 'post', 'class' => 'form-horizontal']) !!}

                        {{-- Email Field --}}
                        <div class="form-group">
                            {!! Form::label('email', 'E-Mail Address:', ['class' => 'control-label col-sm-4']) !!}
                            <div class="col-sm-4">
                                {!! Form::email('email', old('email'), [
                                    'class' => 'form-control'
                                ]) !!}
                            </div>
                        </div>

                        {{-- Invite Submit --}}
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-4">
                                {!! Form::submit('invite', [
                                    'class' => 'btn btn-primary'
                                ]) !!}
                            </div>
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--<div class="container">--}}
    {{--<div class="row">--}}
    {{--<div class="col-md-10 col-md-offset-1">--}}
    {{--<div class="panel panel-default">--}}
    {{--<div class="panel-heading">Aktivácia--}}


    {{--</div>--}}

    {{--<div class="panel-body">--}}


    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}

@endsection
