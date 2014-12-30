@section('content')
<div class="row">
	<div class="col-md-12 col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2>Fumetto Ordinato</h2>
				<br />
				@if($comic->comic->series->version != null)
				<u>{{$comic->comic->series->name}} - {{$comic->comic->series->version}} nr. {{$comic->comic->number}}</u>
				@else
				<u>{{$comic->comic->series->name}} nr. {{$comic->comic->number}}</u>
				@endif
				per <u>{{$comic->box->name}} {{$comic->box->surname}}</u>
				<br />
				Ordinato il: {{date('d-m-Y',strtotime($comic->created_at))}}
			</div>
			<div class="panel-body">
				<h3>Modifica</h3>
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