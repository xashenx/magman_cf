@section('content')
<div class="row">
	<div class="col-md-12 col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Visualizza/Modifica Casella
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs">
					@if($user->active)
					<li class="active">
						<a href="#orderedComics" data-toggle="tab">In arrivo</a>
					</li>
					@endif
					@if($user->active)
					<li class="">
						@else
					<li class="active">
						@endif
						<a href="#series" data-toggle="tab">Serie Seguite</a>
					</li>
					@if($user->active)
					<li class="">
						<a href="#newseries" data-toggle="tab">Nuova Serie</a>
					</li>
					<li class="">
						<a href="#newsinglecomic" data-toggle="tab">Nuova Serie</a>
					</li>
					@endif
					<li class="">
						<a href="#details" data-toggle="tab">Dettagli</a>
					</li>
					<li class="">
						<a href="#edit" data-toggle="tab">Modifica</a>
					</li>
				</ul>
				<div class="tab-content">
					@if($user->active)
					<div class="tab-pane fade active in" id="orderedComics">
						<!-- <h4>Available Tab</h4> -->
						<p>
							<!--    Bordered Table  -->
							<div class="panel panel-default">
								<div class="panel-heading">
									Fumetti in arrivo <strong>(Saldo disponibili: {{ $due }}€)</strong>
								</div>
								<!-- /.panel-heading -->
								<div class="panel-body">
									<div class="table-responsive table-bordered">
										<table class="table table-striped table-bordered table-hover" id="dataTables-example">
											<thead>
												<tr>
													<th>Serie</th>
													<th>Numero</th>
													<th>Prezzo</th>
												</tr>
											</thead>
											<tbody>
												@foreach ($comics as $comic)
												@if ($comic->comic->available > 1)
												<tr class="success">
													@else
												<tr class="odd gradeX">
													@endif
													<td>{{ $comic->comic->series->name}} - {{ $comic->comic->series->version}}</td>
													<td>{{ $comic->comic->number}}</td>
													<td>{{ round($comic->price,2) }}</td>
												</tr>
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<!--  End  Bordered Table  -->
						</p>
					</div>
					<div class="tab-pane fade" id="series">
						@else
						<div class="tab-pane fade active in" id="series">
							@endif

							<!-- <h4>Details Tab</h4> -->
							<p>
								<div class="table-responsive table-bordered">
									<table class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
											<tr>
												<th>Serie</th>
												<th>Versione</th>
												<th>Autore</th>
												<th>Numeri Usciti</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($series as $serie)
											@if ($serie->series->concluded == 1)
											<tr class="success">
												@elseif($serie->active == 1)
											<tr class="odd gradeX">
												@else
											<tr class="danger">
												@endif
												<td>{{$serie->series->name}}</td>
												<td>{{$serie->series->version}}</td>
												<td>{{$serie->series->author}}</td>
												<td>{{count($serie->series->listComics)}}</td>
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</p>
						</div>
						@if($user->active)
						<div class="tab-pane fade" id="newseries">
							<!-- <h4>Edit Tab</h4> -->
							<p>
								{{ Form::open(array('action' => 'SeriesUserController@create')) }}
								<div>
									{{ Form::label('series_id', 'Serie') }}
									{{ Form::text('series_id') }}
									{{ Form::hidden('user_id', $user->id) }}
								</div>
								<div>
									{{ Form::submit('Inserisci') }}
								</div>
								{{ Form::close() }}
							</p>
						</div>
						@endif
						<div class="tab-pane fade" id="details">
							<!-- <h4>Details Tab</h4> -->
							<p>
								Nome: {{$user->name}}, Cognome: {{$user->surname}}
								<br />
								Numero casella: {{$user->number}}
								<br />
								Sconto: {{$user->discount}}
								<br />
							</p>
						</div>
						<div class="tab-pane fade" id="edit">
							<!-- <h4>Edit Tab</h4> -->
							<p>
								{{ Form::model($user, array('action' => 'UsersController@update')) }}
								<div>
									{{ Form::label('name', 'Nome') }}
									{{ Form::text('name') }}
								</div>
								<div>
									{{ Form::label('surname','Cognome') }}
									{{ Form::text('surname') }}
									{{ Form::hidden('id')}}
								</div>
								<div>
									{{ Form::label('number','Numero') }}
									{{ Form::text('number') }}
								</div>
								<div>
									{{ Form::label('pass', 'Password') }}
									{{ Form::password('pass') }}
								</div>
								<div>
									{{ Form::label('discount', 'Sconto') }}
									{{ Form::text('discount') }}
								</div>
								<div>
									{{ Form::label('active', 'Attivo') }}
									{{ Form::checkbox('active'); }}
								</div>
								<div>
									{{ Form::submit('Aggiorna') }}
								</div>
								{{ Form::close() }}
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
	<!-- JQUERY SCRIPTS -->
	<script src="../assets/js/jquery.js"></script>
	<!-- BOOTSTRAP SCRIPTS -->
	<script src="../assets/js/bootstrap.min.js"></script>
	<!-- METISMENU SCRIPTS -->
	<script src="../assets/js/jquery.metisMenu.js"></script>
	<!-- DATA TABLE SCRIPTS -->
	<script src="../assets/js/dataTables/jquery.dataTables.js"></script>
	<script src="../assets/js/dataTables/dataTables.bootstrap.js"></script>
	<script>
		$(document).ready(function() {
			$('#dataTables-example').dataTable();
		});
	</script>
	<!-- CUSTOM SCRIPTS -->
	<script src="../assets/js/custom.js"></script>
	@stop
