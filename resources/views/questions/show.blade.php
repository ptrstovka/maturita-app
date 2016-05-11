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
					<div class="panel-heading">
						<span>Otázka #{{ $question->id }}</span>
						@if(Auth::user()->isVerified())
							@if($next != 0)
								<a href="{{ route('questions.show', $next) }}"
								   class="btn btn-default btn-xs pull-right">ďalšia</a>
							@endif
							@if($prev != 0)
								<a href="{{ route('questions.show', $prev) }}"
								   class="btn btn-default btn-xs pull-right">predchádzajúca</a>
							@endif
						@endif
					</div>

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
									<a class="btn btn-xs btn-default"
									   href="{{ route('questions.all', $question->category_id) }}">späť všetky
										otázky</a>
								@else
									<a class="btn btn-xs btn-default"
									   href="{{ route('questions.user', $question->category_id) }}">späť na moje
										otázky</a>
								@endif
								@if(Auth::user()->isAdmin())
									<hr>
									<div class="btn-group">
										<a href="{{ route('questions.update.status', [$question->id, 0]) }}"
										   class="btn btn-xs @if($question->status == 0) btn-success @else btn-default @endif">nevypracovaná</a>
										<a href="{{ route('questions.update.status', [$question->id, 2]) }}"
										   class="btn btn-xs @if($question->status == 2) btn-success @else btn-default @endif">spracovaná</a>
										<a href="{{ route('questions.update.status', [$question->id, 1]) }}"
										   class="btn btn-xs @if($question->status == 1) btn-success @else btn-default @endif">čaká</a>
										<a href="{{ route('questions.update.status', [$question->id, 3]) }}"
										   class="btn btn-xs @if($question->status == 3) btn-success @else btn-default @endif">bullshit</a>
									</div>
								@endif
								{{-- TODO there would be a problem with admin permissions...--}}
								{{--@if($question->assigned_to == Auth::user()->id)--}}
								{{--<hr>--}}
								{{--<div class="btn-group">--}}
								{{--<a href="#" class="btn btn-xs btn-default">označiť, že na tom pracujem</a>--}}
								{{--</div>--}}
								{{--@endif--}}
							</div>

							<p>Naposledy upravil <a>{{ $question->answer->user->fullName() }}</a>
								dňa {{ $question->answer->updated_at }}.</p>

						@endif

					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1" id="logout">
				<div class="comment-tabs">
					<ul class="nav nav-tabs" role="tablist">
						<li class="active"><a href="#comments-logout" role="tab" data-toggle="tab"><h4
										class="reviews text-capitalize">Komentáre ({{ count($question->comments) }}
									)</h4></a></li>
						<li><a href="#add-comment" role="tab" data-toggle="tab"><h4 class="reviews text-capitalize">
									Pridať komentár</h4></a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="comments-logout">
							<ul class="media-list">

								@if(count($question->comments) > 0)
									@foreach($question->comments as $comment)
										<li class="media">
											<a class="pull-left" href="#">
												<img class="media-object img-circle"
												     src="{{ asset('resources/default/profile/crop_default.jpg') }}"
												     alt="profile">
											</a>
											<div class="media-body">
												<div class="well well-lg">
													<h4 class="media-heading reviews">{{ $comment->user->fullName() }} </h4>

													<ul class="media-date text-uppercase reviews list-inline">
														<li class="dd">{{ $comment->created_at  }}</li>
													</ul>
													<p class="media-comment">
														{!!  $comment->content  !!}
													</p>

													@if(Auth::user()->isAdmin())
														<a class="btn btn-danger btn-xs"
														   href="{{ route('questions.comment.delete', $comment->id) }}"
														   id="reply"><span class="fa fa-remove"></span> zmazať</a>
													@endif

												</div>
											</div>
										</li>
									@endforeach
								@else
									<p>Žiadne komentáre.</p>
								@endif


								{{--here starts--}}

								{{--here ends--}}

							</ul>
						</div>
						<div class="tab-pane" id="add-comment">

							{!! Form::open(['route' => ['questions.comment', $question->id], 'method' => 'post', 'class' => 'form-horizontal']) !!}

							{{-- Comment Field --}}
							<div class="form-group">
								{!! Form::label('comment', 'Komentár:', ['class' => 'col-sm-2 control-label']) !!}
								<div class="col-sm-10">
									{!! Form::textarea('comment', null, [
										'class' => 'form-control'
									]) !!}
								</div>
							</div>

							{{-- Comment Submit --}}
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									{!! Form::submit('komentovať', [
										'class' => 'btn btn-success'
									]) !!}
								</div>
							</div>

							{!! Form::close() !!}

						</div>

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

		$(document).ready(function () {
			$('#comment').summernote({
				minHeight: 200
			});
		});

	</script>

@endsection
