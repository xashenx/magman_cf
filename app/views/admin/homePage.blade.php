@section('content')
<div class="row">
	<div class="col-md-12">
		<h3>Bentornato Admin {{ Auth::user()->name }}!</h3>
		@if((count($insolvents)+count($defaultings))>0)
		<div class="panel panel-default">
			<div class="panel-heading">
				Warning caselle
			</div>
			<div class="panel-body">
				<div class="tab-content">
					<p>
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover" id="dataTables-example">
								<thead>
									<tr>
										<th>Casellante</th>
										<th>Motivo del warning</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($insolvents as $key => $insolvent)
									<tr class="odd gradeX">
										<td>{{ $key }}</td>
										<td>{{ $insolvent}}</td>
									</tr>
									@endforeach
									@foreach ($defaultings as $key => $defaulting)
									<tr class="odd gradeX">
										<td>{{ $key }}</td>
										<td>{{ $defaulting }}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</p>
				</div>
			</div>
		</div>
		@endif
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