@section('content')
<div class="row">
	<div class="col-md-12 col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Casella {{$user->number}}: {{$user -> name}} {{$user->surname}}
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs">
					@if($user->active)
					@if(count($comics)>0)
					<li class="active">
						<a href="#orderedComics" data-toggle="tab">In arrivo</a>
					</li>
					@if(count($series)>0)
					<li class="">
						<a href="#series" data-toggle="tab">Serie Seguite</a>
					</li>
					@endif
					<li class="">
						<a href="#newseries" data-toggle="tab">Nuova Serie</a>
					</li>
					@elseif(count($series)>0)
					<li class="active">
						<a href="#series" data-toggle="tab">Serie Seguite</a>
					</li>
					<li class="">
						<a href="#newseries" data-toggle="tab">Nuova Serie</a>
					</li>
					@elseif(count($comics)==0 && count($series)==0)
					<li class="active">
						<a href="#newseries" data-toggle="tab">Nuova Serie</a>
					</li>
					@endif
					<li class="">
						<a href="#newsinglecomic" data-toggle="tab">Nuovo Arretrato/Singolo</a>
					</li>
					<li class="">
						<a href="#details" data-toggle="tab">Dettagli</a>
					</li>
					@else
					<li class="active">
						<a href="#details" data-toggle="tab">Dettagli</a>
					</li>
					@endif
					<li class="">
						<a href="#edit" data-toggle="tab">Modifica</a>
					</li>
				</ul>
				<div class="tab-content">
					@if($user->active)
					@if(count($comics)>0)
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
													<th>Prezzo</th>
													<th>Azioni Rapide</th>
												</tr>
											</thead>
											<tbody>
												@foreach ($comics as $comic)
												@if ($comic->comic->available > 1)
												<tr class="success">
													@else
												<tr class="odd gradeX">
													@endif
													@if($comic->comic->series->version != null)
													<td><a href="{{$user->id}}/comic/{{$comic->id}}">{{ $comic->comic->series->name}} - {{ $comic->comic->series->version}} nr. {{ $comic->comic->number}}</a></td>
													@else
													<td><a href="{{$user->id}}/comic/{{$comic->id}}">{{ $comic->comic->series->name}} nr. {{ $comic->comic->number}}</a></td>
													@endif
													<td>{{ round($comic->price,2) }}</td>
													<td>
													<div class="btn-group">
														<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">
															Azioni <span class="caret"></span>
														</button>
														<ul class="dropdown-menu">
															<li>
																@if($comic->comic->available > 1)
																<a href="#" onclick = "showConfirmModal({{$comic->comic->id}},{{$user->id}},0)">Acquistato</a>
																@endif
																<a href="#" onclick = "showConfirmModal({{$comic->comic->id}},{{$user->id}},1)">Rimuovi</a>
															</li>
														</ul>
													</div></td>
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
					@if(count($series)>0)
					<div class="tab-pane fade" id="series">
						<p>
							<div class="table-responsive table-bordered">
								<table class="table table-striped table-bordered table-hover" id="dataTables-example">
									<thead>
										<tr>
											<th>Serie</th>
											<th>Autore</th>
											<th>Numeri Usciti</th>
											<th>Azioni Rapide</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($series as $serie)
										@if ($serie->series->concluded)
										<tr class="success">
											@elseif($serie->active)
										<tr class="odd gradeX">
											@else
										<tr class="danger">
											@endif
											@if($serie->series->version == null)
											<td>{{$serie->series->name}}</td>
											@else
											<td>{{$serie->series->name}} - {{$serie->series->version}}</td>
											@endif
											<td>{{$serie->series->author}}</td>
											<td>{{count($serie->series->listComics)}}</td>
											<td> @if(!$serie->series->concluded)
											<div class="btn-group">
												<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">
													Azioni <span class="caret"></span>
												</button>
												<ul class="dropdown-menu">
													<li>
														@if($serie->active)
														<a href="#" onclick = "showConfirmModal({{$serie->id}},{{$user->id}},2)">Abbandona</a>
														@else
														<a href="#" onclick = "showConfirmModal({{$serie->id}},{{$user->id}},3)">Segui</a>
														@endif
													</li>
												</ul>
											</div> @endif </td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</p>
					</div>
					@endif
					@elseif(count($series)>0)
					<div class="tab-pane fade active in" id="series">
						<p>
							<div class="table-responsive table-bordered">
								<table class="table table-striped table-bordered table-hover" id="dataTables-example">
									<thead>
										<tr>
											<th>Serie</th>
											<th>Autore</th>
											<th>Numeri Usciti</th>
											<th>Azioni Rapide</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($series as $serie)
										@if ($serie->series->concluded)
										<tr class="success">
											@elseif($serie->active)
										<tr class="odd gradeX">
											@else
										<tr class="danger">
											@endif
											@if($serie->series->version == null)
											<td>{{$serie->series->name}}</td>
											@else
											<td>{{$serie->series->name}} - {{$serie->series->version}}</td>
											@endif
											<td>{{$serie->series->author}}</td>
											<td>{{count($serie->series->listComics)}}</td>
											<td> @if(!$serie->series->concluded)
											<div class="btn-group">
												<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">
													Azioni <span class="caret"></span>
												</button>
												<ul class="dropdown-menu">
													<li>
														@if($serie->active)
														<a href="#" onclick = "showConfirmModal({{$serie->id}},{{$user->id}},2)">Abbandona</a>
														@else
														<a href="#" onclick = "showConfirmModal({{$serie->id}},{{$user->id}},3)">Segui</a>
														@endif
													</li>
												</ul>
											</div> @endif </td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</p>
					</div>
					@endif
					@if(count($series)>0 || count($comics)>0)
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
								{{ Form::submit('Aggiungi') }}
							</div>
							{{ Form::close() }}
						</p>
					</div>
					@else
					<div class="tab-pane fade active in" id="newseries">
						<!-- <h4>Edit Tab</h4> -->
						<p>
							{{ Form::open(array('action' => 'SeriesUserController@create')) }}
							<div>
								{{ Form::label('series_id', 'Serie') }}
								{{ Form::text('series_id') }}
								{{ Form::hidden('user_id', $user->id) }}
							</div>
							<div>
								{{ Form::submit('Aggiungi') }}
							</div>
							{{ Form::close() }}
						</p>
					</div>
					@endif
					<div class="tab-pane fade" id="newsinglecomic">
						<!-- <h4>Edit Tab</h4> -->
						<p>
							{{ Form::open(array('action' => 'ComicUserL2Controller@create')) }}
							<div>
								{{ Form::label('series_id','Serie') }}
								{{ Form::text('series_id') }}
								{{ Form::label('number', 'Numero') }}
								{{ Form::text('number') }}
								{{ Form::hidden('user_id', $user->id) }}
							</div>
							<div>
								{{ Form::submit('Aggiungi') }}
							</div>
							{{ Form::close() }}
						</p>
					</div>
					@endif
					@if(!$user->active)
					<div class="tab-pane fade active in" id="details">
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
					@else
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
					@endif
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

