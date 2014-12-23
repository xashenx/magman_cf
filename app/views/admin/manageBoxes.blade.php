@section('content')
<p>
	Gestione Caselle
</p>
<div class="row">
	<div class="col-md-12">
		<!-- Advanced Tables -->
		<div class="panel panel-default">
			<div class="panel-heading">
				Caselle
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover" id="dataTables-example">
						<thead>
							<tr>
								<th># Casella</th>
								<th>Casellante</th>
								<th>Fumetti disponibili</th>
								<th>Scontistica</th>
								<th>Dovuto sul disponibile</th>
								<th>Ultimo Acquisto</th>
							</tr>
						</thead>
						<tbody>

							@foreach ($boxes as $box)
							<tr class="odd gradeX">
								<td>{{$box->number}}</td>
								<td>{{$box->name}} {{$box->surname}}</td>
								@if (count($box->available) > 0)
								<td>{{count($box->available)}}</td>
								<td>{{$box->discount}}</td>
								<td>{{$box->due}}</td>
								@else
								<td>0</td>
								<td>{{$box->discount}}</td>
								<td></td>
								<td>{{$box->lastBuy->max('buy_time')}}</td>
								@endif
							</tr>
							@endforeach
							</tr>
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