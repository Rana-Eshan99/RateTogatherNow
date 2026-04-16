<!-- Modal -->
<div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content customBorderRadius" style="width: 472px">
            <div class="modal-body text-center customBorderRadius">
                <div class="form-group">
                    <!-- Image at the top center -->
                    <img src="{{ asset('img/iconOrganizationRateSubmitted.png') }}" alt="Image"
                        style="height: 152px; width: 227px; margin-top:32px;">
                </div>
                <div class="form-group" style="margin-bottom: 32px; margin-top:32px;">
                    <!-- heading -->
                    <span style="font-size: 18px; color:#101828; font-weight:600;">
                        Review Submitted
                    </span>
                    <!-- Message -->
                    <span id="message" style="font-size: 14px; color: #475467; font-weight:400">
                        <p style="margin-top:4px">We value your feedback. It will be available to all users after <br>our team has reviewed your rating.</p>
                    </span>
                </div>

                <div class="form-group row" style="margin-bottom: 24px;">
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
