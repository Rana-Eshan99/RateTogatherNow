<div class="modal fade" id="view" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="max-width: 1200px;">
        <div class="modal-content" style=" max-width: 1200px; margin: auto; border-radius: 8px;">
            <div class="modal-body p-3">

                <!-- Header Section -->
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <strong class="text-dark mianTile">Anonymous</strong>
                        <span class="points" id="points"></span> <!-- Corrected ID -->
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <img src="{{ asset('img/icons/closeIcon.svg') }}" alt="" height="12px"  width="12px">
                    </button>
                </div>

                <!-- Review Content -->
                <p class="mb-3 experienceCustom" id="expericeFeedback">

                </p>

                <!-- Rating Criteria -->
                <div class="row pl-2 pr-2">
                    <div class="col-md-6 col-12 mb-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="user-rating-title mb-0">Company Culture</p>
                            <div class="star-rating" id="companyCultureRatingContainer">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 mb-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="user-rating-title mb-0">Career Development  Opportunities</p>
                            <div class="star-rating" id="careerDevelopmentRatingContainer">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row pl-2 pr-2">
                    <div class="col-md-6 col-12 mb-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="user-rating-title mb-0">Work-life Balance</p>
                            <div class="star-rating" id="workLifeBalanceContainer">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 mb-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="user-rating-title mb-0">Compensation and Benefits</p>
                            <div class="star-rating" id="compensationBenefitRatingContainer">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row pl-2 pr-2">
                    <div class="col-md-6 col-12 mb-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="user-rating-title mb-0">Job Stability</p>
                            <div class="star-rating" id="jobStabilityContainer">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 mb-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="user-rating-title mb-0">Workplace Diversity, Equity, and Inclusion</p>
                            <div class="star-rating" id="workplaceDEIContainer">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row pl-2 pr-2">
                    <div class="col-md-6 col-12 mb-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="user-rating-title mb-0">Employee Happiness</p>
                            <div class="star-rating" id="employeeHappynessRatingContainer">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 mb-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="user-rating-title mb-0">Company Reputation</p>
                            <div class="star-rating" id="companyReputationRatingContainer">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row pl-2 pr-2">
                    <div class="col-md-6 col-12 mb-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="user-rating-title mb-0">Workplace Safety and Security</p>
                            <div class="star-rating" id="workplaceSSContainer">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 mb-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="user-rating-title mb-0">Company Growth and Future Plans</p>
                            <div class="star-rating" id="growthFuturePlanContainer">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reported By Section -->
                <div class="mt-1 pl-2 pr-2">
                    <p class="secoundTile">Reported By <a href="#" class="secoundName" id="reportedPerson"></a></p>
                    <p class="secoundDiscription" id="report"></p>
                </div>

                <!-- Delete Button Section -->
                <div class="text-center mt-2 mb-2 pl-2 pr-2">
                        <button type="button" class="delete-btn" data-toggle="modal" data-target="#delete" >
                            <img src="{{ asset('img/icons/deleteutton.svg') }}" alt="Delete Icon">
                            <span   class="del">Delete</span>
                        </button>
                        <button type="button" class="keep-btn" data-toggle="modal" data-target="#keep" >
                            <span class="keep">Keep</span>
                        </button>

                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="careerDevelopmentRating" name="careerDevelopmentRating">
<input type="hidden" id="companyCultureRating" name="companyCultureRating">
<input type="hidden" id="companyReputationRating" name="companyReputationRating">
<input type="hidden" id="compensationBenefitRating" name="compensationBenefitRating">
<input type="hidden" id="employeeHappynessRating" name="employeeHappynessRating">
<input type="hidden" id="growthFuturePlanRating" name="growthFuturePlanRating">
<input type="hidden" id="jobStabilityRating" name="jobStabilityRating">
<input type="hidden" id="workLifeBalanceRating" name="workLifeBalanceRating">
<input type="hidden" id="workplaceDEIRating" name="workplaceDEIRating">
<input type="hidden" id="workplaceSSRating" name="workplaceSSRating">
<input type="hidden" id="deleteId" name="deleteId" value="123"> <!-- Initial hidden input where the ID is set -->
<input type="hidden" id="keepId" name="keepId" value="123"> <!-- Initial hidden input where the ID is set -->
<input type="hidden" id="deleteId1" name="deleteId1"> <!-- Hidden input where the value will be copied -->
<input type="hidden" id="keepId1" name="keepId1"> <!-- Hidden input where the value will be copied -->

