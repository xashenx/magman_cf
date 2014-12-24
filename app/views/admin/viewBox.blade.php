@section('content')
<div class="row">
	<div class="col-md-12 col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Visualizza/Modifica Casella
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#details" data-toggle="tab">Dettagli</a>
					</li>
					<li class="">
						<a href="#edit" data-toggle="tab">Modifica</a>
					</li>
				</ul>

				<div class="tab-content">
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
					<div class="tab-pane fade" id="edit">
						<!-- <h4>Edit Tab</h4> -->
						<p>
							{{ Form::model($user, array('action' => 'AdminL2Controller@updateUser')) }}
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
								{{ Form::label('password', 'Password') }}
								{{ Form::text('password') }}
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
