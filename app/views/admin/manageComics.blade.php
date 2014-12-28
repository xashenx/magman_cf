@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Gestione Fumetti
			</div>
			<div class="panel-body">
				<div class="tab-content">
					<p>
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover" id="dataTables-example">
								<thead>
									<tr>
										<th>Series</th>
										<th>Numero</th>
										<th>Prezzo</th>
										<th>Disponibilità</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($comics as $comic)
									@if($comic->active)
									<tr class="odd gradeX">
										@else
									<tr class="danger">
										@endif
										@if($comic->series->version != null)
										<td><a href="comics/{{ $comic->id }}">{{ $comic->series->name}} - {{ $comic->series->version}}</a></td>
										@else
										<td><a href="comics/{{ $comic->id }}">{{ $comic->series->name}}</a></td>
										@endif
										<td>{{ $comic->number}}</td>
										<td>{{ $comic->price}}€</td>
										<td>{{ $comic->available}}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</p>
				</div>
			</div>
		</div>
	</div>
	<!-- Advanced Tables -->
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