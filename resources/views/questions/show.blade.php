@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading">Otázka #{{ $question->id }}</div>

					<div class="panel-body">

						<strong>{{ $question->content }}</strong>

						<hr>
						<div class="row">
							<div class="col-sm-12">
								{!!  $question->getAnswerText() !!}
							</div>
						</div>

						<hr>

						@if($question->isSolved())
							<div class="form-group">
								<a class="btn btn-xs btn-warning" href="{{ $question->getEditUrl() }}">upraviť
									odpoveď</a>
								@if(Auth::user()->isVerified())
									<a class="btn btn-xs btn-success" href="{{ route('questions.all', $question->category_id) }}">späť všetky
										otázky</a>
								@else
									<a class="btn btn-xs btn-success" href="{{ route('questions.user', $question->category_id) }}">späť na moje
										otázky</a>
								@endif
							</div>

							<p>Naposledy upravil <a>{{ $question->answer->user->fullName() }}</a>
								dňa {{ $question->answer->updated_at }}.</p>

						@endif

					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
