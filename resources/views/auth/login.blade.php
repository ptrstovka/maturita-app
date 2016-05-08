@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">Login</div>
					<div class="panel-body">

						{!! Form::open(['url' => 'login', 'method' => 'post', 'class' => 'form-horizontal']) !!}

						{{--  Field --}}
						<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
							{!! Form::label('email', 'Email:', ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::email('email', old('email'), [
									'class' => 'form-control'
								]) !!}
							</div>
						</div>

						{{-- Password Field --}}
						<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
							{!! Form::label('password', 'Heslo:', ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::password('password', [
									'class' => 'form-control'
								]) !!}
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<label class="checkbox">
									{!! Form::checkbox('remember', '1', null) !!}
									zapamätať
								</label>
							</div>
						</div>

						{{-- Login Submit --}}
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
							    {!! Form::submit('Login', [
							        'class' => 'btn btn-primary'
							    ]) !!}
								<a class="btn btn-link" href="{{ url('/password/reset') }}">zabudol som heslo</a>
							</div>
						</div>


						{!! Form::close() !!}

				</div>
			</div>
		</div>
	</div>
	</div>
@endsection
