@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading">Home
					</div>

					<div class="panel-body">

						Ahojte spolužiaci.<br>
						Dúfam, že si navzájom pomôžeme a každý vypracuje niekoľko otázok z teoretickej časti. <br>
						Aby to bolo všetko fér, každému som náhodne vygeneroval 8 otázok, ktoré musí spracovať, aby
						dostal prístup ku všetkým ostatným.
						<br>
						Ak by sa náhodou stalo, že by ti niekto vypracoval otázku už vygenerovanú pre teba, napíš mi.
						<br>
						<hr>
						Ak nájdeš bug, niečo sa ti nepáči či chceš niečo pridať, tiež mi napíš... <br>

						<a href="https://www.facebook.com/petiiiiiiik" target="_blank"><span><i class="fa fa-facebook"></i></span>
							sem</a>,
						<a href="mailto:stovka.peter@gmail.com?Subject=Ahoj%20Petrík."><span><i class="fa fa-send"></i></span>
							sem</a>
						alebo <a href="skype:j0k3r352"><span><i class="fa fa-skype"></i></span> sem</a>.

						<hr>

						Ak by sa našiel niekto kto by chcel prispieť do tohto systému - nech sa páči <a
								href="https://github.com/ptrstovka/maturita-app"><i class="fa fa-github"></i> GitHub</a>
						<br>
						Čo tu ešte plánujem pridať?
						<ul>
							<li>export vypracovaných otázok do PDF pre tlač alebo ak sa chceš učiť aj na hajzli u babky</li>
							<li>nejaké štatistiky, kto spravil najviac, kto najmenej, kto vôbec (nech vieme aké hovädá máme v triede)</li>
						</ul>
						<hr>

						Made with <i class="fa fa-heart-o"></i> by Petrík. <strong>v1.2.1</strong>

					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
