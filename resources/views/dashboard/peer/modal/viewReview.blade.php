<div class="modal fade" id="view" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="max-width: 1200px;">
        <div class="modal-content" style=" max-width: 1200px; margin: auto; border-radius: 8px;">
            <div class="modal-body p-3">

                <!-- Header Section -->
                <div class="d-flex justify-content-between align-items-center mb-2 mt-3">
                    <div>
                        <strong class="text-dark mianTile">Peer Review</strong>
                        <span class="points" id="points"></span> <!-- Corrected ID -->
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <img src="{{ asset('img/icons/closeIcon.svg') }}" alt="" height="12px" width="12px">
                    </button>
                </div>

                <!-- Review Content -->
                <p class=" experienceCustom" id="expericeFeedback">

                </p>

                <!-- How easy was it to work with this peer? &  Would you want to work with this peer again? -->
                <div class="row  mt-3">
                    <div class="col-md-6 col-12 ">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="user-rating-title mb-0">How easy was it to work with this peer?</p>
                            <div class="star-rating" id="easyWorkContainer">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 ">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="user-rating-title mb-0" style="padding-top: 13px;">Would you want to work with
                                this peer again?</p>
                            <div class="d-flex align-items-center" id="workAgainContainer" style="padding-top: 9px;"></div>
                        </div>
                    </div>
                </div>

                <!-- How well does this peer communicate under pressure? & How dependable is this peer's work? -->
                <div class="row  mt-3" style="padding-top: 5px;">
                    <div class="col-md-6 col-12 ">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="user-rating-title mb-0">How dependable is this peer in their work habits?</p>
                            <div class="star-rating" id="dependableWorkContainer">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 ">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="user-rating-title mb-0">How well does this peer communicate when under pressure?
                            </p>
                            <div class="star-rating" id="communicateUnderPressureContainer">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- How often does this peer meet deadlines? & How open is this peer to receiving feedback? -->
                <div class="row  mt-3" style="padding-top: 5px;">
                    <div class="col-md-6 col-12 ">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="user-rating-title mb-0">How often does this peer meet deadlines?</p>
                            <div class="star-rating" id="meetDeadlineContainer">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 ">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="user-rating-title mb-0">How open is this peer to receiving feedback?</p>
                            <div class="star-rating" id="receivingFeedbackContainer">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- How respectful is this peer towards others? & How often does this peer assist others when needed? -->
                <div class="row  mt-3" style="padding-top: 5px;">
                    <div class="col-md-6 col-12 ">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="user-rating-title mb-0">How respectful is this peer towards others?</p>
                            <div class="star-rating" id="respectfullOtherContainer">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 ">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="user-rating-title mb-0">How often does this peer assist others when needed?</p>
                            <div class="star-rating" id="assistOtherContainer">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- How well does this peer collaborate with the team? -->
                <div class="row mt-3 mb-4" style="padding-top: 5px;" >
                    <div class="col-md-6 col-12 ">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="user-rating-title mb-0">How well does this peer collaborate with the team?</p>
                            <div class="star-rating" id="collaborateTeamContainer">
                            </div>
                        </div>
                    </div>
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
