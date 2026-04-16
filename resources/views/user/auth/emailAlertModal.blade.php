<!-- Modal -->
<div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content customBorderRadius" style="width: auto">
            <div class="modal-body text-center customBorderRadius">
                <!-- Image at the top center -->
                <img src="{{ asset('img/modalIcon/alertModalStarIcon.svg') }}" alt="Image"
                    style="width: 60px; height: 60px; border-radius: 50%;">

                <br>
                <br>
                <!-- Invalid Email heading -->
                <h4>Warning</h4>

                <br>
                <!-- Message -->
                <span id="message" class=""></span>

                <!-- Horizontal line -->
                <hr>

                <!-- OK and Cancel buttons in a line and block buttons -->
                <div class="form-group row">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-primary btn-block customBorderRadius"
                            id="okButton">OK</button>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-default btn-block customBorderRadius"
                            data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
