@section('content')
<div class="row">
	<div class="col-md-12 col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Visualizza/Modifica Serie
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#details" data-toggle="tab">Dettagli</a>
					</li>
					<li class="">
						<a href="#numbers" data-toggle="tab">Numeri</a>
					</li>
					<li class="">
						<a href="#newnumber" data-toggle="tab">Nuovo Numero</a>
					</li>
					<li class="">
						<a href="#edit" data-toggle="tab">Modifica</a>
					</li>
				</ul>

				<div class="tab-content">
					<div class="tab-pane fade active in" id="details">
						<!-- <h4>Details Tab</h4> -->
						<p>
							Nome: {{$series->name}}
							<br />
							Versione: {{$series->version}}
							<br />
							Autore: {{$series->author}}
							<br />
							@if($series->listComics->max('number') != null)
								Numeri usciti: {{$series->listComics->max('number')}}
							@else
								Numeri usciti: 0
							@endif
							<br />
							@if($series->conclusa)
							Stato: Conclusa
							<br />
							@else
							Stato: Attiva
							<br />
							@endif
							Casellanti della serie: {{count($series->inBoxes)}}
						</p>
					</div>
					<div class="tab-pane fade" id="numbers">
						<!-- <h4>Numbers Tab</h4> -->
						<p>
							<!-- Advanced Tables -->
							<div class="panel panel-default">
								<div class="panel-heading"></div>
								<div class="panel-body">
									<div class="table-responsive">
										<table class="table table-striped table-bordered table-hover" id="dataTables-example">
											<thead>
												<tr>
													<th>Numero</th>
													<th>Nome</th>
													<th>Prezzo</th>
													<th>Disponibilità</th>
												</tr>
											</thead>
											<tbody>
												@foreach ($series->listComics as $comic)
												@if($comic->active)
												<tr class="odd gradeX">
													@else
												<tr class="danger">
													@endif
													<td>{{$comic->number}}</td>
													<td><a href="{{$series->id}}/{{$comic->id}}">{{$comic->name}}</a></td>
													<td>{{round($comic->price,2)}}</td>
													<td>{{$comic->available}}</td>
												</tr>
												@endforeach
											</tbody>
										</table>
									</div>

								</div>
							</div>
							<!--End Advanced Tables -->
						</p>
					</div>
					<div class="tab-pane fade" id="newnumber">
						<!-- <h4>Edit Tab</h4> -->
						<p>
							{{ Form::open(array('action' => 'ComicsController@create')) }}
							<div>
								{{ Form::label('name', 'Nome') }}
								{{ Form::text('name') }}
								{{ Form::hidden('series_id', $series->id)}}
							</div>
							<div>
								{{ Form::label('number','number') }}
								{{ Form::text('number', $next_comic_number) }}
							</div>
							<div>
								{{ Form::label('price', 'Prezzo') }}
								{{ Form::text('price', '0') }}
							</div>
							<div>
								{{ Form::label('available', 'Disponibilità') }}
								{{ Form::text('available', '0') }}
							</div>
							<div>
								{{ Form::submit('Inserisci') }}
							</div>
							{{ Form::close() }}
						</p>
					</div>
					<div class="tab-pane fade" id="edit">
						<!-- <h4>Edit Tab</h4> -->
						<p>
							{{ Form::model($series, array('action' => 'SeriesController@update')) }}
							<div>
								{{ Form::label('name', 'Nome') }}
								{{ Form::text('name') }}
								{{ Form::hidden('id')}}
							</div>
							<div>
								{{ Form::label('version','Versione') }}
								{{ Form::text('version') }}
							</div>
							<div>
								{{ Form::label('author', 'Autore') }}
								{{ Form::text('author') }}
							</div>
							<div>
								{{ Form::label('type_id', 'Tipo') }}
								{{ Form::text('type_id') }}
							</div>
							<div>
								{{ Form::label('subtype_id', 'Sotto Tipo') }}
								{{ Form::text('subtype_id') }}
							</div>
							<div>
								{{ Form::label('active', 'Attivo') }}
								{{ Form::checkbox('active', 'value'); }}
							</div>
							<div>
								{{ Form::label('completed', 'Conclusa') }}
								{{ Form::checkbox('completed', 'value'); }}
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
