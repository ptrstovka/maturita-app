@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading">Users


					</div>

					<div class="panel-body">

						<input type="text" class="form-control input-sm m-b-xs" id="filter"
						       placeholder="Prehľadávať užívateľov">


						<table class="footable table table-stripped" data-page-size="20" data-filter=#filter>

							<thead>
							<tr>
								<th>#ID</th>
								<th data-sort-ignore="true">Meno</th>
								<th data-sort-ignore="true">Email</th>
								<th class="text-center">Počet vypracovaní</th>
								<th data-sort-ignore="true" class="text-center">Akcia</th>
							</tr>
							</thead>

							<tbody>

							@foreach($users as $user)
								<tr>
									<td data-type="numeric" data-value="{{ $user->id }}">{{ $user->id }}</td>
									<td>{{ $user->fullName() }}</td>
									<td>{{ $user->email }}</td>
									<td data-type="numeric" data-value="{{ $user->solved_questions }}" class="text-center">{{ $user->solved_questions }}</td>
									<td class="text-center vert-align">
										<div class="btn-group">
											<a href="{{ route('users.show', $user->id) }}" class="btn btn-xs btn-default">editovať</a>
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