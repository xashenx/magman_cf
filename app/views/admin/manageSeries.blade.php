@section('content')
<div class="row">
	<div class="col-md-12">
		<!-- Advanced Tables -->
		<div class="panel panel-default">
			<div class="panel-heading">
				Gestione Serie
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#boxes" data-toggle="tab">Caselle</a>
					</li>
					<li class="">
						<a href="#new" data-toggle="tab">Nuova Serie</a>
					</li>
				</ul>

				<div class="tab-content">
					<div class="tab-pane fade active in" id="boxes">
						<!-- <h4>Details Tab</h4> -->
						<p>
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover" id="dataTables-example">
									<thead>
										<tr>
											<th>Nome</th>
											<th>Serie</th>
											<th>Autore</th>
											<th>Numeri Usciti</th>
											<th># Casellanti</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($series as $serie)
										@if ($serie->active == 0)
										<tr class="danger">
											@elseif ($serie->concluded == 1)
										<tr class="success">
											@else
										<tr class="odd gradeX">
											@endif
											<td><a href="series/{{$serie->id}}">{{$serie->name}}</a></td>
											<td>{{$serie->version}}</td>
											<td>{{$serie->author}}</td>
											<td>{{$serie->listComics->max('number')}}</td>
											<td>{{count($serie->inBoxes)}}</td>
										</tr>
										@endforeach
										</tr>
									</tbody>
								</table>
							</div>
						</p>
					</div>
					<div class="tab-pane fade" id="new">
						<!-- <h4>Edit Tab</h4> -->
						<p>
							{{ Form::open(array('action' => 'SeriesController@update')) }}
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
								{{ Form::submit('Aggiorna') }}
							</div>
							{{ Form::close() }}
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--End Advanced Tables -->
</div>
</div>
<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
<!-- JQUERY SCRIPTS -->
<script src="assets/js/jquery.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="assets/js/bootstrap.min.js"></script>
<!-- METISMENU SCRIPTS -->
<script src="assets/js/jquery.metisMenu.js"></script>
<!-- DATA TABLE SCRIPTS -->
<script src="assets/js/dataTables/jquery.dataTables.js"></script>
<script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
<script>
	$(document).ready(function() {
		$('#dataTables-example').dataTable();
	}); 
</script>
<!-- CUSTOM SCRIPTS -->
<script src="assets/js/custom.js"></script>
@stop