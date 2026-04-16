@foreach ($usersRating as $rating)
    <div class="col-xl-4 col-lg-4 col-md-5 col-12 p-2">
        <div class="row">
            <div class="col-12 d-flex align-items-top">
                <!-- Random Background color for Anonymous -->
                @php
                    // Array of possible background colors
                    $backgroundColors = ['#B6BC9E', '#F4BC81', '#81BDC3'];
                    // Select a random color
                    $randomColor = $backgroundColors[array_rand($backgroundColors)];
                @endphp

                <!-- Initials Shown here -->
                <div class="initialsInsideDivs" style="background-color:{{ $randomColor }};">
                    <label>AY</label>
                </div>
                <div class="organization-name pl-3">
                    <div class="d-flex align-items-center">
                        <h3 class="user-name mb-0 mr-2">Anonymous</h3>
                        @if ($rating->userId != null)
                            <img src="{{ asset('img/overallRatingIcons/verified.png') }}" height="24" width="24"
                                alt="verified">
                        @endif
                    </div>
                    @php
                        $totalScore =
                            $rating->companyCulture +
                            $rating->careerDevelopment +
                            $rating->workLifeBalance +
                            $rating->compensationBenefit +
                            $rating->jobStability +
                            $rating->workplaceDEI +
                            $rating->employeeHappyness +
                            $rating->companyReputation +
                            $rating->workplaceSS +
                            $rating->growthFuturePlan;
                        $criteriaCount = 10; // Total number of criteria
                        $averageRating = $totalScore / $criteriaCount;
                    @endphp
                    <span class="star-filled user-star">&#9733;</span>
                    <span class="user-rates">{{ number_format($averageRating, 1) }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-8 col-lg-8 col-md-7 col-12 p-2">
        <div class="row">
            <div class="col-12">
                <span style="font-weight: 500; font-size: 16px; color: #161617;">
                    {{ \Carbon\Carbon::parse($rating->createdAt)->format('F j, Y') }}
                </span>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12" style="font-weight: 500; font-size: 16px; color: rgba(88, 88, 93, 1);">
                {{ $rating->experience }}
            </div>
        </div>
        <!-- Criteria Sections -->
        <div class="row mt-3">
            <div class="col-xl-6 col-md-12 col-12">
                <div class="d-flex align-items-center justify-content-between">
                    <p class="user-rating-title manage-spacings">Company Culture</p>
                    <div class="star-rating d-flex align-items-center">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="star user-star-rating {{ $rating->companyCulture >= $i ? 'filled' : '' }}"
                                title="{{ $i }} Stars">&#9733;</span>
                        @endfor
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-12 col-12">
                <div class="d-flex align-items-center justify-content-between">
                    <p class="user-rating-title manage-spacings">Career Development Opportunities</p>
                    <div class="star-rating d-flex align-items-center">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="star user-star-rating {{ $rating->careerDevelopment >= $i ? 'filled' : '' }}"
                                title="{{ $i }} Stars">&#9733;</span>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
        <!-- Continue similar blocks for other criteria -->
        <div class="row">
            <div class="col-xl-6 col-md-12 col-12">
                <div class="d-flex align-items-center justify-content-between">
                    <p class="user-rating-title manage-spacings">Work-life Balance</p>
                    <div class="star-rating d-flex align-items-center">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="star user-star-rating {{ $rating->workLifeBalance >= $i ? 'filled' : '' }}"
                                title="{{ $i }} Stars">&#9733;</span>
                        @endfor
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-12 col-12">
                <div class="d-flex align-items-center justify-content-between">
                    <p class="user-rating-title manage-spacings">Compensation and Benefits</p>
                    <div class="star-rating d-flex align-items-center">
                        @for ($i = 1; $i <= 5; $i++)
                            <span
                                class="star user-star-rating {{ $rating->compensationBenefit >= $i ? 'filled' : '' }}"
                                title="{{ $i }} Stars">&#9733;</span>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
        <!-- Continue similar blocks for other criteria -->
        <div class="row">
            <div class="col-xl-6 col-md-12 col-12">
                <div class="d-flex align-items-center justify-content-between">
                    <p class="user-rating-title manage-spacings">Job Stability</p>
                    <div class="star-rating d-flex align-items-center">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="star user-star-rating {{ $rating->jobStability >= $i ? 'filled' : '' }}"
                                title="{{ $i }} Stars">&#9733;</span>
                        @endfor
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-12 col-12">
                <div class="d-flex align-items-center justify-content-between">
                    <p class="user-rating-title manage-spacings">Workplace Diversity, Equity and Inclusion</p>
                    <div class="star-rating d-flex align-items-center">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="star user-star-rating {{ $rating->workplaceDEI >= $i ? 'filled' : '' }}"
                                title="{{ $i }} Stars">&#9733;</span>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
        <!-- Continue similar blocks for other criteria -->
        <div class="row">
            <div class="col-xl-6 col-md-12 col-12">
                <div class="d-flex align-items-center justify-content-between">
                    <p class="user-rating-title manage-spacings">Employee Happiness</p>
                    <div class="star-rating d-flex align-items-center">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="star user-star-rating {{ $rating->employeeHappyness >= $i ? 'filled' : '' }}"
                                title="{{ $i }} Stars">&#9733;</span>
                        @endfor
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-12 col-12">
                <div class="d-flex align-items-center justify-content-between">
                    <p class="user-rating-title manage-spacings">Company Reputation</p>
                    <div class="star-rating d-flex align-items-center">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="star user-star-rating {{ $rating->companyReputation >= $i ? 'filled' : '' }}"
                                title="{{ $i }} Stars">&#9733;</span>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
        <!-- Continue similar blocks for other criteria -->
        <div class="row">
            <div class="col-xl-6 col-md-12 col-12">
                <div class="d-flex align-items-center justify-content-between">
                    <p class="user-rating-title manage-spacings">Workplace Safety and Security</p>
                    <div class="star-rating d-flex align-items-center">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="star user-star-rating {{ $rating->workplaceSS >= $i ? 'filled' : '' }}"
                                title="{{ $i }} Stars">&#9733;</span>
                        @endfor
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-12 col-12">
                <div class="d-flex align-items-center justify-content-between">
                    <p class="user-rating-title manage-spacings">Company Growth and Future Plans</p>
                    <div class="star-rating d-flex align-items-center">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="star user-star-rating {{ $rating->growthFuturePlan >= $i ? 'filled' : '' }}"
                                title="{{ $i }} Stars">&#9733;</span>
                        @endfor
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 d-flex justify-content-between">
                <div class="d-flex align-items-center">
                    <span style="font-weight: 500; font-size: 16px; color: #58585D; margin-right: 20px;">Helpful</span>

                    <form action="{{ route('user.organization.helpful.saveHelpfulOrganization') }}" class="helpful"
                        method="POST" id="helpfulForm_{{ $rating->id }}">
                        @csrf
                        <input type="hidden" name="visitorId" id="visitorId" data-id="{{ $rating->id }}" />
                        <input type="hidden" name="helpfulOrganizationRatingId"
                            id="helpfulOrganizationRatingId_{{ $rating->id }}" value="{{ $rating->id }}"
                            readonly>

                        <div class="d-flex align-items-center">
                            <!-- Thumbs Up -->
                            <a href="#" class="thumbs-up d-flex align-items-center"
                                data-id="{{ $rating->id }}" style="text-decoration: none;"
                                onclick="return false;">
                                @if (is_null($rating->helpfulStatus) || $rating->helpfulStatus == 0)
                                    <img src="{{ asset('img/overallRatingIcons/thumpsup.png') }}" alt="thumbs-up"
                                        class="me-2" id="thumbsUp_{{ $rating->id }}">
                                @elseif ($rating->helpfulStatus == 1)
                                    <img src="{{ asset('img/overallRatingIcons/thumpsupGreen.png') }}"
                                        alt="green-thumbs-up" class="me-2" id="thumbsUp_{{ $rating->id }}">
                                @endif
                            </a>

                            <span id="thumbsUpCount_{{ $rating->id }}" class="ms-1"
                                style="margin-top: 4px; font-size: 18px; margin-left: 7px; color: #58585D; margin-right: 15px;">
                                {{ $rating->helpfulCount ?? 0 }}
                            </span>

                            <!-- Thumbs Down -->
                            <a href="#" class="thumbs-down d-flex align-items-center ms-3"
                                data-id="{{ $rating->id }}" style="text-decoration: none;"
                                onclick="return false;">
                                @if (is_null($rating->helpfulStatus) || $rating->helpfulStatus == 1)
                                    <img src="{{ asset('img/overallRatingIcons/thumbsdown.png') }}" alt="thumbs-down"
                                        class="me-2" id="thumbsDown_{{ $rating->id }}">
                                @elseif ($rating->helpfulStatus == 0)
                                    <img src="{{ asset('img/overallRatingIcons/thumbsdownRed.png') }}"
                                        alt="red-thumbs-down" class="me-2" id="thumbsDown_{{ $rating->id }}">
                                @endif
                            </a>
                            <span id="thumbsDownCount_{{ $rating->id }}" class="ms-1"
                                style="margin-top: 5px; font-size: 18px; color: #58585D; margin-left: 7px;">
                                {{ $rating->notHelpfulCount ?? 0 }}
                            </span>
                        </div>
                    </form>

                </div>

                <div class="d-flex align-items-center">
                    <a href="{{ route('user.organization.organizationReportRatingForm', ['organization_peerRatingId' => $rating->id]) }}"
                        class="btnAddFeedback">

                        @if ($rating->report == true)
                            <img src="{{ asset('img/overallRatingIcons/feedbackOrange.png') }}" alt="feedback"
                                height="24" width="24">
                        @else
                            <img src="{{ asset('img/overallRatingIcons/feedback.png') }}" alt="feedback"
                                height="24" width="24">
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <hr>
    </div>
@endforeach
<!-- Pagination Links -->
<div class="col-12 d-flex justify-content-end">
    @if ($usersRating && $usersRating->count())
        {{ $usersRating->links('user.pagination.customPagination') }}
    @endif
</div>
<!-- /............. Pagination Links -->
