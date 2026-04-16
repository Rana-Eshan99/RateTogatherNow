<!-- Modal -->
<div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content customBorderRadius" style="width: auto">
            <div class="modal-body text-center customBorderRadius">
                <div class="form-group" style="margin-bottom: 32px; margin-top:32px">
                    <!-- Image at the top center -->
                    <img src="{{ asset('img/iconsSccessModal.png') }}" alt="Image"
                        style="width: 76px; height: 76px; border-radius: 50%;">
                </div>

                <div class="form-group" style="margin-bottom: 32px">
                    <!-- heading -->
                    <span style="font-size: 18px; color:#101828; font-weight:600;">
                        Thanks for adding a new peer.
                    </span>
                    <!-- Message -->
                    <span id="message" style="font-size: 14px; font-weight:400 ;color: #475467;">
                        <p style="margin-top: 4px;">Admin will review your submitted details, after <br>
                            approval this peer will be listed to our user.
                        </p>
                    </span>

                </div>

                <!-- Horizontal line -->
                <hr
                    style="margin-right: 0px; margin-left: -15px; margin-bottom: 24px; width: 100%; padding-right: inherit; padding-left: inherit;">

                <div class="form-group row" style="margin-bottom: 24px">
                    <!-- OK and Cancel buttons in a line and block buttons -->
                    <div class="col">
                        <button type="button" id="btnClose"
                            class="btn btn-primary btn-block customBorderRadius btnHeight customBtnColor"
                            style="font-size: 16px; font-weight:600">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
