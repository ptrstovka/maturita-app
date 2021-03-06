@extends('layouts.app')

@section('links')
	@parent

@endsection

@section('content')

	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading">Tvoje otázky</div>

					<div class="panel-body">

						@if(!Auth::user()->isVerified() && !Auth::user()->isAdmin())
							<div class="row">
								<div class="col-md-12">
									<div class="alert alert-info">
										Vypracuj prosím tieto otázky a budú ti sprístupnené všetky ostatné vypracované
										tvojími spolužiakmi.
									</div>
								</div>
							</div>
						@endif


						@if(count($questions) > 0)
						<input type="text" class="form-control input-sm m-b-xs" id="filter"
						       placeholder="Prehľadávať otázky">


						<table class="footable table table-stripped" data-page-size="20" data-filter=#filter>


							<thead>
							<tr>
								<th>#ID</th>
								<th>Predmet</th>
								<th data-sort-ignore="true">Znenie</th>
								<th class="text-center">Stav</th>
								<th data-sort-ignore="true" class="text-center">Akcia</th>
							</tr>
							</thead>

							<tbody>

								@foreach($questions as $question)

									<tr>
										<td data-type="numeric" data-value="{{ $question->id }}">{{ $question->id }}</td>
										<td>{{ $question->subject->slug }}</td>
										<td><span data-toggle="tooltip" title="{{ $question->content }}">{{ $question->shortContent() }}</span></td>
										<td class="text-center">{!! $question->getStatusLabel() !!}</td>
										<td class="text-center vert-align">
											<div class="btn-group">
												@if($question->status != 2)
												<a href="{{ $question->getEditUrl() }}" class="btn btn-xs btn-default">vypracovať</a>
												@else
													<a href="{{ $question->getUrl() }}" class="btn btn-xs btn-default">zobraziť</a>
												@endif
											</div>
										</td>
									</tr>

								@endforeach

							</tbody>

							<tfoot>
							<tr>
								<td colspan="5">
									<ul class="pagination pull-right"></ul>
								</td>
							</tr>
							</tfoot>

						</table>
						@else
							<p>Nevypracoval si žiadne otázky.</p>
						@endif
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