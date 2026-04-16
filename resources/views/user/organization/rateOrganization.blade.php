@extends('common.layouts.master')
@section('title', 'Organization - Rating')
@section('headerHeading', 'Organization Rating')
@section('style')
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/user/customBorder.css') }}">
    <!-- Rating Star CSS -->
    <link rel="stylesheet" href="{{ asset('css/user/starRating.css') }}">
    <!-- Rate Organization CSS -->
    <link rel="stylesheet" href="{{ asset('css/user/organization/rateOrganization.css') }}">
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <br>
            <!-- First box Organization Info -->
            <div class="card customParentCardStyle">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 d-flex">
                            <div class="d-flex align-items-center">
                                <div id="organizationLogoDiv">
                                    <img src="{{ $organization->getImageFullUrlAttribute() }}" alt="Logo"
                                        class="img-rounded" id="organizationAvatar"
                                        onerror="this.onerror=null;this.src='{{ asset('img/organizationDefaultAvatar.png') }}';">
                                </div>
                                <div style="margin-left: 16px">
                                    <div class="organizationName" style="margin-right: 20px"
                                        title="{{ $organization->name }}">
                                        {{ $organization->name }}
                                    </div>
                                    <div class="organizationAddress" title="{{ $organization->address }}">
                                        {{ $organization->address }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 d-flex align-items-center align-content-end justify-content-end">
                            <div style="display: flex; align-items:center">
                                <span class="labelOverAllScore">Overall score:</span>

                                <span class="labelOverAllScoreValue">{{ $overAllRating }}</span>
                            </div>
                            <div class="star-rating disabled" style="margin-right: 28px;">
                                <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="rating" id="star5" value="5" disabled>
                                <label for="star5" title="5 Stars Rating">&#9733;</label>

                                <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="rating" id="star4" value="4" disabled>
                                <label for="star4" title="4 Stars Rating">&#9733;</label>

                                <!-- 3 Star ✬ ✬ ✬ -->
                                <input type="radio" name="rating" id="star3" value="3" disabled>
                                <label for="star3" title="3 Stars Rating">&#9733;</label>

                                <!-- 2 Star ✬ ✬ -->
                                <input type="radio" name="rating" id="star2" value="2" disabled>
                                <label for="star2" title="2 Stars Rating">&#9733;</label>

                                <!-- 1 Star ✬ -->
                                <input type="radio" name="rating" id="star1" value="1" disabled>
                                <label for="star1" title="1 Star Rating">&#9733;</label>
                            </div>
                        </div>

                        <div class="align-items-center" style="position: absolute; right:15px; padding-top:25px">
                            <form action="{{ route('user.organization.savedOrganization') }}" method="POST"
                                id="savedOrganizationForm">
                                @csrf
                                <input type="hidden" name="savedOrganizationId" id="savedOrganizationId"
                                    value="{{ $organization->id }}" readonly>
                                <!-- Organization is already saved -->
                                <a href="#" class="unSavedOrganization" id="unSavedOrganization"
                                    style="display: {{ $isSavedOrganization == true ? 'block' : 'none' }};">
                                    <img src="{{ asset('img/icons/blueSavedIcon.png') }}" alt="Save Organization">
                                </a>

                                <!-- Organization is not saved -->
                                <a href="#" class="savedOrganization" id="savedOrganization"
                                    style="display: {{ $isSavedOrganization == false ? 'block' : 'none' }};">
                                    <img src="{{ asset('img/icons/saveIcon.png') }}" alt="Un-Save Organization">
                                </a>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Second box Rate Organization -->
            <div class="card customChildCardStyle">
                <div class="card-body">
                    <!-- Introduction -->
                    <div class="form-group" style="margin-bottom: 24px;">
                        <span class="organizationNameChild">Rate: {{ $organization->name }}</span>
                        <p class="ratingSummary">
                            We value your feedback! Please rate your experience with the organization using the star rating
                            system below. Your input helps us improve our services. Thank you!
                        </p>
                    </div>

                    <form action="{{ route('user.organization.saveOrganizationRating') }}" method="POST"
                        id="rateOrganizationForm">
                        @csrf
                        <input type="hidden" name="organizationId" id="organizationId" value="{{ $organization->id }}"
                            readonly>
                        <input type="hidden" name="ratingId" id="ratingId" value="{{ $ratingId }}" readonly>
                        @if (isset($edit) && $edit == 1)
                            <input type="hidden" name="edit" value="1">
                        @endif
                        <!-- Employee Happiness -->
                        <div class="row form-group mb-2">
                            <div class="col-md-6 col-6 d-flex align-items-center ">
                                <span class="labelHeading">Employee Happiness</span>
                            </div>
                            <div class="col-md-6 col-6 d-flex align-items-center align-content-end justify-content-end">
                                <div class="star-rating enabled">
                                    <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                    <input type="radio" name="employeeHappiness" id="employeeHappinessStar5"
                                        {{ old('employeeHappiness') == 5 ? 'checked' : '' }} value="5">
                                    <label for="employeeHappinessStar5" title="5 Stars Rating">&#9733;</label>
                                    <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                    <input type="radio" name="employeeHappiness" id="employeeHappinessStar4"
                                        {{ old('employeeHappiness') == 4 ? 'checked' : '' }} value="4">
                                    <label for="employeeHappinessStar4" title="4 Stars Rating">&#9733;</label>
                                    <!-- 3 Star ✬ ✬ ✬ -->
                                    <input type="radio" name="employeeHappiness" id="employeeHappinessStar3"
                                        {{ old('employeeHappiness') == 3 ? 'checked' : '' }} value="3">
                                    <label for="employeeHappinessStar3" title="3 Stars Rating">&#9733;</label>
                                    <!-- 2 Star ✬ ✬ -->
                                    <input type="radio" name="employeeHappiness" id="employeeHappinessStar2"
                                        {{ old('employeeHappiness') == 2 ? 'checked' : '' }} value="2">
                                    <label for="employeeHappinessStar2" title="2 Stars Rating">&#9733;</label>
                                    <!-- 1 Star ✬ -->
                                    <input type="radio" name="employeeHappiness" id="employeeHappinessStar1"
                                        {{ old('employeeHappiness') == 1 ? 'checked' : '' }} value="1">
                                    <label for="employeeHappinessStar1" title="1 Star Rating">&#9733;</label>
                                </div>
                            </div>
                            <div class="col" style="text-align: end">
                                <span class="invalid-feedback d-block" id="employeeHappinessError" role="alert"></span>
                                @error('employeeHappiness')
                                    <span class="invalid-feedback d-block" id="employeeHappinessError"
                                        role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- hr line -->
                        <hr class="mt-1" style="margin-bottom: 20px;">

                        <!-- Company Culture -->
                        <div class="row form-group mb-2">
                            <div class="col-md-6 col-6 d-flex align-items-center ">
                                <span class="labelHeading">Company Culture</span>
                            </div>
                            <div class="col-md-6 col-6 d-flex align-items-center align-content-end justify-content-end">
                                <div class="star-rating enabled">
                                    <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                    <input type="radio" name="companyCulture" id="companyCultureStar5" value="5"
                                        {{ old('companyCulture') == 5 ? 'checked' : '' }}>
                                    <label for="companyCultureStar5" title="5 Stars Rating">&#9733;</label>
                                    <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                    <input type="radio" name="companyCulture" id="companyCultureStar4" value="4"
                                        {{ old('companyCulture') == 4 ? 'checked' : '' }}>
                                    <label for="companyCultureStar4" title="4 Stars Rating">&#9733;</label>
                                    <!-- 3 Star ✬ ✬ ✬ -->
                                    <input type="radio" name="companyCulture" id="companyCultureStar3" value="3"
                                        {{ old('companyCulture') == 3 ? 'checked' : '' }}>
                                    <label for="companyCultureStar3" title="3 Stars Rating">&#9733;</label>
                                    <!-- 2 Star ✬ ✬ -->
                                    <input type="radio" name="companyCulture" id="companyCultureStar2" value="2"
                                        {{ old('companyCulture') == 2 ? 'checked' : '' }}>
                                    <label for="companyCultureStar2" title="2 Stars Rating">&#9733;</label>
                                    <!-- 1 Star ✬ -->
                                    <input type="radio" name="companyCulture" id="companyCultureStar1" value="1"
                                        {{ old('companyCulture') == 1 ? 'checked' : '' }}>
                                    <label for="companyCultureStar1" title="1 Star Rating">&#9733;</label>
                                </div>
                            </div>
                            <div class="col" style="text-align: end">
                                <span class="invalid-feedback d-block" id="companyCultureError" role="alert"></span>
                                @error('companyCulture')
                                    <span class="invalid-feedback d-block" id="companyCultureError"
                                        role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- hr line -->
                        <hr class="mt-1" style="margin-bottom: 20px;">

                        <!-- Career Development Opportunities -->
                        <div class="row form-group mb-2">
                            <div class="col-md-6 col-6 d-flex align-items-center ">
                                <span class="labelHeading">Career Development Opportunities</span>
                            </div>
                            <div class="col-md-6 col-6 d-flex align-items-center align-content-end justify-content-end">
                                <div class="star-rating enabled">
                                    <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                    <input type="radio" name="careerDevelopment" id="careerDevelopmentStar5"
                                        {{ old('careerDevelopment') == 5 ? 'checked' : '' }} value="5">
                                    <label for="careerDevelopmentStar5" title="5 Stars Rating">&#9733;</label>
                                    <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                    <input type="radio" name="careerDevelopment" id="careerDevelopmentStar4"
                                        {{ old('careerDevelopment') == 4 ? 'checked' : '' }} value="4">
                                    <label for="careerDevelopmentStar4" title="4 Stars Rating">&#9733;</label>
                                    <!-- 3 Star ✬ ✬ ✬ -->
                                    <input type="radio" name="careerDevelopment" id="careerDevelopmentStar3"
                                        {{ old('careerDevelopment') == 3 ? 'checked' : '' }} value="3">
                                    <label for="careerDevelopmentStar3" title="3 Stars Rating">&#9733;</label>
                                    <!-- 2 Star ✬ ✬ -->
                                    <input type="radio" name="careerDevelopment" id="careerDevelopmentStar2"
                                        {{ old('careerDevelopment') == 2 ? 'checked' : '' }} value="2">
                                    <label for="careerDevelopmentStar2" title="2 Stars Rating">&#9733;</label>
                                    <!-- 1 Star ✬ -->
                                    <input type="radio" name="careerDevelopment" id="careerDevelopmentStar1"
                                        {{ old('careerDevelopment') == 1 ? 'checked' : '' }} value="1">
                                    <label for="careerDevelopmentStar1" title="1 Star Rating">&#9733;</label>
                                </div>
                            </div>
                            <div class="col" style="text-align: end">
                                <span class="invalid-feedback d-block" id="careerDevelopmentError" role="alert"></span>
                                @error('careerDevelopment')
                                    <span class="invalid-feedback d-block" id="careerDevelopmentError"
                                        role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- hr line -->
                        <hr class="mt-1" style="margin-bottom: 20px;">

                        <!-- Work-Life Balance -->
                        <div class="row form-group mb-2">
                            <div class="col-md-6 col-6 d-flex align-items-center ">
                                <span class="labelHeading">Work-Life Balance</span>
                            </div>
                            <div class="col-md-6 col-6 d-flex align-items-center align-content-end justify-content-end">
                                <div class="star-rating enabled">
                                    <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                    <input type="radio" name="workLifeBalance" id="workLifeBalanceStar5"
                                        {{ old('workLifeBalance') == 5 ? 'checked' : '' }} value="5">
                                    <label for="workLifeBalanceStar5" title="5 Stars Rating">&#9733;</label>
                                    <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                    <input type="radio" name="workLifeBalance" id="workLifeBalanceStar4"
                                        {{ old('workLifeBalance') == 4 ? 'checked' : '' }} value="4">
                                    <label for="workLifeBalanceStar4" title="4 Stars Rating">&#9733;</label>
                                    <!-- 3 Star ✬ ✬ ✬ -->
                                    <input type="radio" name="workLifeBalance" id="workLifeBalanceStar3"
                                        {{ old('workLifeBalance') == 3 ? 'checked' : '' }} value="3">
                                    <label for="workLifeBalanceStar3" title="3 Stars Rating">&#9733;</label>
                                    <!-- 2 Star ✬ ✬ -->
                                    <input type="radio" name="workLifeBalance" id="workLifeBalanceStar2"
                                        {{ old('workLifeBalance') == 2 ? 'checked' : '' }} value="2">
                                    <label for="workLifeBalanceStar2" title="2 Stars Rating">&#9733;</label>
                                    <!-- 1 Star ✬ -->
                                    <input type="radio" name="workLifeBalance" id="workLifeBalanceStar1"
                                        {{ old('workLifeBalance') == 1 ? 'checked' : '' }} value="1">
                                    <label for="workLifeBalanceStar1" title="1 Star Rating">&#9733;</label>
                                </div>
                            </div>
                            <div class="col" style="text-align: end">
                                <span class="invalid-feedback d-block" id="workLifeBalanceError" role="alert"></span>
                                @error('workLifeBalance')
                                    <span class="invalid-feedback d-block" id="workLifeBalanceError"
                                        role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- hr line -->
                        <hr class="mt-1" style="margin-bottom: 20px;">

                        <!-- Compensation and Benefits -->
                        <div class="row form-group mb-2">
                            <div class="col-md-6 col-6 d-flex align-items-center ">
                                <span class="labelHeading">Compensation and Benefits</span>
                            </div>
                            <div class="col-md-6 col-6 d-flex align-items-center align-content-end justify-content-end">
                                <div class="star-rating enabled">
                                    <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                    <input type="radio" name="compensationBenefit" id="compensationBenefitStar5"
                                        {{ old('compensationBenefit') == 5 ? 'checked' : '' }} value="5">
                                    <label for="compensationBenefitStar5" title="5 Stars Rating">&#9733;</label>
                                    <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                    <input type="radio" name="compensationBenefit" id="compensationBenefitStar4"
                                        {{ old('compensationBenefit') == 4 ? 'checked' : '' }} value="4">
                                    <label for="compensationBenefitStar4" title="4 Stars Rating">&#9733;</label>
                                    <!-- 3 Star ✬ ✬ ✬ -->
                                    <input type="radio" name="compensationBenefit" id="compensationBenefitStar3"
                                        {{ old('compensationBenefit') == 3 ? 'checked' : '' }} value="3">
                                    <label for="compensationBenefitStar3" title="3 Stars Rating">&#9733;</label>
                                    <!-- 2 Star ✬ ✬ -->
                                    <input type="radio" name="compensationBenefit" id="compensationBenefitStar2"
                                        {{ old('compensationBenefit') == 2 ? 'checked' : '' }} value="2">
                                    <label for="compensationBenefitStar2" title="2 Stars Rating">&#9733;</label>
                                    <!-- 1 Star ✬ -->
                                    <input type="radio" name="compensationBenefit" id="compensationBenefitStar1"
                                        {{ old('compensationBenefit') == 1 ? 'checked' : '' }} value="1">
                                    <label for="compensationBenefitStar1" title="1 Star Rating">&#9733;</label>
                                </div>
                            </div>
                            <div class="col" style="text-align: end">
                                <span class="invalid-feedback d-block" id="compensationBenefitError"
                                    role="alert"></span>
                                @error('compensationBenefit')
                                    <span class="invalid-feedback d-block" id="compensationBenefitError"
                                        role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- hr line -->
                        <hr class="mt-1" style="margin-bottom: 20px;">

                        <!-- Job Stability -->
                        <div class="row form-group mb-2">
                            <div class="col-md-6 col-6 d-flex align-items-center ">
                                <span class="labelHeading">Job Stability</span>
                            </div>
                            <div class="col-md-6 col-6 d-flex align-items-center align-content-end justify-content-end">
                                <div class="star-rating enabled">
                                    <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                    <input type="radio" name="jobStability" id="jobStabilityStar5" value="5"
                                        {{ old('companyCulture') == 5 ? 'checked' : '' }}>
                                    <label for="jobStabilityStar5" title="5 Stars Rating">&#9733;</label>
                                    <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                    <input type="radio" name="jobStability" id="jobStabilityStar4" value="4"
                                        {{ old('jobStability') == 4 ? 'checked' : '' }}>
                                    <label for="jobStabilityStar4" title="4 Stars Rating">&#9733;</label>
                                    <!-- 3 Star ✬ ✬ ✬ -->
                                    <input type="radio" name="jobStability" id="jobStabilityStar3" value="3"
                                        {{ old('jobStability') == 3 ? 'checked' : '' }}>
                                    <label for="jobStabilityStar3" title="3 Stars Rating">&#9733;</label>
                                    <!-- 2 Star ✬ ✬ -->
                                    <input type="radio" name="jobStability" id="jobStabilityStar2" value="2"
                                        {{ old('jobStability') == 2 ? 'checked' : '' }}>
                                    <label for="jobStabilityStar2" title="2 Stars Rating">&#9733;</label>
                                    <!-- 1 Star ✬ -->
                                    <input type="radio" name="jobStability" id="jobStabilityStar1" value="1"
                                        {{ old('jobStability') == 1 ? 'checked' : '' }}>
                                    <label for="jobStabilityStar1" title="1 Star Rating">&#9733;</label>
                                </div>
                            </div>
                            <div class="col" style="text-align: end">
                                <span class="invalid-feedback d-block" id="jobStabilityError" role="alert"></span>
                                @error('jobStability')
                                    <span class="invalid-feedback d-block" id="jobStabilityError"
                                        role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- hr line -->
                        <hr class="mt-1" style="margin-bottom: 20px;">

                        <!-- Workplace Diversity, Equity and Inculsion -->
                        <div class="row form-group mb-2">
                            <div class="col-md-6 col-6 d-flex align-items-center ">
                                <span class="labelHeading">Workplace Diversity, Equity and Inculsion</span>
                            </div>
                            <div class="col-md-6 col-6 d-flex align-items-center align-content-end justify-content-end">
                                <div class="star-rating enabled">
                                    <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                    <input type="radio" name="workplaceDEI" id="workplaceDEIStar5" value="5"
                                        {{ old('workplaceDEI') == 5 ? 'checked' : '' }}>
                                    <label for="workplaceDEIStar5" title="5 Stars Rating">&#9733;</label>
                                    <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                    <input type="radio" name="workplaceDEI" id="workplaceDEIStar4" value="4"
                                        {{ old('workplaceDEI') == 4 ? 'checked' : '' }}>
                                    <label for="workplaceDEIStar4" title="4 Stars Rating">&#9733;</label>
                                    <!-- 3 Star ✬ ✬ ✬ -->
                                    <input type="radio" name="workplaceDEI" id="workplaceDEIStar3" value="3"
                                        {{ old('workplaceDEI') == 3 ? 'checked' : '' }}>
                                    <label for="workplaceDEIStar3" title="3 Stars Rating">&#9733;</label>
                                    <!-- 2 Star ✬ ✬ -->
                                    <input type="radio" name="workplaceDEI" id="workplaceDEIStar2" value="2"
                                        {{ old('workplaceDEI') == 2 ? 'checked' : '' }}>
                                    <label for="workplaceDEIStar2" title="2 Stars Rating">&#9733;</label>
                                    <!-- 1 Star ✬ -->
                                    <input type="radio" name="workplaceDEI" id="workplaceDEIStar1" value="1"
                                        {{ old('workplaceDEI') == 1 ? 'checked' : '' }}>
                                    <label for="workplaceDEIStar1" title="1 Star Rating">&#9733;</label>
                                </div>
                            </div>
                            <div class="col" style="text-align: end">
                                <span class="invalid-feedback d-block" id="workplaceDEIError" role="alert"></span>
                                @error('workplaceDEI')
                                    <span class="invalid-feedback d-block" id="workplaceDEIError"
                                        role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- hr line -->
                        <hr class="mt-1" style="margin-bottom: 20px;">

                        <!-- Company Reputation -->
                        <div class="row form-group mb-2">
                            <div class="col-md-6 col-6 d-flex align-items-center ">
                                <span class="labelHeading">Company Reputation</span>
                            </div>
                            <div class="col-md-6 col-6 d-flex align-items-center align-content-end justify-content-end">
                                <div class="star-rating enabled">
                                    <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                    <input type="radio" name="companyReputation" id="companyReputationStar5"
                                        {{ old('companyReputation') == 5 ? 'checked' : '' }} value="5">
                                    <label for="companyReputationStar5" title="5 Stars Rating">&#9733;</label>
                                    <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                    <input type="radio" name="companyReputation" id="companyReputationStar4"
                                        {{ old('companyReputation') == 4 ? 'checked' : '' }} value="4">
                                    <label for="companyReputationStar4" title="4 Stars Rating">&#9733;</label>
                                    <!-- 3 Star ✬ ✬ ✬ -->
                                    <input type="radio" name="companyReputation" id="companyReputationStar3"
                                        {{ old('companyReputation') == 3 ? 'checked' : '' }} value="3">
                                    <label for="companyReputationStar3" title="3 Stars Rating">&#9733;</label>
                                    <!-- 2 Star ✬ ✬ -->
                                    <input type="radio" name="companyReputation" id="companyReputationStar2"
                                        {{ old('companyReputation') == 2 ? 'checked' : '' }} value="2">
                                    <label for="companyReputationStar2" title="2 Stars Rating">&#9733;</label>
                                    <!-- 1 Star ✬ -->
                                    <input type="radio" name="companyReputation" id="companyReputationStar1"
                                        {{ old('companyReputation') == 1 ? 'checked' : '' }} value="1">
                                    <label for="companyReputationStar1" title="1 Star Rating">&#9733;</label>
                                </div>
                            </div>
                            <div class="col" style="text-align: end">
                                <span class="invalid-feedback d-block" id="companyReputationError" role="alert"></span>
                                @error('companyReputation')
                                    <span class="invalid-feedback d-block" id="companyReputationError"
                                        role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- hr line -->
                        <hr class="mt-1" style="margin-bottom: 20px;">

                        <!-- Workplace Safety and Security -->
                        <div class="row form-group mb-2">
                            <div class="col-md-6 col-6 d-flex align-items-center ">
                                <span class="labelHeading">Workplace Safety and Security</span>
                            </div>
                            <div class="col-md-6 col-6 d-flex align-items-center align-content-end justify-content-end">
                                <div class="star-rating enabled">
                                    <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                    <input type="radio" name="workplaceSS" id="workplaceSSStar5" value="5"
                                        {{ old('workplaceSS') == 5 ? 'checked' : '' }}>
                                    <label for="workplaceSSStar5" title="5 Stars Rating">&#9733;</label>
                                    <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                    <input type="radio" name="workplaceSS" id="workplaceSSStar4" value="4"
                                        {{ old('workplaceSS') == 4 ? 'checked' : '' }}>
                                    <label for="workplaceSSStar4" title="4 Stars Rating">&#9733;</label>
                                    <!-- 3 Star ✬ ✬ ✬ -->
                                    <input type="radio" name="workplaceSS" id="workplaceSSStar3" value="3"
                                        {{ old('workplaceSS') == 3 ? 'checked' : '' }}>
                                    <label for="workplaceSSStar3" title="3 Stars Rating">&#9733;</label>
                                    <!-- 2 Star ✬ ✬ -->
                                    <input type="radio" name="workplaceSS" id="workplaceSSStar2" value="2"
                                        {{ old('workplaceSS') == 2 ? 'checked' : '' }}>
                                    <label for="workplaceSSStar2" title="2 Stars Rating">&#9733;</label>
                                    <!-- 1 Star ✬ -->
                                    <input type="radio" name="workplaceSS" id="workplaceSSStar1" value="1"
                                        {{ old('workplaceSS') == 1 ? 'checked' : '' }}>
                                    <label for="workplaceSSStar1" title="1 Star Rating">&#9733;</label>
                                </div>
                            </div>
                            <div class="col" style="text-align: end">
                                <span class="invalid-feedback d-block" id="workplaceSSError" role="alert"></span>
                                @error('workplaceSS')
                                    <span class="invalid-feedback d-block" id="workplaceSSError"
                                        role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- hr line -->
                        <hr class="mt-1" style="margin-bottom: 20px;">

                        <!-- Company Growth and Future Plans -->
                        <div class="row form-group mb-2">
                            <div class="col-md-6 col-6 d-flex align-items-center ">
                                <span class="labelHeading">Company Growth and Future Plans</span>
                            </div>
                            <div class="col-md-6 col-6 d-flex align-items-center align-content-end justify-content-end">
                                <div class="star-rating enabled">
                                    <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                    <input type="radio" name="growthFuturePlan" id="growthFuturePlanStar5"
                                        {{ old('growthFuturePlan') == 5 ? 'checked' : '' }} value="5">
                                    <label for="growthFuturePlanStar5" title="5 Stars Rating">&#9733;</label>
                                    <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                    <input type="radio" name="growthFuturePlan" id="growthFuturePlanStar4"
                                        {{ old('growthFuturePlan') == 4 ? 'checked' : '' }} value="4">
                                    <label for="growthFuturePlanStar4" title="4 Stars Rating">&#9733;</label>
                                    <!-- 3 Star ✬ ✬ ✬ -->
                                    <input type="radio" name="growthFuturePlan" id="growthFuturePlanStar3"
                                        {{ old('growthFuturePlan') == 3 ? 'checked' : '' }} value="3">
                                    <label for="growthFuturePlanStar3" title="3 Stars Rating">&#9733;</label>
                                    <!-- 2 Star ✬ ✬ -->
                                    <input type="radio" name="growthFuturePlan" id="growthFuturePlanStar2"
                                        {{ old('growthFuturePlan') == 2 ? 'checked' : '' }} value="2">
                                    <label for="growthFuturePlanStar2" title="2 Stars Rating">&#9733;</label>
                                    <!-- 1 Star ✬ -->
                                    <input type="radio" name="growthFuturePlan" id="growthFuturePlanStar1"
                                        {{ old('growthFuturePlan') == 1 ? 'checked' : '' }} value="1">
                                    <label for="growthFuturePlanStar1" title="1 Star Rating">&#9733;</label>
                                </div>
                            </div>
                            <div class="col" style="text-align: end">
                                <span class="invalid-feedback d-block" id="growthFuturePlanError" role="alert"></span>
                                @error('growthFuturePlan')
                                    <span class="invalid-feedback d-block" id="growthFuturePlanError"
                                        role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <br>
                        <br>
                        <div class="form-group mb-1">
                            <span class="" style="font-size: 20px; font-weight:600;color: #161617;">
                                Share Your Experience.<br>
                                Tell us about your time with this organization. What did you enjoy? What could be
                                improved?
                            </span>
                            <ul class="" style="font-size:16px;font-weight:400; color: #00000080;">
                                <li>We may remove your rating if it includes inappropriate language.</li>
                                <li>Use the rating categories to provide the feedback.</li>
                            </ul>
                        </div>

                        <!-- Experience -->
                        <div class="form-group mb-3">
                            <div class="mb-2">
                                <textarea name="experience" id="experience" class="form-control customBorderRadius" maxlength="600"
                                    placeholder="What information do you want to share about this organization?">{{ $organizationRating ? $organizationRating->experience : old('experience') }}</textarea>
                            </div>
                            <div>
                                <span class="invalid-feedback d-block" id="experienceError" role="alert"></span>
                                @error('experience')
                                    <span class="invalid-feedback validationError d-block" id="experienceError"
                                        role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <span id="charCount">
                                0/600
                            </span>
                        </div>

                        <!-- Terms & Conditions -->
                        <div class="form-group mb-2">
                            <p class="">
                                By clicking the "Submit" button, I confirmed that I have read and agreed to the Rate Together Now
                                Guidelines,
                                <a href="{{ route('termsAndCondition') }}" target="_blank">Terms of Service</a> and
                                <a href="{{ route('privacyPolicy') }}" target="_blank">Privacy Policy.</a>
                                Submittted reviews become the property of Rate Together Now .
                            </p>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group mb-1">
                            <button type="submit" id="btnRateOrganization" style="height:50px;"
                                class="btn btn-primary customBorderRadius customBtnColor">Submit</button>
                        </div>
                    </form>

                </div>
            </div>
            <!-- /.card -->


        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    @include('user.organization.modal.ratedOrganizationModal')
@endsection
@section('script')
    <!-- Script file to display loader  -->
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
    </script>

    <!-- Sweet aler 2 Script files -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Custom Script Files -->
    <script type="text/javascript" src="{{ asset('js/user/organization/rateOrganization.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/user/organization/saveUnSaveOrganization.js') }}"></script>

    <!-- Global Variable -->
    <script type="text/javascript">
        var sessionOrganizationRated = "{{ session('organizationRated') ? 'true' : 'false' }}";
        var redirectBackUrl =
            "{{ auth()->check() ? route('user.organization.show', ['id' => $organization->id]) : route('organization.show', ['id' => $organization->id]) }}";
        var userLoggedIn = "{{ Auth::check() ? 'true' : 'false' }}";
        var overAllRating = {{ $overAllRating }};
        var employeeHappiness = "{{ $organizationRating ? $organizationRating->employeeHappyness : 0 }}";
        var companyCulture = "{{ $organizationRating ? $organizationRating->companyCulture : 0 }}";
        var careerDevelopment = "{{ $organizationRating ? $organizationRating->careerDevelopment : 0 }}";
        var workLifeBalance = "{{ $organizationRating ? $organizationRating->workLifeBalance : 0 }}";
        var compensationBenefit = "{{ $organizationRating ? $organizationRating->compensationBenefit : 0 }}";
        var jobStability = "{{ $organizationRating ? $organizationRating->jobStability : 0 }}";
        var workplaceDEI = "{{ $organizationRating ? $organizationRating->workplaceDEI : 0 }}";
        var companyReputation = "{{ $organizationRating ? $organizationRating->companyReputation : 0 }}";
        var workplaceSS = "{{ $organizationRating ? $organizationRating->workplaceSS : 0 }}";
        var growthFuturePlan = "{{ $organizationRating ? $organizationRating->growthFuturePlan : 0 }}";
    </script>
@endsection
