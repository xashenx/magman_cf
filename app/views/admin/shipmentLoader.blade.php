@section('content')
<div class="row">
	<div class="col-md-12 col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Nuovi Arrivi
			</div>
			<div class="panel-body">
				{{ Form::open(array('action' => 'ComicsController@loadShipment')) }}
				<div>
					{{ Form::label('comic_id', 'Fumetto') }}
					{{ Form::text('comic_id') }}
					@foreach($errors->get('comic_id') as $message)
					{{$message}}
					@endforeach
				</div>
				<div>
					{{ Form::label('amount', 'Quantità') }}
					{{ Form::text('amount') }}
					@foreach($errors->get('amount') as $message)
					{{$message}}
					@endforeach
				</div>
				<div>
					{{ Form::submit('Carica') }}
				</div>
				{{ Form::close() }}
			</div>
		</div>
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
@stop