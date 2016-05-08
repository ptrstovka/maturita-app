@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">Registrácia</div>
					<div class="panel-body">

						{!! Form::open(['route' => 'user.create', 'method' => 'post', 'class' => 'form-horizontal']) !!}

						<div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
							{{--  Field --}}
							{!! Form::label('first_name', 'Meno:', ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::text('first_name', old('first_name'), [
									'class' => 'form-control'
								]) !!}
								@if ($errors->has('first_name'))
									<span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
							{{--  Field --}}
							{!! Form::label('last_name', 'Priezvisko:', ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::text('last_name', old('last_name'), [
									'class' => 'form-control'
								]) !!}
								@if ($errors->has('last_name'))
									<span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
							{{--  Field --}}
							{!! Form::label('email', 'Email:', ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::email('email', old('email'), [
									'class' => 'form-control'
								]) !!}
								@if ($errors->has('email'))
									<span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
							{{--  Field --}}
							{!! Form::label('password', 'Heslo:', ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::password('password', [
									'class' => 'form-control'
								]) !!}
								@if ($errors->has('password'))
									<span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
							{{--  Field --}}
							{!! Form::label('password_confirmation', 'Heslo znovu:', ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::password('password_confirmation', [
									'class' => 'form-control'
								]) !!}
								@if ($errors->has('password_confirmation'))
									<span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
								@endif
							</div>
						</div>


						{{-- Registrovať Submit --}}
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								{!! Form::submit('Registrovať', [
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
@endsection
