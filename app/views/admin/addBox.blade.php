@section('content')
  {{ Form::open(array('action' => 'AdminController@saveBox')) }}
    Username : {{ Form::text('username') }}
    <br/>
    Password : {{ Form::password('password') }}
    <br/>
    {{ Form::submit('Crea') }}
  {{ Form::close() }}
@stop