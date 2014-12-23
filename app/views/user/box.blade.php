@section('content')
<p>
	Visualizzazione Casella
</p>
<div class="row">
	<div class="col-md-6">
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
								<th>Numero</th>
								<th>Prezzo</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($user->listComics as $comic)
							@if ($comic->comic->available > 1)
							<tr class="success">
								@else
							<tr class="odd gradeX">
								@endif
								<td>{{ $comic->comic->series->name}} - {{ $comic->comic->series->version}}</td>
								<td>{{ $comic->comic->number}}</td>
								<td>{{ $comic->price}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!--  End  Bordered Table  -->
	</div>
	
	
	<div class="col-md-6">
		<!--    Bordered Table  -->
		<div class="panel panel-default">
			<div class="panel-heading">
				Serie Seguite
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="table-responsive table-bordered">
					<table class="table table-striped table-bordered table-hover" id="dataTables-example">
						<thead>
							<tr>
								<th>Serie</th>
								<th>Versione</th>
								<th>Autore</th>
								<th>Numeri Usciti</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($series as $serie)
							@if ($serie->series->concluded == 1)
							<tr class="success">
								@else
							<tr class="odd gradeX">
								@endif
								<td>{{$serie->series->name}}</td>
								<td>{{$serie->series->version}}</td>
								<td>{{$serie->series->author}}</td>
								<td>{{count($serie->series->listComics)}}</td>
							</tr>
							@endforeach
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!--  End  Bordered Table  -->
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
