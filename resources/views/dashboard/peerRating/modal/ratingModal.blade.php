<!-- Modal -->
<div class="modal fade" id="peerRatingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 1124px;" role="document">
        <div class="modal-content " style="max-width: 1124px; margin: auto; border-radius: 8px;">
            <div class="modal-body text-center py-4">
                <div class="form-group d-flex justify-content-between mb-0">
                    <h3 class="mt-2" style="font-family: 'Source Sans 3', sans-serif;">Peer Review <span
                            class="rating">3.5</span></h3>
                    <button class="closeBtn">
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M1.79996 11.8333L0.166626 10.2L4.36663 5.99997L0.166626 1.82913L1.79996 0.195801L5.99996 4.3958L10.1708 0.195801L11.8041 1.82913L7.60413 5.99997L11.8041 10.2L10.1708 11.8333L5.99996 7.6333L1.79996 11.8333Z"
                                fill="#DC143C" />
                        </svg>
                    </button>
                </div>

                <input type="hidden" name="ratingId" id="ratingId">
                <div class="form-group">
                    <!-- Heading -->
                    <p class="ratingText longText"></p>

                </div>
                <div class="row">
                    <div class="col-xl-6 col-md-12 col-12 pb-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="user-rating-title">How easy was it to work with this peer?</p>
                            <div class="easyWork d-flex align-items-center">

                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">

                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">

                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">

                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">

                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-12 col-12 pb-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="user-rating-title"> Would you want to work with this peer again?</p>
                            <div class="workAgain d-flex align-items-center">
                                <div class="box green"></div>
                                <span class="boxSpan">Yes</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-xl-6 col-md-12 col-12 pb-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="user-rating-title">How dependable is this peer in their work habits?</p>
                            <div class="dependableWork d-flex align-items-center">

                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">

                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">

                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">

                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">

                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-12 col-12 pb-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="user-rating-title"> How well does this peer communicate when under pressure?</p>
                            <div class="communicateUnderPressure d-flex align-items-center">
                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">

                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">

                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">

                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">

                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">
                            </div>
                        </div>
                    </div>

                </div>


                <div class="row mt-3">
                    <div class="col-xl-6 col-md-12 col-12 pb-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="user-rating-title">How often does this peer meet deadlines?</p>
                            <div class="meetDeadline d-flex align-items-center">

                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">

                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">

                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">

                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">

                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-12 col-12 pb-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="user-rating-title">How open is this peer to receiving feedback?</p>
                            <div class="receivingFeedback d-flex align-items-center">
                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">

                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">

                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">

                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">

                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row mt-3">
                    <div class="col-xl-6 col-md-12 col-12 pb-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="user-rating-title">How respectful is this peer towards others?</p>
                            <div class="respectfullOther d-flex align-items-center">

                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">

                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">

                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">

                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">

                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-12 col-12 pb-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="user-rating-title">How often does this peer assist others when needed?</p>
                            <div class="assistOther d-flex align-items-center">
                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">

                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">

                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">

                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">

                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">
                            </div>
                        </div>
                    </div>

                </div>


                <div class="row mt-3">
                    <div class="col-xl-6 col-md-12 col-12 pb-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="user-rating-title">How well does this peer collaborate with the team?</p>
                            <div class="collaborateTeam d-flex align-items-center">

                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">

                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">

                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">

                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">

                                <img src="{{ asset('img/star.svg') }}" height="26" width="26">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group d-flex justify-content-center mb-1">
                    <!-- Heading -->
                    <button type="button" class="btn mb-1 approveBtn" id="approveBtn"
                        style="background-color: #34A853;color: #FFFFFF; width: 81px; height: 32px; font-weight: 600; border-radius: 5px;">Approve</button>
                    <button type="button" id="rejectBtn" class="btn ml-2 mb-1 rejectBtn"
                        style="background-color:#F5F5F5;width: 81px; height: 32px; font-weight: 600; border-radius: 5px;color: #DC143C;">Reject</button>
                </div>
            </div>
        </div>
    </div>
</div>
