@extends('layouts.app')

@section('links')
	@parent

@endsection

@section('content')

	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading">Všetky otázky</div>

					<div class="panel-body">

{{--						@if(!Auth::user()->isAdmin())--}}
						<input type="text" class="form-control input-sm m-b-xs" id="filter"
						       placeholder="Prehľadávať otázky">
						{{--@else--}}
							{{--<input type="text" class="nput-sm m-b-xs col-sm-10" id="filter"--}}
							       {{--placeholder="Prehľadávať otázky">--}}
							{{--<div class="col-sm-2">--}}
								{{--<button class="btn btn-primary">Pridať otázku</button>--}}
							{{--</div>--}}
						{{--@endif--}}


						<table class="footable table table-stripped" data-page-size="50" data-filter=#filter>


							<thead>
							<tr>
								<th>#ID</th>
								<th>Predmet</th>
								<th data-sort-ignore="true">Znenie</th>
								<th class="text-center">Stav</th>
								<th class="text-center"><i class="fa fa-comment"></i></th>
								<th class="text-center">Vypracoval</th>
								<th data-sort-ignore="true" class="text-center">Akcia</th>
							</tr>
							</thead>

							<tbody>

							@foreach($questions as $question)

								<tr>
									<td data-type="numeric" data-value="{{ $question->id }}"> {{ $question->id }}</td>
									<td>{{ $question->subject->slug }}</td>
									<td><span data-toggle="tooltip" title="{{ $question->content }}">{{ $question->shortContent() }}</span></td>
									<td class="text-center">{!! $question->getStatusAsLabel() !!}</td>
									<td class="text-center" data-type="numeric" data-value="{{ count($question->comments) }}">{{ count($question->comments) }}</td>
									<td class="text-center">{!! $question->getAssignedToName() !!}</td>
									<td class="text-center vert-align">
										<div class="btn-group">
											<a href="{{ $question->getUrl() }}" class="btn btn-xs btn-default">zobraziť</a>
										</div>
									</td>
								</tr>


							@endforeach


							</tbody>

							<tfoot>
							<tr>
								<td colspan="7">
									<ul class="pagination pull-right"></ul>
								</td>
							</tr>
							</tfoot>

						</table>

					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	@parent
	<script src="{{ asset('js/plugins/footable/footable.all.min.js') }}"></script>

	<script>
		$(document).ready(function () {

			$('.footable').footable();

			$('[data-toggle="tooltip"]').tooltip();

		});

	</script>

@endsection