<div class="modal fade" id="modal-confirm" tabindex="-1" role="dialog" aria-labelledby="confirm" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h3 class="modal-title">Conferma azione</h3>
			</div>
			<div class="modal-body">
				<p id="confirmPageName" class="text-danger"></p>
			</div>
			<div class="modal-footer">
				{{ Form::open(array('name' => 'confirmForm')) }}
				{{ Form::hidden('id') }}
				{{ Form::hidden('user_id') }}
				{{ Form::button('Annulla', array(
				'data-dismiss' => 'modal',
				'class' => 'btn btn-danger btn-sm')) }}
				{{ Form::submit('Confermo', array('class' => 'btn btn-danger btn-sm',)) }}
				{{ Form::close() }}
			</div>
		</div>
		{{-- /.modal-content --}}
	</div>
	{{-- /.modal-dialog --}}
</div>
{{-- /.modal --}}
<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
<!-- JQUERY SCRIPTS -->
<script>
	function showConfirmModal(object_id, user_id, mode) {
		document.confirmForm.user_id.value = user_id;
		if (mode == 0) {
			// buying the comic
			document.confirmForm.id.value = object_id;
			document.confirmForm.action = '../buyComic';
			$('#confirmPageName').text('Il fumetto è stato acquistato?');
		} else if (mode == 1) {
			// removing the comic from the box
			document.confirmForm.id.value = object_id;
			document.confirmForm.action = '../deleteComicUser';
			$('#confirmPageName').text('Sei sicuro di voler togliere il fumetto dalla casella?');
		} else if (mode == 2) {
			// removing the follow of the series from the box
			document.confirmForm.id.value = object_id;
			document.confirmForm.action = '../deleteSeriesUser';
			$('#confirmPageName').text('Sei sicuro di voler togliere la serie dalla casella?');
		} else if (mode == 3) {
			// restore the follow of the series in the box
			document.confirmForm.id.value = object_id;
			document.confirmForm.action = '../restoreSeriesUser';
			$('#confirmPageName').text('Sei sicuro di voler ripristinare la seria nella casella?');
		}
		$('#modal-confirm').modal({
			show : true
		});
	}
</script>
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
