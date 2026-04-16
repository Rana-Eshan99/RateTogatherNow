<!-- Modal -->
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="max-width: 412px; margin: auto; border-radius: 8px;">
            <div class="modal-body text-center">
                <div class="form-group" >
                    <div class="row">
                        <div class="col-6">
                            <h5 class="modal-title" id="myModalLabel" style="margin-top: 4px; color:#000000;font-size: 24px; font-weight: 600; font-family: \'Source Sans 3\', sans-serif;">Confirmation</h5>
                        </div>
                        <div class="col-6">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                style="margin-top: 8px;">
                                <img src="{{ asset('img/icons/closeIcon.svg') }}" alt="" height="10px"  width="10px">
                            </button>
                        </div>
                    </div>
                </div>
                <div class="form-group" style="margin-top: 16px;">
                    <p class="text-center" style="font-size: 16px; font-weight: 400; font-family: \'Source Sans 3\', sans-serif;">Are you sure that you want to delete this comment?</p>
                </div>
                <div class="form-group accent-blue" style="margin-top: 16px;">
                    <input type="hidden" name="deleteId" id="deleteId">
                    <a href="javascript:void(0)" class="delete btn" id="confirmDelete" style="background-color: #DC143C; width: 81px; height: 32px; border: none; border-radius: 5px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;">
                        <span style="font-size: 16px; font-weight: 600; font-family: 'Source Sans 3', sans-serif; color: #FFFFFF;">Yes</span>
                    </a>
                    <a href="javascript:void(0)" data-dismiss="modal" aria-label="Close" class="cancel btn" id="cancelDelete" style="background-color: #F5F5F5; color: #DC143C; width: 81px; height: 32px; border-radius: 5px; display: inline-flex; align-items: center; justify-content: center; margin-left: 8px; text-decoration: none;">
                        <span aria-hidden="true" style="font-size: 16px; font-weight: 600; font-family: 'Source Sans 3', sans-serif;">Cancel</span>
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
