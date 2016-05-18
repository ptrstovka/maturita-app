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
					<div class="panel-heading">Subcontent for question #{{ $question->id }}</div>

					<div class="panel-body">

						{!! Form::open(['route' => ['questions.update.subcontent', $question->id], 'method' => 'post']) !!}


						<strong>{{ $question->content }}</strong>



						{{--  Field --}}
						<div class="form-group">
						    {!! Form::textarea('subcontent', $question->subcontent, [
						        'class' => 'form-control',
						        'id' => 'answer'
						    ]) !!}
						</div>


						{{-- Odoslať odpoveď Submit --}}
						<div class="form-group">
						    {!! Form::submit('save subcontent', [
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