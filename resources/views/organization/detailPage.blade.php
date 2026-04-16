@extends('common.layouts.master')
@section('title', 'Organization - Details')
@section('headerHeading') Organization Details @endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('css/organization/detailPage.css') }}">
    <!-- Custom CSS file -->
    <link rel="stylesheet" href="{{ asset('css/user/customBorder.css') }}">
@endsection
@section('content')
    <!-- /.content-wrapper -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card customParentCardStyle mt-3">
                        <div class="card-body m-0 pb-0 mb-0">
                            <div class="row">
                                <div class="col-lg-12 border-bottom pb-4">
                                    <div class="row align-items-center">
                                        <div class="col-md-6 d-flex align-items-center mb-2">
                                            <img src="{{ $data['organization']->getImageFullUrlAttribute() }}"
                                                alt="Logo"
                                                style="height: 72px; width: 72px; border-radius: 999px; border: 2px solid; border-color: rgb(227, 242, 254);"
                                                onerror="this.onerror=null;this.src='{{ asset('img/organizationDefaultAvatar.png') }}';">
                                            <div class="organization-name pl-3">
                                                <h3 class="brand-name" title="{{ $data['organization']->name }}">
                                                    {{ $data['organization']->name }}
                                                </h3>
                                                <div style="pointer-events: none;" class="p address-name m-0 p-0" title="{{ $data['organization']->address }}">
                                                    {{ $data['organization']->address }}
                                                </div>
                                                
                                            </div>
                                        </div>

                                        <div class="col-md-6 text-right">
                                            <!-- View all Peers -->
                                            <a href="{{ auth()->check() ? route('user.peer.list.viewAllPeerByOrganizationId', ['organizationId' => $data['organization']->id]) : route('peer.list.viewAllPeerByOrganizationId', ['organizationId' => $data['organization']->id]) }}"
                                                class="btn btn-outline-primary btnStyle mb-2" id="colorChangeButton">
                                                View all Peers
                                            </a>


                                            <!-- Compare this organization -->
                                            <a href="{{ auth()->check() ? route('user.organization.compareOrganizationForm', ['organizationId' => $data['organization']->id]) : route('organization.compareOrganizationForm', ['organizationId' => $data['organization']->id]) }}"
                                                class="btn btn-outline-primary btnStyle mb-2">
                                                Compare this organization
                                            </a>

                                            <!-- Rate this organization -->
                                            <a href="{{ auth()->check() ? route('user.organization.rateOrganizationForm', ['organizationId' => $data['organization']->id]) : route('organization.rateOrganizationForm', ['organizationId' => $data['organization']->id]) }}"
                                                class="btn btn-primary btnStyles mb-2">
                                                Rate this organization
                                            </a>

                                            <div id="organizationList" class="d-inline-block" style="vertical-align: text-bottom;">
                                                <form action="{{ route('user.organization.savedOrganization') }}"
                                                    method="POST"
                                                    id="savedOrganizationForm_{{ $data['organization']->id }}">
                                                    @csrf
                                                    <input type="hidden" name="savedOrganizationId"
                                                        id="organizationIdSaved_{{ $data['organization']->id }}"
                                                        value="{{ $data['organization']->id }}"
                                                        placeholder="Enter Organization id to save." readonly>
                                                    <!-- Organization is already saved -->
                                                    <a href="#" class="unSavedOrganization"
                                                        data-organization-id="{{ $data['organization']->id }}"
                                                        id="unSavedOrganization_{{ $data['organization']->id }}"
                                                        style="display: {{ $saved == true ? 'block' : 'none' }};">
                                                        <img src="{{ asset('img/icons/blueSavedIcon.png') }}"
                                                            alt="Save Organization" style="height: 24px; width:24px;">
                                                    </a>
                                                    <!-- Organization is not saved -->
                                                    <a href="#" class="savedOrganization"
                                                        data-organization-id="{{ $data['organization']->id }}"
                                                        id="savedOrganization_{{ $data['organization']->id }}"
                                                        style="display: {{ $saved == false ? 'block' : 'none' }};">
                                                        <img src="{{ asset('img/icons/saveIcon.png') }}"
                                                            alt="Un-Save Organization" style="height: 24px; width:24px;">
                                                    </a>
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-4 text-start border-right" style="padding: 24px 24px 0;">
                                    <div class="rating-section">
                                        <h4 class="title-rating">Total Ratings</h4>
                                        <div class="d-flex justify-content-strat align-items-center">
                                            <p class=" mt-4 mr-2 total-rating">{{ $data['formattedRating'] }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-start border-right" style="padding: 24px 24px 0;">
                                    <div class="rating-section">
                                        <h4 class="title-rating">Overall Rating</h4>
                                        <div class="d-flex justify-content-strat align-items-center">
                                            <p class=" mt-4 mr-2 total-rating">

                                                {{ number_format($data['formattedOverAllRating'], 1) }}</p>
                                            <div class="star-rating  mt-2 d-flex">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <span
                                                        class="star {{ $data['formattedOverAllRating'] >= $i ? 'filled' : '' }}"
                                                        title="{{ $i }} Stars">&#9733;</span>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 text-start" style="padding: 24px 24px 0;">
                                    <div class="rating-section">
                                        <h4 class="title-rating" style="margin-top: 4px;">Employee Happiness</h4>
                                        <div class="d-flex justify-content-start align-items-center">
                                            <p class=" mt-4 mr-2 total-rating">
                                                {{ number_format($data['formattedHappiness'], 1) }}</p>
                                            <div class="star-rating  mt-2 d-flex">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <span
                                                        class="star {{ $data['formattedHappiness'] >= $i ? 'filled' : '' }}"
                                                        title="{{ $i }} Stars">&#9733;</span>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Content Header End (Page header) -->

        <!-- Content Body (Gender & Ethnicity Ratio) -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card customParentCardStyle">
                        <div class="card-body m-0 p-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <h1 class="title h1">Gender & Ethnicity Ratio</h1>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="chart-container mt-3"
                                        style="background:rgba(229, 244, 255, 0.4); height:320px; display: flex; justify-content: center; align-items: center;border-radius:8px;">
                                        <div style="width: 400px; height: 200px; position: relative;">
                                            <canvas id="genderChart" style="width: 100%; height: 100%;"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="chart-container mycustmChart mt-3 p-4"
                                        style="background:rgba(229, 244, 255, 0.4); height:320px; border-radius:8px">
                                        <div class="chart-container-horizontal">
                                            <canvas id="ethnicityChart"></canvas>
                                        </div>
                                        <div class="container">
                                            <div class="d-flex flex-wrap   myChanges">
                                                <div class="d-flex align-items-center"
                                                    style="flex: 0 0 60%; margin-bottom: 8px;">
                                                    <div
                                                        style="background-color: #b4bd9b; width: 12px; min-width: 12px; max-width: 12px; height: 12px; margin-right: 6px; border-radius: 2px;">
                                                    </div>
                                                    {{ number_format($data['totalWhitePercentage']) }}% <span
                                                        class="bar-text">White</span>
                                                </div>
                                                <div class="d-flex align-items-center"
                                                    style="flex: 0 0 40%; margin-bottom: 8px;">
                                                    <div
                                                        style="background-color: #81bdc3; width: 12px; min-width: 12px; max-width: 12px; height: 12px; margin-right: 6px; border-radius: 2px;">
                                                    </div>
                                                    {{ number_format($data['totalBlackPercentage']) }}% <span
                                                        class="bar-text">Black</span>
                                                </div>
                                                <div class="d-flex align-items-center"
                                                    style="flex: 0 0 60%; margin-bottom: 8px;">
                                                    <div
                                                        style="background-color: #f6cf98; width: 12px; min-width: 12px; max-width: 12px; height: 12px; margin-right: 6px; border-radius: 2px;">
                                                    </div>
                                                    {{ number_format($data['totalHispanicPercentage']) }}% <span
                                                        class="bar-text">Hispanic or Latino</span>
                                                </div>
                                                <div class="d-flex align-items-center"
                                                    style="flex: 0 0 40%; margin-bottom: 8px;">
                                                    <div
                                                        style="background-color: #fdf8ec; width: 12px; min-width: 12px; max-width: 12px; height: 12px; margin-right: 6px; border-radius: 2px;">
                                                    </div>
                                                    {{ number_format($data['totalMiddleEasternPercentage']) }}% <span
                                                        class="bar-text">Middle Eastern</span>
                                                </div>
                                                <div class="d-flex align-items-center"
                                                    style="flex: 0 0 60%; margin-bottom: 8px;">
                                                    <div
                                                        style="background-color: #fdba77; width: 12px; min-width: 12px; max-width: 12px; height: 12px; margin-right: 6px; border-radius: 2px;">
                                                    </div>
                                                    {{ number_format($data['totalAmericanIndianPercentage']) }}% <span
                                                        class="bar-text">American Indian or Alaska Native</span>
                                                </div>
                                                <div class="d-flex align-items-center"
                                                    style="flex: 0 0 40%; margin-bottom: 8px;">
                                                    <div
                                                        style="background-color: #f9d6d3; width: 12px; min-width: 12px; max-width: 12px; height: 12px; margin-right: 6px; border-radius: 2px;">
                                                    </div>
                                                    {{ number_format($data['totalAsianPercentage']) }}% <span
                                                        class="bar-text">Asian</span>
                                                </div>
                                                <div class="d-flex align-items-center"
                                                    style="flex: 0 0 60%; margin-bottom: 8px;">
                                                    <div
                                                        style="background-color: #1098f7; width: 12px; min-width: 12px; max-width: 12px; height: 12px; margin-right: 6px; border-radius: 2px;">
                                                    </div>
                                                    {{ number_format($data['totalHawaiianPercentage']) }}% <span
                                                        class="bar-text">Native Hawaiian or Pacific Islander</span>
                                                </div>
                                                <div class="d-flex align-items-center"
                                                    style="flex: 0 0 40%; margin-bottom: 8px;">
                                                    <div
                                                        style="background-color: #ccd5c3; width: 12px; min-width: 12px; max-width: 12px; height: 12px; margin-right: 6px; border-radius: 2px;">
                                                    </div>
                                                    {{ number_format($data['totalHawaiianPercentage']) }}% <span
                                                        class="bar-text">Others</span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Body (Overall Rating Breakdown) -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card customParentCardStyle">
                        <div class="card-body p-3 pb-0 mb-0">
                            <h2 class="mb-4 title-overall">Overall Rating Breakdown</h2>
                            <!-- First Row of Ratings -->
                            <div class="row ">
                                <div class="col-md-4 pb-1" style="padding: 15px;">
                                    <div class="rating-card d-flex align-items-center p-3"
                                        style="background: rgba(255, 252, 243, 1); border-radius: 8px;">
                                        <div class="rating-icon" style="margin-right: 15px;">
                                            <img src="{{ asset('img/overallRatingIcons/company-culture.png') }}"
                                                alt="company-culture.png" height="32px" width="32px"
                                                style="margin-bottom: -4px;">
                                        </div>
                                        <div>
                                            <div class="rating-title">Company Culture</div>
                                            <span class="star-filled">&#9733;</span> <span
                                                class="rates">{{ number_format($data['formattedCompanyCulture'], 1) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 pb-1" style="padding: 15px;">
                                    <div class="rating-card d-flex align-items-center p-3"
                                        style="background: rgba(255, 252, 243, 1); border-radius: 8px;">
                                        <div class="rating-icon" style="margin-right: 15px;"> <!-- Adjusted here -->
                                            <img src="{{ asset('img/overallRatingIcons/Career-Development-Opportunities.png') }}"
                                                alt="company-culture.png" height="32px" width="32px"
                                                style="margin-bottom: -4px;">
                                        </div>
                                        <div>
                                            <div class="rating-title">Career Development Opportunities</div>
                                            <span class="star-filled">&#9733;</span> <span
                                                class="rates">{{ number_format($data['formattedCareerDevelopment'], 1) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 pb-1" style="padding: 15px;">
                                    <div class="rating-card d-flex align-items-center p-3"
                                        style="background: rgba(255, 252, 243, 1); border-radius: 8px;">
                                        <div class="rating-icon" style="margin-right: 15px;"> <!-- Adjusted here -->
                                            <img src="{{ asset('img/overallRatingIcons/Work-Life-Balance.png') }}"
                                                alt="company-culture.png" height="32px" width="32px"
                                                style="margin-bottom: -4px;">
                                        </div>
                                        <div>
                                            <div class="rating-title">Work-Life Balance</div>
                                            <span class="star-filled">&#9733;</span> <span
                                                class="rates">{{ number_format($data['formattedWorkLifeBalance'], 1) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Second Row of Ratings -->
                            <div class="row ">
                                <div class="col-md-4 pb-1" style="padding: 15px;">
                                    <div class="rating-card d-flex align-items-center p-3"
                                        style="background: rgba(255, 252, 243, 1); border-radius: 8px;">
                                        <div class="rating-icon" style="margin-right: 15px;">
                                            <img src="{{ asset('img/overallRatingIcons/Compensation-and-Benefits.png') }}"
                                                alt="company-culture.png" height="32px" width="32px"
                                                style="margin-bottom: -4px;">
                                        </div>
                                        <div>
                                            <div class="rating-title">Compensation and Benefits</div>
                                            <span class="star-filled">&#9733;</span> <span
                                                class="rates">{{ number_format($data['formattedCompensationBenefit'], 1) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 pb-1" style="padding: 15px;">
                                    <div class="rating-card d-flex align-items-center p-3"
                                        style="background: rgba(255, 252, 243, 1); border-radius: 8px;">
                                        <div class="rating-icon" style="margin-right: 15px;"> <!-- Adjusted here -->
                                            <img src="{{ asset('img/overallRatingIcons/Job-Stability.png') }}"
                                                alt="company-culture.png" height="32px" width="32px"
                                                style="margin-bottom: -4px;">
                                        </div>
                                        <div>
                                            <div class="rating-title">Job Stability</div>
                                            <span class="star-filled">&#9733;</span> <span
                                                class="rates">{{ number_format($data['formattedJobStability'], 1) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 pb-1" style="padding: 15px;">
                                    <div class="rating-card d-flex align-items-center p-3"
                                        style="background: rgba(255, 252, 243, 1); border-radius: 8px;">
                                        <div class="rating-icon" style="margin-right: 15px;"> <!-- Adjusted here -->
                                            <img src="{{ asset('img/overallRatingIcons/Workplace-Diversity-Equity-and-Inclusion.png') }}"
                                                alt="company-culture.png" height="32px" width="32px"
                                                style="margin-bottom: -4px;">
                                        </div>
                                        <div>
                                            <div class="rating-title">Workplace Diversity, Equity, and Inclusion</div>
                                            <span class="star-filled">&#9733;</span> <span
                                                class="rates">{{ number_format($data['formattedWorkplaceDEI'], 1) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Third Row of Ratings -->
                            <div class="row ">
                                <div class="col-md-4 pb-1" style="padding: 15px;">
                                    <div class="rating-card d-flex align-items-center p-3"
                                        style="background: rgba(255, 252, 243, 1); border-radius: 8px;">
                                        <div class="rating-icon" style="margin-right: 15px;">
                                            <img src="{{ asset('img/overallRatingIcons/Company-Reputation.png') }}"
                                                alt="company-culture.png" height="32px" width="32px"
                                                style="margin-bottom: -4px;">
                                        </div>
                                        <div>
                                            <div class="rating-title">Company Reputation</div>
                                            <span class="star-filled">&#9733;</span> <span
                                                class="rates">{{ number_format($data['formattedCompanyReputation'], 1) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 pb-1" style="padding: 15px;">
                                    <div class="rating-card d-flex align-items-center p-3"
                                        style="background: rgba(255, 252, 243, 1); border-radius: 8px;">
                                        <div class="rating-icon" style="margin-right: 15px;"> <!-- Adjusted here -->
                                            <img src="{{ asset('img/overallRatingIcons/Workplace-Safety-and-Security.png') }}"
                                                alt="company-culture.png" height="32px" width="32px"
                                                style="margin-bottom: -4px;">
                                        </div>
                                        <div>
                                            <div class="rating-title">Workplace Safety and Security</div>
                                            <span class="star-filled">&#9733;</span> <span
                                                class="rates">{{ number_format($data['formattedWorkplaceSS'], 1) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 pb-1" style="padding: 15px;">
                                    <div class="rating-card d-flex align-items-center p-3"
                                        style="background: rgba(255, 252, 243, 1); border-radius: 8px;">
                                        <div class="rating-icon" style="margin-right: 15px;"> <!-- Adjusted here -->
                                            <img src="{{ asset('img/overallRatingIcons/Company-Growth-and-Future-Plans.png') }}"
                                                alt="company-culture.png" height="32px" width="32px"
                                                style="margin-bottom: -4px;">
                                        </div>
                                        <div>
                                            <div class="rating-title">Company Growth and Future Plans</div>
                                            <span class="star-filled">&#9733;</span> <span
                                                class="rates">{{ number_format($data['formattedGrowthFuturePlan'], 1) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Body (User Rating) -->
        <div class="container-fluid content-user-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <div class="card customParentCardStyle">
                        <div class="card-body m-0 p-3">
                            <div class="row  p-2">
                                <div class="col-md-12">
                                    <h1 class="title">User Rating</h1>
                                </div>
                            </div>

                            <div class="row mt-2 p-2" id="data-wrapper-final">
                                @include('organization.rating')
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @include('common.layouts.compulsorySweetAlert')

@endsection
@php $hideFooter = true; @endphp
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/organization/organizationDetail.js') }}"></script>
    <script src="{{ asset('js/user/organization/listSaveUnSaveOrganization.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fingerprintjs/fingerprintjs@3/dist/fp.min.js"></script>

    <!-- Custom Script files to Save, Un-Save the Record of thumbs-up and down (Create, Update & Delete the record) -->
    <script type="text/javascript" src="{{ asset('js/home/helpful/helpful.js') }}"></script>

    <script>
        window.Laravel = {
            dataValues: [
                {{ $data['genderCounts']['MALE'] }},
                {{ $data['genderCounts']['FEMALE'] }},
                {{ $data['genderCounts']['OTHER'] }}
            ],
            totalwhite: "{{ $data['totalWhitePercentage'] }}",
            totalblack: "{{ $data['totalBlackPercentage'] }}",
            totalhispanic: "{{ $data['totalHispanicPercentage'] }}",
            totalmiddleEastern: "{{ $data['totalMiddleEasternPercentage'] }}",
            totalamericanIndian: "{{ $data['totalAmericanIndianPercentage'] }}",
            totalasian: "{{ $data['totalAsianPercentage'] }}",
            totalhawaiian: "{{ $data['totalHawaiianPercentage'] }}",
            totalothers: "{{ $data['totalHawaiianPercentage'] }}"
        };
        var organizationId = {{ $data['organization']->id }};
        var ENDPOINT = "{{ route('organization.show', ['id' => ':id']) }}".replace(':id', organizationId);
        var authlogin = "{{ Auth::check() ? 'true' : 'false' }}";
        var userLoggedIn = "{{ Auth::check() ? 'true' : 'false' }}";

        // Thumbs-Up Image Url
        var thumbsUpImageUrl = "{{ asset('img/overallRatingIcons/thumpsup.png') }}";
        // Green Thumbs-Up Image Url
        var greenThumbsUpImageUrl = "{{ asset('img/overallRatingIcons/thumpsupGreen.png') }}";
        // Thumbs-Down Image Url
        var thumbsDownImageUrl = "{{ asset('img/overallRatingIcons/thumbsdown.png') }}";
        // Red Thumbs-Down Image Url
        var redThumbsDownImageUrl = "{{ asset('img/overallRatingIcons/thumbsdownRed.png') }}";
    </script>
@endsection
