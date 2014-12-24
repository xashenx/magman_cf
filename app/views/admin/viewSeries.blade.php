@section('content')
<p>
	Visualizza/Modifica Serie
</p>
{{ Form::model($series) }}
{{ Form::label('name', 'Name') }}
{{ Form::text('name') }}

{{ Form::label('version', 'Version') }}
{{ Form::text('version') }}
{{ Form::label('author', 'Author') }}
{{ Form::text('author') }}
{{ Form::label('type_id', 'Type_id') }}
{{ Form::text('type_id') }}
{{ Form::label('subtype_id', 'subtype_id') }}
{{ Form::text('subtype_id') }}
{{ Form::close() }}
<br />
{{count($series->inBoxes)}}
<br />

<div class="row">
	<div class="col-md-12">
		<!-- Advanced Tables -->
		<div class="panel panel-default">
			<div class="panel-heading"></div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover" id="dataTables-example">
						<thead>
							<tr>
								<th>Nome</th>
								<th>Numero</th>
								<th>Prezzo</th>
								<th>Disponibilità</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($series->listComics as $comic)
							<tr class="odd gradeX">
								<td>{{$comic->name}}</td>
								<td>{{$comic->number}}</td>
								<td>{{round($comic->price,2)}}</td>
								<td>{{$comic->available}}</td>
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
<script src="../assets/js/jquery.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="../assets/js/bootstrap.min.js"></script>
<!-- METISMENU SCRIPTS -->
<script src="../assets/js/jquery.metisMenu.js"></script>
<!-- DATA TABLE SCRIPTS -->
<script src="../assets/js/dataTables/jquery.dataTables.js"></script>
<script src="../assets/js/dataTables/dataTables.bootstrap.js"></script>
<script>
	$(document).ready(function() {
		$('#dataTables-example').dataTable();
	}); 
</script>
<!-- CUSTOM SCRIPTS -->
<script src="../assets/js/custom.js"></script>
@stop