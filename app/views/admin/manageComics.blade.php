@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h1>Gestione Fumetti</h1>
			</div>
			<div class="panel-body">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h5>Fumetti inseriti nel sistema</h5>
					</div>
					<div class="tab-content">
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover" id="dataTables-example">
								<thead>
									<tr>
										<th>Editore</th>
										<th>Series</th>
										<th>Numero</th>
										<th>Cover</th>
										<th>Prezzo</th>
										@if($inv_state == 1)
										<th>Disponibilità</th>
											@endif
									</tr>
								</thead>
								<tbody>
									@foreach ($comics as $comic)
									@if($comic->active)
									<tr class="odd gradeX">
										@else
									<tr class="danger">
										@endif
										<td>{{ $comic->series->publisher }}</td>
										@if($comic->series->version != null)
										<td><a href="comics/{{ $comic->id }}">{{ $comic->series->name}} - {{ $comic->series->version}}</a></td>
										@else
										<td><a href="comics/{{ $comic->id }}">{{ $comic->series->name}}</a></td>
										@endif
										<td>{{ $comic->number}}</td>
										<td>
											@if($comic->image != null)
												<a href="{{$comic->image}}"><img src="{{$comic->image}}" alt="" height="42" width="42"></a>
											@endif
										</td>
										<td>{{ round($comic->price,2)}}€</td>
										@if($inv_state == 1)
										<td>{{ $comic->available}}</td>
											@endif
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
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
@stop