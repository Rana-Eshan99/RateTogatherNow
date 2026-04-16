<!-- Modal -->
<div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="max-width: 412px; margin: auto; border-radius: 8px;">
            <div class="modal-body text-center">
                <div class="form-group">
                    <!-- Image at the top center -->
                    <img src="{{ asset('img/iconOrganizationRateSubmitted.png') }}" alt="Image"
                        style="height: 152px; width: 227px; margin-top: 32px;">
                </div>
                <div class="form-group" style="margin: 32px 0;">
                    <!-- Heading -->
                    <span style="font-size: 18px; color:#101828; font-weight: 600;">
                        Feedback Submitted
                    </span>
                    <!-- Message -->
                    <p id="message" style="font-size: 14px; color: #475467; font-weight: 400; margin-top: 4px;">
                        Thanks for submitting the feedback.
                    </p>
                </div>

                <hr style="margin-bottom: 30px;">
                <div class="form-group " style="margin-bottom: 24px;">
                    <!-- Close button -->
                    <button type="button" id="btnClose"
                        class="btn btn-primary btn-block customBorderRadius btnHeight customBtnColor btnCus"
                        style="font-size: 16px; font-weight:600">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
