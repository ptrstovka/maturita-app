@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading">Home
					</div>

					<div class="panel-body">

						<div class="row">
							<div class="col-sm-12">
								<p>Ahojte spolužiaci.<br>
									Takže všetko je vypracované. Špeciálne ďakujem Lukášovi, Mirkovi, Adamovi (Feckovi),
									Kamilovi...
									a nebudem ďalej menovať lebo určite ešte niekoho zabudnem a ukrivdím mu. Vy ste toho
									spravili najviac.
									Spolužiaci by vás mali pozvať na pivo ;)</p>
							</div>

							<div class="col-sm-6 col-sm-offset-3">
								<table class="table table-responsive table-bordered">

									<thead>
									<tr>
										<th class="text-center">#</th>
										<th class="text-center">User</th>
										<th class="text-center">Počet vypracovaní</th>
									</tr>
									</thead>

									<tbody>
									@for($i = 0; $i < count($users); $i++)
										<tr>
											<td class="text-center">{{ $i + 1 }}</td>
											<td class="text-center">{{ $users[$i]->fullName() }}</td>
											<td class="text-center">{{ $users[$i]->solved_questions }}</td>
										</tr>
									@endfor
									</tbody>

								</table>
								<p>
									<small>(To len tak pre zaujímavosť a možno to nie je objektívne.)</small>
								</p>
							</div>


							@if(Auth::user()->isVerified())
								<div class="col-sm-12">
									<p>No a nakoľko si spravil {{ Auth::user()->solved_questions }} otázok, čo spĺňa
										pravidlá na ktorých sme sa dohodli, Mirko a Lukáš pre teba pripravili dokument
										so všetkými otázkami. Aby sa ti lepšie učilo. Ak si ho stiahneš a dáš ho
										nejakému
										lenivcovi ktorý sa neodhodlal ani registrovať do systému... nepomyslím si nič
										avšak
										niekto nad tým trávil hodiny svojho času, ktoré mu už nikto nevráti.
										Zváž, čo s tým spravíš.</p>

									<p>No a nakoniec {{ Auth::user()->first_name }} ti prajem veľa šťastia a
										trpezlivosti
										pri učení a následnej maturitnej skúške <i class="fa fa-smile-o"></i>.</p>

									<p>Súbor si môžeš stiahnuť kliknutím <a href="{{ route('questions.download') }}"
									                                        target="_blank">sem</a>.</p>

								</div>

							@else
								<div class="col-sm-12">
									<p>Je mi ľuto ale nesplnil si limit na ktorom sme sa dohodli. Stanovili sme pravidlá
										a ty si ich nedodržal. K otázkam a downloadu sa nedostaneš.</p>
								</div>
							@endif

							<div class="col-sm-12">
								<p>Made with <i class="fa fa-heart-o"></i> by Petrík. <strong>v1.5</strong></p>
							</div>

						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
