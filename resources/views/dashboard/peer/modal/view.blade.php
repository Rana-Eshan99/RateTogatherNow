<div class="modal fade" id="view" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="max-width: 533px;">
        <div class="modal-content" style=" max-width: 533px; margin: auto; border-radius: 0px;">
            <div class="modal-body p-3 customChanges">

                <!-- Header with Peer Detail and Status Badge -->
                <div class="row align-items-center">
                    <!-- Peer Detail -->
                    <div class="col-8 col-md-4 pr-0">
                        <strong class="text-dark mainTile">Peer Detail</strong>
                    </div>

                    <!-- Pending Approval Badge -->
                    <div class="col-8 col-md-6 text-md-left changeCustomPadding">
                        <span class="badge badge-pill text-dark px-2 py-1 fontManages"
                              style="font-weight: 600; font-size: 16px; border-radius: 8px; background-color:#FFD700;">
                            Pending Approval
                        </span>
                    </div>

                    <!-- Close Icon -->
                    <div class="col-4 col-md-2 text-right">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border: none; background: none;">
                            <img src="{{ asset('img/icons/closeIcon.svg') }}" alt="Close" height="12px" width="12px">
                        </button>
                    </div>
                </div>



                <!-- Peer Information Fields -->
                <div class="mt-4 changePadding">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group marignCustom">
                                <label for="org-name" class="feildTitle">Name</label>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <input type="text" class="form-control" id="org-name" name="PeerName" disabled style="background-color: #ffffff; color: #000000;;">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group marignCustom">
                                <label for="org-name" class="feildTitle">Organization</label>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <input type="text" class="form-control" id="org-name" name="PeerOrganization" disabled style="background-color: #ffffff; color: #000000;;">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group marignCustom">
                                <label for="org-name" class="feildTitle">Department</label>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <input type="text" class="form-control" id="org-name" name="PeerDepartment" disabled style="background-color: #ffffff; color: #000000;;">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group marignCustom">
                                <label for="org-name" class="feildTitle">Job Title</label>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <input type="text" class="form-control" id="org-name" name="PeerJobTitle" disabled style="background-color: #ffffff; color: #000000;;">
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Action Buttons -->
                <div class="text-center mt-0">
                    <button type="button" class="btn mb-1 confirm" id="confirmApproved" style="background-color: #34A853;color: #FFFFFF; width: 81px; height: 32px; font-weight: 600; border-radius: 5px;">Approve</button>
                    <button type="button" class="btn ml-2 mb-1 rejected" style="background-color:#F5F5F5;width: 81px; height: 35px; font-weight: 600; border-radius: 5px;color: #DC143C;">Reject</button>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="PeerId" name="PeerId">
