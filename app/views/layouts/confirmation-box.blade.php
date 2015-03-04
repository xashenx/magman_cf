<div class="modal fade" id="modal-confirm" tabindex="-1" role="dialog" aria-labelledby="confirm" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content no-radius">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
          &times;
        </button>
        <span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span> Conferma azione <span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
      </div>
      <div class="modal-body">
        <p id="confirmPageName" class="text"></p>
      </div>
      <div class="modal-footer">
        {{ Form::open(array('name' => 'confirmForm')) }}
          {{ Form::hidden('id') }}
          {{ Form::hidden('comics') }}
          {{ Form::hidden('return') }}
          {{ Form::button('Annulla', array(
          'data-dismiss' => 'modal',
          'class' => 'btn btn-danger btn-sm no-radius')) }}
          {{ Form::submit('Conferma', array('class' => 'btn btn-success btn-sm no-radius',)) }}
        {{ Form::close() }}
      </div>
    </div>
    {{-- /.modal-content --}}
  </div>
  {{-- /.modal-dialog --}}
</div>
{{-- /.modal --}}