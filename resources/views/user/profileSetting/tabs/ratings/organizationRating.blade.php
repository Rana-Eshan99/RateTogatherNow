<!-- My Rating-Organizations content goes here -->
<!-- 1st Heading Row -->
<div class="row" style="margin-bottom: 20px;">
    <div class="col">
        <span class="cardHeading" id="myOrganizationRatingCount">
            {{ $dataOrganizationRated['count'] }}
        </span>
    </div>
</div>

@if ($dataOrganizationRated['count'] == 'Organization Rating')
    <div class="col mb-2">
        <div class="card" style="height: 320px; align-items: center;">
            <div class="card-body" style="align-content: center;">
                <span style="font-size:16px; color: #00000080;">No Organization Found!</span>
            </div>
        </div>
    </div>
@endif


@foreach ($dataOrganizationRated['organizations'] as $organization)
    <!-- My Rating-Organization Here -->
    <div class="form-group row">
        <div class="col-lg-3 col-md-4 col-sm-6 d-flex flex-wrap">
            <!-- Create the Organization Info Card Using loop -->
            {{-- align-content: flex-start;flex-wrap: wrap; --}}
            <div class="d-flex orgResponsive">
                <img src="{{ $organization['organization']->getImageFullUrlAttribute() }}" alt="Logo"
                    style="height: 64px; width: 64px; border-radius: 50%; border: solid; border-color: aliceblue; object-fit: cover; margin-right: 20px;"
                    onerror="this.onerror=null;this.src='{{ asset('img/organizationDefaultAvatar.png') }}';">

                <a class="text-decoration-none"
                    href="{{ route('user.organization.show', ['id' => $organization['organization']->id]) }}">
                    <!-- Organization Info -->
                    <div class="organization-info">
                        <div class="d-flex align-items-center row">
                            <div class="col-9 organizationName" title="{{ $organization['organization']->name }}">
                                {{ $organization['organization']->name }}
                            </div>
                            <div class="col-3 d-flex">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col organizationAddress" title="{{ $organization['organization']->address }}">
                                {{ $organization['organization']->address }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="overAllRatingStar" title="Overall Rating"
                                    style="font-weight: 700; font-size: 28px; color: #F9C154;">&#9733;</label>
                                <span style="color: #161617; font-size: 32px; font-weight: 500;">
                                    {{ $organization['overAllRating'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- /...............  Ends Organization info Card Using loop -->
        </div>


        <div class="col-lg-9 col-md-8 col-sm-6">
            <!--- Creation Date -->
            <div class="row">
                <div class="col">
                    <span style="font-size: 16px; font-weight:500; color: #161617;">
                        {{ \Carbon\Carbon::parse($organization['organization']->createdAt)->format('F j, Y') }}
                    </span>
                </div>
            </div>

            <!-- Experience -->
            <div class="row" style="margin-bottom: 16px">
                <div class="col">
                    <span style="font-size: 16px; font-weight:500; color: #58585D;">
                        {{ $organization['ratings']->experience }}
                    </span>
                </div>

            </div>

            <!-- Rating Stars -->
            <!-- Company Culture - Carrer Development Opportunities Row -->
            <div class="row align-items-center" style="margin-bottom: 16px;">
                <div class="col-xl-4 col-lg-9 col-md-6 col-sm-6 col-6">
                    <span class="text-justify myRatingOrganizationLabel">Company Culture</span>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6 star-rating-org disabled">
                    @php
                        $companyCultureRating = (int) $organization['ratings']['companyCulture'];
                    @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="star user-star-rating-org {{ $companyCultureRating >= $i ? 'filled' : '' }}"
                            title="{{ $i }} Stars">&#9733;</span>
                    @endfor
                </div>

                <!-- Carrer Development Opportunities -->
                <div class="col-xl-4 col-lg-9 col-md-6 col-sm-6 col-6">
                    <span class="text-justify myRatingOrganizationLabel">
                        Career Development Opportunities
                    </span>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6 star-rating-org disabled">
                    @php
                        $careerDevelopmentRating = (int) $organization['ratings']['careerDevelopment'];
                    @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="star user-star-rating-org {{ $careerDevelopmentRating >= $i ? 'filled' : '' }}"
                            title="{{ $i }} Stars">&#9733;</span>
                    @endfor
                </div>
            </div>

            <!-- Work-Life Balance - Compensation and Benefits Row -->
            <div class="row align-items-center" style="margin-bottom: 16px;">
                <!-- Work-Life Balance -->
                <div class="col-xl-4 col-lg-9 col-md-6 col-sm-6 col-6">
                    <span class="text-justify myRatingOrganizationLabel">
                        Work-Life Balance
                    </span>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6 star-rating-org disabled">
                    @php $workLifeBalanceRating = (int) $organization['ratings']['workLifeBalance']; @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="star user-star-rating-org {{ $workLifeBalanceRating >= $i ? 'filled' : '' }}"
                            title="{{ $i }} Stars">&#9733;</span>
                    @endfor
                </div>

                <!-- Compensation and Benefits -->
                <div class="col-xl-4 col-lg-9 col-md-6 col-sm-6 col-6">
                    <span class="text-justify myRatingOrganizationLabel">
                        Compensation and Benefits
                    </span>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6 star-rating-org disabled">
                    @php $compensationBenefitsRating = (int) $organization['ratings']['compensationBenefit']; @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="star user-star-rating-org {{ $compensationBenefitsRating >= $i ? 'filled' : '' }}"
                            title="{{ $i }} Stars">&#9733;</span>
                    @endfor
                </div>
            </div>

            <!-- Job Stability - Workplace Diversity, Equity and Inculsion Row -->
            <div class="row align-items-center" style="margin-bottom: 16px;">
                <!-- Job Stability  -->
                <div class="col-xl-4 col-lg-9 col-md-6 col-sm-6 col-6">
                    <span class="text-justify myRatingOrganizationLabel">
                        Job Stability
                    </span>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6 star-rating-org disabled">
                    @php $jobStabilityRating = (int) $organization['ratings']['jobStability']; @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="star user-star-rating-org {{ $jobStabilityRating >= $i ? 'filled' : '' }}"
                            title="{{ $i }} Stars">&#9733;</span>
                    @endfor
                </div>

                <!-- Workplace Diversity, Equity and Inculsion -->
                <div class="col-xl-4 col-lg-9 col-md-6 col-sm-6 col-6">
                    <span class="text-justify myRatingOrganizationLabel">
                        Workplace Diversity, Equity and Inculsion
                    </span>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6 star-rating-org disabled">
                    @php $workplaceDEIRating = (int) $organization['ratings']['workplaceDEI']; @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="star user-star-rating-org {{ $workplaceDEIRating >= $i ? 'filled' : '' }}"
                            title="{{ $i }} Stars">&#9733;</span>
                    @endfor
                </div>
            </div>

            <!-- Employee Happiness - Company Reputation Row -->
            <div class="row align-items-center" style="margin-bottom: 16px;">
                <!-- Employee Happiness -->
                <div class="col-xl-4 col-lg-9 col-md-6 col-sm-6 col-6">
                    <span class="text-justify myRatingOrganizationLabel">
                        Employee Happiness
                    </span>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6 star-rating-org disabled">
                    @php $employeeHappinessRating = (int) $organization['ratings']['employeeHappyness']; @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="star user-star-rating-org {{ $employeeHappinessRating >= $i ? 'filled' : '' }}"
                            title="{{ $i }} Stars">&#9733;</span>
                    @endfor
                </div>

                <!-- Company Reputation  -->
                <div class="col-xl-4 col-lg-9 col-md-6 col-sm-6 col-6">
                    <span class="text-justify myRatingOrganizationLabel">
                        Company Reputation
                    </span>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6 star-rating-org disabled">
                    @php $companyReputationRating = (int) $organization['ratings']['companyReputation']; @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="star user-star-rating-org {{ $companyReputationRating >= $i ? 'filled' : '' }}"
                            title="{{ $i }} Stars">&#9733;</span>
                    @endfor
                </div>
            </div>

            <!-- Workplace Safety and Security - Company Growth and Future Plans Row -->
            <div class="row align-items-center" style="margin-bottom: 16px;">
                <!-- Workplace Safety and Security  -->
                <div class="col-xl-4 col-lg-9 col-md-6 col-sm-6 col-6">
                    <span class="text-justify myRatingOrganizationLabel">
                        Workplace Safety and Security
                    </span>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6 star-rating-org disabled">
                    @php $workplaceSafetySecurityRating = (int) $organization['ratings']['workplaceSS']; @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        <span
                            class="star user-star-rating-org {{ $workplaceSafetySecurityRating >= $i ? 'filled' : '' }}"
                            title="{{ $i }} Stars">&#9733;</span>
                    @endfor
                </div>

                <!-- Company Growth and Future Plans  -->
                <div class="col-xl-4 col-lg-9 col-md-6 col-sm-6 col-6">
                    <span class="text-justify myRatingOrganizationLabel">
                        Company Growth and Future Plans
                    </span>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6 star-rating-org disabled">
                    @php $companyGrowthFuturePlansRating = (int) $organization['ratings']['growthFuturePlan']; @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        <span
                            class="star user-star-rating-org {{ $companyGrowthFuturePlansRating >= $i ? 'filled' : '' }}"
                            title="{{ $i }} Stars">&#9733;</span>
                    @endfor
                </div>
            </div>

            <!-- Edit Button -->
            <div class="row align-items-center">
                <div class="col">
                    <a href="{{ route('user.organization.rateOrganizationForm', ['organizationId' => $organization['organization']->id, 'edit' => 1, 'ratingId' => $organization['ratings']->id]) }}"
                        class="btn btn-primary btnHeight editRating btnStyles"
                        id="btnEditMyOrganizationRating">Edit</a>
                </div>
            </div>
        </div>
    </div>

    <hr style="margin-top:32px; margin-bottom:32px">
    <!-- /...... My Rating-Organization Ends -->
@endforeach
<div class="row">
    <div class="col-12 d-flex justify-content-end" id="myOrganizationRating">
        @if ($dataOrganizationRated['paginatedRatings'] && $dataOrganizationRated['paginatedRatings']->count())
            {{ $dataOrganizationRated['paginatedRatings']->appends(['searchMyOrganizationRating' => request('searchMyOrganizationRating')])->links('user.pagination.customPagination') }}
        @endif
    </div>
</div>
