@extends('layouts.app')

@section('links')
	@parent
	<link rel="stylesheet" href="{{ asset('summernote/summernote.css') }}">
@endsection

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading">Úprava otázky #{{ $question->id }}</div>

					<div class="panel-body">

						{!! Form::open(['route' => ['questions.update', $question->id], 'method' => 'post']) !!}

						{{-- Question Field --}}
						<div class="form-group">
						    <strong>{{ $question->content }}</strong>
						</div>


						{{--  Field --}}
						<div class="form-group">
						    {!! Form::textarea('answer', $question->answer != null ? $question->answer->content : null, [
						        'class' => 'form-control',
						        'id' => 'answer'
						    ]) !!}
						</div>


						{{-- Odoslať odpoveď Submit --}}
						<div class="form-group">
						    {!! Form::submit('odoslať odpoveď', [
						        'class' => 'btn btn-primary btn-block'
						    ]) !!}
						</div>

						{!! Form::close() !!}

					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	@parent
	<script src="{{ asset("summernote/summernote.min.js") }}" type="text/javascript"></script>

	<script>

		$(document).ready(function() {
			$('#answer').summernote({
				minHeight: 400
			});
		});

	</script>

@endsection