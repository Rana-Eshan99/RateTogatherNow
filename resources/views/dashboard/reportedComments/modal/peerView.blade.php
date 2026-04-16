<div class="modal fade" id="view-peer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="max-width: 1200px;">
        <div class="modal-content" style=" max-width: 1200px; margin: auto; border-radius: 8px;">
            <div class="modal-body p-3">

                <!-- Header Section -->
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <strong class="text-dark mianTile">Anonymous</strong>
                        <span class="points" id="points-peer"></span> <!-- Corrected ID -->
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <img src="{{ asset('img/icons/closeIcon.svg') }}" alt="" height="12px"  width="12px">
                    </button>
                </div>

                <!-- Review Content -->
                <p class="mb-3 experienceCustom" id="peerExpericeFeedback">

                </p>

                <!-- Rating Criteria -->
                <div class="row pl-2 pr-2">
                    <div class="col-md-6 col-12 mb-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="user-rating-title mb-0">How easy was it to work with this peer?</p>
                            <div class="star-rating" id="easyWorkContainer">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 mb-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="user-rating-title mb-0 mt-2" style="padding-top: 7px;">Would you want to work with this peer again?</p>
                            <div class="d-flex align-items-center" id="workAgainContainer"></div>
                        </div>
                    </div>
                </div>
                    <div class="row pl-2 pr-2">
                        <div class="col-md-6 col-12 mb-1">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="user-rating-title mb-0">How dependable is this peer in their work habits?</p>
                                <div class="star-rating" id="dependableWorkContainer">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 mb-1">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="user-rating-title mb-0"> How well does this peer communicate when under
                                    pressure?</p>
                                <div class="star-rating" id="communicateUnderPressureContainer">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row pl-2 pr-2">
                        <div class="col-md-6 col-12 mb-1">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="user-rating-title mb-0">How often does this peer meet deadlines?</p>
                                <div class="star-rating" id="meetDeadlineContainer">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 mb-1">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="user-rating-title mb-0">How open is this peer to receiving feedback?</p>
                                <div class="star-rating" id="receivingFeedbackContainer">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row pl-2 pr-2">
                        <div class="col-md-6 col-12 mb-1">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="user-rating-title mb-0">How respectful is this peer towards others?</p>
                                <div class="star-rating" id="respectfullOtherContainer">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 mb-1">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="user-rating-title mb-0">How often does this peer assist others when needed?
                                </p>
                                <div class="star-rating" id="assistOtherContainer">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row pl-2 pr-2">
                        <div class="col-md-6 col-12 mb-1">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="user-rating-title mb-0">How well does this peer collaborate with the team?</p>
                                <div class="star-rating" id="collaborateTeamContainer">
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Reported By Section -->
                    <div class="mt-1 pl-2 pr-2">
                        <p class="secoundTile">Reported By <a href="#" class="secoundName"
                                id="reportedPersonPeer"></a></p>
                        <p class="secoundDiscription" id="peerReport"></p>
                    </div>

                    <!-- Delete Button Section -->
                    <div class="text-center mt-2 mb-2 pl-2 pr-2">
                        <button type="button" class="delete-peer-btn" id="peerDelete" data-toggle="modal" data-target="#delete">
                            <img src="{{ asset('img/icons/deleteutton.svg') }}" alt="Delete Icon">
                           <span class="del">Delete</span>
                        </button>

                        <button type="button" class="keep-peers-btn" data-toggle="modal" data-target="#keep-peers" >
                            <span class="keep">Keep</span>
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="assistOther" name="assistOther">
    <input type="hidden" id="collaborateTeam" name="collaborateTeam">
    <input type="hidden" id="communicateUnderPressure" name="communicateUnderPressure">
    <input type="hidden" id="dependableWork" name="dependableWork">
    <input type="hidden" id="easyWork" name="easyWork">
    <input type="hidden" id="meetDeadline" name="meetDeadline">
    <input type="hidden" id="receivingFeedback" name="receivingFeedback">
    <input type="hidden" id="respectfullOther" name="respectfullOther">
    <input type="hidden" id="workAgain" name="workAgain">
    <input type="hidden" id="deleteIdPeer" name="deleteIdPeer" value="123">
    <input type="hidden" id="keepIdPeer" name="keepIdPeer" value="123">
    <input type="hidden" id="deleteIdPeer2" name="deleteIdPeer2"> <!-- Hidden input where the value will be copied -->
    <input type="hidden" id="keepIdPeer2" name="keepIdPeer2"> <!-- Hidden input where the value will be copied -->

