@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Change password</div>

                    <div class="panel-body">

                        {!! Form::open(['route' => 'users.password', 'method' => 'post', 'class' => 'form-horizontal']) !!}

                        {{-- Password Field --}}
                        <div class="form-group">
                            {!! Form::label('password', 'Password:', ['class' => 'control-label col-sm-4']) !!}
                            <div class="col-sm-4">
                                {!! Form::password('password', [
                                    'class' => 'form-control'
                                ]) !!}
                            </div>
                        </div>

                        {{-- Password_confirmation Field --}}
                        <div class="form-group">
                            {!! Form::label('password_confirmation', 'Password confirmation:', ['class' => 'control-label col-sm-4']) !!}
                            <div class="col-sm-4">
                                {!! Form::password('password_confirmation', [
                                    'class' => 'form-control'
                                ]) !!}
                            </div>
                        </div>

                        {{-- change pass Submit --}}
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-4">
                                {!! Form::submit('change', [
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
