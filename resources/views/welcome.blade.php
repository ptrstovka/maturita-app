@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">

	                @if(Auth::guest())
						@if(env('DISABLE_REGISTRATIONS', true))
							<p>Ahoj.</p>
		                    <p>Prihlás sa prosím.</p>
			                <p>Ak sa chceš registrovať tak je mi ľúto. Všetky otázky sme vypracovali aj bez teba.</p>
						@else
			                Ahoj. Najprv si vytvor účet. Klikni na register.
						@endif
						@else
	                    {{--stats--}}

						Ahoj {{ Auth::user()->first_name }}!

						<p>Vypracoval si {{ Auth::user()->solved_questions }} otázok.</p>

						<p><strong>Posledný odkaz <a href="{{ url('home') }}">sem</a>.</strong></p>

	                @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
