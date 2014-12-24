@section('content')
<p>
	Visualizza/Modifica Fumetto
</p>
{{$comic->series->name}}<br />
{{$comic->series->version}}<br />
{{$comic->name}}<br />
{{round($comic->price,2)}}<br />

<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
<!-- JQUERY SCRIPTS -->
<script src="../../assets/js/jquery.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="../../assets/js/bootstrap.min.js"></script>
<!-- METISMENU SCRIPTS -->
<script src="../../assets/js/jquery.metisMenu.js"></script>
<!-- DATA TABLE SCRIPTS -->
<script src="../../assets/js/dataTables/jquery.dataTables.js"></script>
<script src="../../assets/js/dataTables/dataTables.bootstrap.js"></script>
<script>
	$(document).ready(function() {
		$('#dataTables-example').dataTable();
	}); 
</script>
<!-- CUSTOM SCRIPTS -->
<script src="../../assets/js/custom.js"></script>
@stop