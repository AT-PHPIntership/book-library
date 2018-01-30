<div id="confirmSendMail" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body text-center">
        <h3>{{ __('borrow.confirm.title') }}</h3>
        <p >{{ __('borrow.confirm.content') }}
            <strong class="data-content"></strong>? 
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-confirm" data-dismiss="modal">{{ __('confirm.ok') }}</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('confirm.close') }}</button>
      </div>
    </div>
    <!-- end content-->

  </div>
</div>
