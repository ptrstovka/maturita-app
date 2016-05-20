<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Maturita | 4D | TČOZ</title>

	@section('links')
		<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

		<link rel="stylesheet" href="{{asset('css/style.css') }}">

		<!-- Fonts -->
		<link rel="stylesheet" href="{{ asset('font-awesome/css/font-awesome.min.css') }}">
		{{--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">--}}

				<!-- Styles -->
		{{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">--}}
		{{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
	@show

	<style>
		/*body {*/
		/*font-family: 'Lato';*/
		/*}*/

		.fa-btn {
			margin-right: 6px;
		}
	</style>
</head>
<body id="app-layout">
<nav class="navbar navbar-default navbar-static-top">
	<div class="container">
		<div class="navbar-header">

			<!-- Collapsed Hamburger -->
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
			        data-target="#app-navbar-collapse">
				<span class="sr-only">Toggle Navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>

			<!-- Branding Image -->
			<a class="navbar-brand" href="{{ url('/') }}">
				<i class="fa fa-heart"></i> 4.D
			</a>
		</div>

		<div class="collapse navbar-collapse" id="app-navbar-collapse">
			<!-- Left Side Of Navbar -->
			<ul class="nav navbar-nav">
				<li><a href="{{ url('/home') }}">Home</a></li>
			</ul>

			<!-- Right Side Of Navbar -->
			<ul class="nav navbar-nav navbar-right">
				<!-- Authentication Links -->
				@if (Auth::guest())
					<li><a href="{{ url('/login') }}">Login</a></li>
					@if(!env('DISABLE_REGISTRATIONS', true))
						<li><a href="{{ url('/register') }}">Register</a></li>
					@endif
				@else

					@if(Auth::user()->hasCategory(1))
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
							Otázky - TČOZ <span class="caret"></span>
						</a>

						<ul class="dropdown-menu" role="menu">
							<li><a href="{{ route('questions.all', 1) }}">Všetky otázky</a></li>
							<li><a href="{{ route('questions.user', 1) }}">Moje otázky</a></li>
						</ul>
					</li>
					@endif

					@if(Auth::user()->hasCategory(2))
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
							Otázky - SJL <span class="caret"></span>
						</a>

						<ul class="dropdown-menu" role="menu">
							<li><a href="{{ route('questions.all', 2) }}">Všetky otázky</a></li>
							<li><a href="{{ route('questions.user', 2) }}">Moje otázky</a></li>
						</ul>
					</li>
					@endif

					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
							{{ Auth::user()->fullName() }} @if(Auth::user()->isAdmin()) - Administrator @endif<span class="caret"></span>
						</a>

						<ul class="dropdown-menu" role="menu">
							@if(Auth::user()->isAdmin())
								<li><a href="{{ route('users.index') }}"><i class="fa fa-btn fa-users"></i>Users</a></li>
							@endif
							<li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
						</ul>
					</li>
				@endif
			</ul>
		</div>
	</div>
</nav>

<div class="container">
	@include('errors.error')
</div>

@yield('content')

<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="back to top" data-toggle="tooltip" data-placement="left"><span class="fa fa-arrow-up"></span></a>

		<!-- JavaScripts -->
@section('scripts')
	<script src="{{ asset('js/jquery-2.1.1.js') }}"></script>
	<script src="{{ asset('js/bootstrap.js') }}"></script>

	<script type="text/javascript">

		$(document).ready(function(){
			$(window).scroll(function () {
				if ($(this).scrollTop() > 50) {
					$('#back-to-top').fadeIn();
				} else {
					$('#back-to-top').fadeOut();
				}
			});
			// scroll body to 0px on click
			$('#back-to-top').click(function () {
				$('#back-to-top').tooltip('hide');
				$('body,html').animate({
					scrollTop: 0
				}, 800);
				return false;
			});

			$('#back-to-top').tooltip('show');

		});

	</script>

@show
</body>
</html>
