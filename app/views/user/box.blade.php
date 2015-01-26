@section('content')
	<h1>Visualizzazione Casella</h1><br/>
@if(count($errors)>0)
	<h3>Whoops! C'è stato un errore!!! <br/>
		Se il problema persiste, contattare un amministratore!</h3>
@endif
<div class="row">
	<div class="col-md-6">
		<!--    Bordered Table  -->
		<div class="panel panel-default">
			<div class="panel-heading">
				<h5>Fumetti in arrivo</h5>
				<strong>
					@if(date('Y-m-d', strtotime($user->shop_card_validity)) < date('Y-m-d',strtotime('now')))
					Rinnovo Tessera; {{ $renewal_price }}€<br/>
					@endif
					Saldo disponibili: {{ $due }}€
				</strong>
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
							@foreach ($comics as $comic)
								@if($inv_state == 1)
									@if ($comic->comic->available > 1)
										<tr class="success">
									@else
										<tr class="odd gradeX">
									@endif
								@else
									@if ($comic->comic->arrived_at > date('Y-m-d',strtotime('-1 month')))
										<tr class="success">
									@else
										@if ($comic->comic->state == 2)
											<tr class="warning">
										@else
											<tr class="odd gradeX">
										@endif
									@endif
								@endif
								<td>{{ $comic->comic->series->name}} - {{ $comic->comic->series->version}}</td>
								<td>{{ $comic->comic->number}}</td>
								<td>{{ round($comic->price,2) }}</td>
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
				<h5>Serie Seguite</h5>
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
								@if($serie->series->listActive->max('number') != null)
								<td>{{$serie->series->listActive->max('number')}}</td>
								@else
								<td>0</td>
								@endif
							</tr>
							@endforeach
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
