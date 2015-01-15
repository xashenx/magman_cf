@section('content')
<div class="row">
	<div class="col-md-12">
		<!-- Advanced Tables -->
		<div class="panel panel-default">
			<div class="panel-heading">
				<h5>Serie disponibili</h5>
			</div>
			<div class="panel-body">
				<div class="table-responsive table-bordered">
					<table class="table table-striped table-bordered table-hover" id="dataTables-example">
						<thead>
							<tr>
								<th>Nome</th>
								<th>Serie</th>
								<th>Autore</th>
								<th>Numeri Usciti</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($series as $serie)
							@if ($serie->concluded == 1)
							<tr class="success">
								@elseif ($serie->active == 1)
							<tr class="odd gradeX">
								@else
							<tr class="danger">
								@endif
								<td><a href="series/{{$serie->id}}">{{$serie->name}}</a></td>
								<td>{{$serie->version}}</td>
								<td>{{$serie->author}}</td>
								<td>{{$serie->listComics->max('number')}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
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