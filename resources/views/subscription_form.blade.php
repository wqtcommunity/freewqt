<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">This event has ended, would you like to get notified for future events?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('subscribe') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" name="email" required class="form-control" id="email" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="telegram" class="form-label">Telegram Username</label>
                        <input type="text" required name="telegram" class="form-control" id="telegram">
                    </div>
                    <button type="button" class="btn btn-secondary float-end" data-bs-dismiss="modal">No (Close)</button>
                    <button type="submit" class="btn btn-primary">Yes (Subscribe)</button>
                </form>
            </div>
            <div class="modal-footer">
                <small>If you decide to subscribe, we will only notify you by E-mail or Telegram in case we have another similar event.</small>
            </div>
        </div>
    </div>
</div>
@if(isset($auto_modal) && $auto_modal === true)
<script type="text/javascript">
    $(document).ready(function(){
        $("#staticBackdrop").modal('show');
    });
</script>
@endif