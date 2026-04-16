<div class="modal" id="ticketCommentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Comment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('add.error.logs.comment') }}" method="post" id="submitCommentForm">
                    @csrf
                    <input type="hidden" name="id" id="ticketId">
                    <input type="hidden" name="ticketStatus" id="ticketStatus">
                    <textarea name="developerComment" id="developerComment" class="form-control" cols="30" rows="7" required></textarea>
                    <div class="mt-2 text-right">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
