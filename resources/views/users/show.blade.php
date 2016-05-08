@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading">User #{{ $user->id }}


					</div>

					<div class="panel-body">

						{!! Form::open(['route' => ['users.update', $user->id], 'method' => 'post', 'class' => 'form-horizontal']) !!}

						{{-- First_name Field --}}
						<div class="form-group">
							{!! Form::label('first_name', 'Meno:', ['class' => 'control-label col-sm-2']) !!}
							<div class="col-sm-10">
								{!! Form::text('first_name', $user->first_name, [
									'class' => 'form-control'
								]) !!}
							</div>
						</div>

						{{-- Last_name Field --}}
						<div class="form-group">
							{!! Form::label('last_name', 'Priezvisko:', ['class' => 'control-label col-sm-2']) !!}
							<div class="col-sm-10">
								{!! Form::text('last_name', $user->last_name, [
									'class' => 'form-control'
								]) !!}
							</div>
						</div>

						<div class="form-group">
							{!! Form::label('categories', 'Prístup:', ['class' => 'control-label col-sm-2']) !!}
							<div class="col-sm-10">
								<select name="categories[]" id="categories" multiple class="form-control">
									@foreach($categories as $category)

										<option value="{{ $category->id }}" @if($user->hasCategory($category->id)) selected @endif>{{ $category->name }}</option>

									@endforeach
								</select>
							</div>
						</div>

						{{-- Udpate user Submit --}}
						<div class="form-group">
							<div class="col-sm-offset-2">
								{!! Form::submit('aktualizovať', [
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
