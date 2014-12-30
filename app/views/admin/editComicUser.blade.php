@section('content')
<div class="row">
	<div class="col-md-6 col-sm-6">
		<div class="panel panel-danger" style="height: 300px;">
			<div class="panel-heading">
				Fumetto Ordinato
			</div>
			<div class="panel-body">
				<div>
					@if($comic->comic->series->version != null)
					<u>{{$comic->comic->series->name}} - {{$comic->comic->series->version}} nr. {{$comic->comic->number}}</u>
					@else
					<u>{{$comic->comic->series->name}} nr. {{$comic->comic->number}}</u>
					@endif
					per <u>{{$comic->box->name}} {{$comic->box->surname}}</u>
					<br />
					<br />
					Ordinato il: {{date('d-m-Y',strtotime($comic->created_at))}}
				</div>
				<br />
				<center>
					<div>
						{{ Form::model($comic, array('action' => 'ComicUserController@update')) }}
						<div>
							{{ Form::label('price', 'Prezzo') }}
							{{ Form::text('price') }}
							{{ Form::hidden('cu_id',$comic->id) }}
							{{ Form::hidden('user_id',$comic->box->id) }}
						</div>
						<div>
							{{ Form::label('active', 'Attivo') }}
							{{ Form::checkbox('active', 'value'); }}
						</div>
						<div>
							{{ Form::submit('Aggiorna') }}

						</div>
						{{ Form::close() }}
					</div>
				</center>
			</div>
			<!-- <div class="panel-footer">
			Panel Footer
			</div> -->
		</div>
	</div>
	<div class="col-md-6 col-sm-4">
		<div class="panel panel-danger" style="height: 300px;">
			<div class="panel-heading">
				<h2>Modifica</h2>
			</div>
			<div class="panel-body">
				{{ Form::model($comic, array('action' => 'ComicUserController@update')) }}
				<div>
					{{ Form::label('price', 'Prezzo') }}
					{{ Form::text('price') }}
					{{ Form::hidden('cu_id',$comic->id) }}
					{{ Form::hidden('user_id',$comic->box->id) }}
				</div>
				<div>
					{{ Form::label('active', 'Attivo') }}
					{{ Form::checkbox('active', 'value'); }}
				</div>
				<div>
					{{ Form::submit('Aggiorna') }}
				</div>
				{{ Form::close() }}
			</div>
			<!-- <div class="panel-footer">
			Panel Footer
			</div> -->
		</div>
	</div>
</div>

<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
<!-- JQUERY SCRIPTS -->
<script src="../../../assets/js/jquery.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="../../../assets/js/bootstrap.min.js"></script>
<!-- METISMENU SCRIPTS -->
<script src="../../../assets/js/jquery.metisMenu.js"></script>
<!-- DATA TABLE SCRIPTS -->
<script src="../../../assets/js/dataTables/jquery.dataTables.js"></script>
<script src="../../../assets/js/dataTables/dataTables.bootstrap.js"></script>
<script>
	$(document).ready(function() {
		$('#dataTables-example').dataTable();
	}); 
</script>
<!-- CUSTOM SCRIPTS -->
<script src="../../../assets/js/custom.js"></script>
@stop