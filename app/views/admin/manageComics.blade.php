@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default no-radius">
      <div class="panel-heading no-radius">
        <span class="glyphicon glyphicon-book" aria-hidden="true"></span> Gestione Fumetti
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-xs-12">
            <div class="legend-red col-xs-2"></div>
            Fumetto disattivato
          </div>
        </div>
        <div>
          <div class="tab-content">
            <div>
              <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                  <tr>
                    <th>Fumetto</th>
                    <th>Editore</th>
                    {{--<th>Numero</th>--}}
                    {{--<th>Cover</th>--}}
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
                    @if($comic->series->version != null)
                      <td><a href="comics/{{ $comic->id }}">{{ $comic->series->name}} - {{ $comic->series->version}}  nr. {{ $comic->number}}</a></td>
                    @else
                      <td><a href="comics/{{ $comic->id }}">{{ $comic->series->name}} nr. {{ $comic->number}}</a></td>
                    @endif
                    <td>{{ $comic->series->publisher }}</td>
                    {{--<td>{{ $comic->number}}</td>--}}
                    {{--<td>--}}
                      {{--@if($comic->image)--}}
                        {{--<a href="{{$comic->image}}" target="_blank"><img src="{{$comic->image}}" alt="" class="cover"></a>--}}
                      {{--@endif--}}
                    {{--</td>--}}
                    <td>{{number_format((float)$comic->price, 2, '.', '')}} €</td>
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
@include('../layouts/js-include')
<script>
  $(document).ready(function() {
    $('#dataTables-example').dataTable({
      "language": {
        "url": "{{ URL::asset('assets/js/dataTables/comic.lang') }}"
      }
    } );
  });
</script>
<!-- CUSTOM SCRIPTS -->
@stop