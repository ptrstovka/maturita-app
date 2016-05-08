@if(isset($errors))
	@if(count($errors) > 0)
		<div class="row">
			<div class="col-md-12">
				@foreach($errors->all() as $error)
					<div class="alert alert-danger">
						{!!  $error  !!}
					</div>
				@endforeach
			</div>
		</div>
	@endif
@endif


@if(Session::has('message'))
	<div class="row">
		<div class="col-md-12">
			<div class="alert alert-success">
				{!!  Session::get('message')  !!}
			</div>
		</div>
	</div>
@endif

@if(Session::has('warning'))
	<div class="row">
		<div class="col-md-12">
			<div class="alert alert-warning">
				{!!  Session::get('warning')  !!}
			</div>
		</div>
	</div>
@endif

@if(Session::has('info'))
	<div class="row">
		<div class="col-md-12">
			<div class="alert alert-info">
				{!!  Session::get('info')  !!}
			</div>
		</div>
	</div>
@endif