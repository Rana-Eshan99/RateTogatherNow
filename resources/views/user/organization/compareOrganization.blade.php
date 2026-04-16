@extends('common.layouts.master')
@section('title', 'Organization - Compare')
@section('headerHeading', 'Compare Organizations')
@section('style')
    <!-- Select 2  CSS-->
    <link rel="stylesheet" href="{{ asset('select2/select2.min.css') }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/user/customBorder.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/customSelect2Box.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/organization/compareOrganization.css') }}">
    <!-- Star Rating CSS -->
    <link rel="stylesheet" href="{{ asset('css/user/starRating.css') }}">

@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">

            <br>
            <!-- Default box -->
            <div class="card customParentCardStyle">
                <div class="card-body">
                    <div class="row form-group mb-4">
                        <!-- 1st Div -->
                        <div class="col-md-6 d-flex align-items-top">
                            <span class="cardHeading">Compare Organizations</span>
                        </div>

                        <!-- 2nd Div -->
                        <div class="col-md-6 d-flex align-items-center justify-content-end" style="padding-right: 15px;">
                            <button type="reset" class="btn btnHeight customBorderRadius resetBtnColor" id="btnReset"
                                disabled>Reset
                            </button>
                        </div>
                    </div>

                    <div class="row form-group mb-4">
                        <div class="col-md-4 d-flex align-items-center">
                            @if (isset($data['id']))
                                <input type="hidden"
                                    value="{{ Auth::check() ? route('user.organization.show', ['id' => $data['id']]) : route('organization.show', ['id' => $data['id']]) }}"
                                    id="firstDivUrl">
                            @else
                                <!-- Optionally, handle the case where $data['id'] is not set -->
                                <input type="hidden" value="#" id="firstDivUrl">
                            @endif

                        </div>
                        <div
                            class="col-md-4 d-flex align-items-center align-content-center justify-content-center form-group mb-2">
                            <div id="firstDivOverAllRating" class="container">
                                <div class="organization-name" title="{{ $data['name'] }}">
                                    {{ $data['name'] }}
                                </div>
                                <div class="overall-rating">
                                    <span>Overall Rating</span><br>
                                    <span class="rating-value">{{ $data['overAllRating'] }}</span>
                                </div>
                            </div>
                        </div>

                        <div
                            class="col-md-4 d-flex align-items-center align-content-center justify-content-center form-group mb-2">
                            <div id="compareOrganizationDiv" class="compare-organization-container">
                                <div class="input-group" id="searchCompareOrganizationDiv" style="text-align: left;">
                                    <select id="searchCompareOrganization" name="searchCompareOrganization"
                                        class="form-control inputFieldHeight organizationSelectBox customBorderRadius">
                                        <option value="" selected disabled>Search Organization</option>
                                        @if ($organizationCompareList)
                                            @foreach ($organizationCompareList as $organization)
                                                <option value="{{ $organization->id }}">
                                                    {{ $organization->name }} - {{ $organization->address }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <span id="compareOrganizationName" title="" class="compare-organization-name"></span>
                                <div class="overall-rating">
                                    <span>Overall Rating</span><br>
                                    <span id="overAllRatingCompare" class="rating-value">N/A</span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Employee Happiness -->
                    <div class="row form-group mb-2">
                        <div class="col-md-4 d-flex align-items-center ">
                            <span class="labelHeading">Employee Happiness</span>
                        </div>
                        <div class="col-md-4 d-flex align-items-center align-content-center justify-content-center">
                            <div class="star-rating disabled">
                                <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="employeeHappiness" id="employeeHappinessStar5" value="5"
                                    disabled>
                                <label for="employeeHappinessStar5" title="5 Stars Rating">&#9733;</label>
                                <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="employeeHappiness" id="employeeHappinessStar4" value="4"
                                    disabled>
                                <label for="employeeHappinessStar4" title="4 Stars Rating">&#9733;</label>
                                <!-- 3 Star ✬ ✬ ✬ -->
                                <input type="radio" name="employeeHappiness" id="employeeHappinessStar3" value="3"
                                    disabled>
                                <label for="employeeHappinessStar3" title="3 Stars Rating">&#9733;</label>
                                <!-- 2 Star ✬ ✬ -->
                                <input type="radio" name="employeeHappiness" id="employeeHappinessStar2" value="2"
                                    disabled>
                                <label for="employeeHappinessStar2" title="2 Stars Rating">&#9733;</label>
                                <!-- 1 Star ✬ -->
                                <input type="radio" name="employeeHappiness" id="employeeHappinessStar1" value="1"
                                    disabled>
                                <label for="employeeHappinessStar1" title="1 Star Rating">&#9733;</label>
                            </div>
                        </div>

                        <!-- Compare Div --->
                        <div class="col-md-4 d-flex align-items-center align-content-end justify-content-center ">
                            <div class="star-rating disabled myChange">
                                <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="employeeHappinessCompare" id="employeeHappinessCompareStar5"
                                    value="5" disabled>
                                <label for="employeeHappinessCompareStar5" title="5 Stars Rating">&#9733;</label>
                                <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="employeeHappinessCompare" id="employeeHappinessCompareStar4"
                                    value="4" disabled>
                                <label for="employeeHappinessCompareStar4" title="4 Stars Rating">&#9733;</label>
                                <!-- 3 Star ✬ ✬ ✬ -->
                                <input type="radio" name="employeeHappinessCompare" id="employeeHappinessCompareStar3"
                                    value="3" disabled>
                                <label for="employeeHappinessCompareStar3" title="3 Stars Rating">&#9733;</label>
                                <!-- 2 Star ✬ ✬ -->
                                <input type="radio" name="employeeHappinessCompare" id="employeeHappinessCompareStar2"
                                    value="2" disabled>
                                <label for="employeeHappinessCompareStar2" title="2 Stars Rating">&#9733;</label>
                                <!-- 1 Star ✬ -->
                                <input type="radio" name="employeeHappinessCompare" id="employeeHappinessCompareStar1"
                                    value="1" disabled>
                                <label for="employeeHappinessCompareStar1" title="1 Star Rating">&#9733;</label>
                            </div>
                        </div>
                    </div>

                    <!-- hr line -->
                    <hr class="mt-1" style="margin-bottom: 20px;">

                    <!-- Company Culture -->
                    <div class="row form-group mb-2">
                        <div class="col-md-4 d-flex align-items-center ">
                            <span class="labelHeading">Company Culture</span>
                        </div>
                        <div class="col-md-4 d-flex align-items-center align-content-center justify-content-center">
                            <div class="star-rating disabled">
                                <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="companyCulture" id="companyCultureStar5" value="5"
                                    disabled>
                                <label for="companyCultureStar5" title="5 Stars Rating">&#9733;</label>
                                <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="companyCulture" id="companyCultureStar4" value="4"
                                    disabled>
                                <label for="companyCultureStar4" title="4 Stars Rating">&#9733;</label>
                                <!-- 3 Star ✬ ✬ ✬ -->
                                <input type="radio" name="companyCulture" id="companyCultureStar3" value="3"
                                    disabled>
                                <label for="companyCultureStar3" title="3 Stars Rating">&#9733;</label>
                                <!-- 2 Star ✬ ✬ -->
                                <input type="radio" name="companyCulture" id="companyCultureStar2" value="2"
                                    disabled>
                                <label for="companyCultureStar2" title="2 Stars Rating">&#9733;</label>
                                <!-- 1 Star ✬ -->
                                <input type="radio" name="companyCulture" id="companyCultureStar1" value="1"
                                    disabled>
                                <label for="companyCultureStar1" title="1 Star Rating">&#9733;</label>
                            </div>
                        </div>

                        <!-- Compare Div --->
                        <div class="col-md-4 d-flex align-items-center align-content-center justify-content-center">
                            <div class="star-rating disabled myChange">
                                <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="companyCultureCompare" id="companyCultureCompareStar5"
                                    value="5" disabled>
                                <label for="companyCultureCompareStar5" title="5 Stars Rating">&#9733;</label>
                                <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="companyCultureCompare" id="companyCultureCompareStar4"
                                    value="4" disabled>
                                <label for="companyCultureCompareStar4" title="4 Stars Rating">&#9733;</label>
                                <!-- 3 Star ✬ ✬ ✬ -->
                                <input type="radio" name="companyCultureCompare" id="companyCultureCompareStar3"
                                    value="3" disabled>
                                <label for="companyCultureCompareStar3" title="3 Stars Rating">&#9733;</label>
                                <!-- 2 Star ✬ ✬ -->
                                <input type="radio" name="companyCultureCompare" id="companyCultureCompareStar2"
                                    value="2" disabled>
                                <label for="companyCultureCompareStar2" title="2 Stars Rating">&#9733;</label>
                                <!-- 1 Star ✬ -->
                                <input type="radio" name="companyCultureCompare" id="companyCultureCompareStar1"
                                    value="1" disabled>
                                <label for="companyCultureCompareStar1" title="1 Star Rating">&#9733;</label>
                            </div>
                        </div>
                    </div>

                    <!-- hr line -->
                    <hr class="mt-1" style="margin-bottom: 20px;">

                    <!-- Career Development Opportunities -->
                    <div class="row form-group mb-2">
                        <div class="col-md-4 d-flex align-items-center ">
                            <span class="labelHeading text-nowrap">Career Development Opportunities</span>
                        </div>
                        <div class="col-md-4 d-flex align-items-center align-content-center justify-content-center">
                            <div class="star-rating disabled">
                                <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="careerDevelopment" id="careerDevelopmentStar5"
                                    value="5" disabled>
                                <label for="careerDevelopmentStar5" title="5 Stars Rating">&#9733;</label>
                                <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="careerDevelopment" id="careerDevelopmentStar4"
                                    value="4" disabled>
                                <label for="careerDevelopmentStar4" title="4 Stars Rating">&#9733;</label>
                                <!-- 3 Star ✬ ✬ ✬ -->
                                <input type="radio" name="careerDevelopment" id="careerDevelopmentStar3"
                                    value="3" disabled>
                                <label for="careerDevelopmentStar3" title="3 Stars Rating">&#9733;</label>
                                <!-- 2 Star ✬ ✬ -->
                                <input type="radio" name="careerDevelopment" id="careerDevelopmentStar2"
                                    value="2" disabled>
                                <label for="careerDevelopmentStar2" title="2 Stars Rating">&#9733;</label>
                                <!-- 1 Star ✬ -->
                                <input type="radio" name="careerDevelopment" id="careerDevelopmentStar1"value="1"
                                    disabled>
                                <label for="careerDevelopmentStar1" title="1 Star Rating">&#9733;</label>
                            </div>
                        </div>

                        <!-- Compare Div --->
                        <div class="col-md-4 d-flex align-items-center align-content-center justify-content-center">
                            <div class="star-rating disabled myChange">
                                <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="careerDevelopmentCompare" id="careerDevelopmentCompareStar5"
                                    value="5" disabled>
                                <label for="careerDevelopmentCompareStar5" title="5 Stars Rating">&#9733;</label>
                                <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="careerDevelopmentCompare" id="careerDevelopmentCompareStar4"
                                    value="4" disabled>
                                <label for="careerDevelopmentCompareStar4" title="4 Stars Rating">&#9733;</label>
                                <!-- 3 Star ✬ ✬ ✬ -->
                                <input type="radio" name="careerDevelopmentCompare" id="careerDevelopmentCompareStar3"
                                    value="3" disabled>
                                <label for="careerDevelopmentCompareStar3" title="3 Stars Rating">&#9733;</label>
                                <!-- 2 Star ✬ ✬ -->
                                <input type="radio" name="careerDevelopmentCompare" id="careerDevelopmentCompareStar2"
                                    value="2" disabled>
                                <label for="careerDevelopmentCompareStar2" title="2 Stars Rating">&#9733;</label>
                                <!-- 1 Star ✬ -->
                                <input type="radio" name="careerDevelopmentCompare"
                                    id="careerDevelopmentCompareStar1"value="1" disabled>
                                <label for="careerDevelopmentCompareStar1" title="1 Star Rating">&#9733;</label>
                            </div>
                        </div>
                    </div>

                    <!-- hr line -->
                    <hr class="mt-1" style="margin-bottom: 20px;">

                    <!-- Work-Life Balance -->
                    <div class="row form-group mb-2">
                        <div class="col-md-4 d-flex align-items-center ">
                            <span class="labelHeading">Work-Life Balance</span>
                        </div>
                        <div class="col-md-4 d-flex align-items-center align-content-center justify-content-center">
                            <div class="star-rating disabled">
                                <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="workLifeBalance" id="workLifeBalanceStar5" value="5"
                                    disabled>
                                <label for="workLifeBalanceStar5" title="5 Stars Rating">&#9733;</label>
                                <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="workLifeBalance" id="workLifeBalanceStar4" value="4"
                                    disabled>
                                <label for="workLifeBalanceStar4" title="4 Stars Rating">&#9733;</label>
                                <!-- 3 Star ✬ ✬ ✬ -->
                                <input type="radio" name="workLifeBalance" id="workLifeBalanceStar3" value="3"
                                    disabled>
                                <label for="workLifeBalanceStar3" title="3 Stars Rating">&#9733;</label>
                                <!-- 2 Star ✬ ✬ -->
                                <input type="radio" name="workLifeBalance" id="workLifeBalanceStar2" value="2"
                                    disabled>
                                <label for="workLifeBalanceStar2" title="2 Stars Rating">&#9733;</label>
                                <!-- 1 Star ✬ -->
                                <input type="radio" name="workLifeBalance" id="workLifeBalanceStar1" value="1"
                                    disabled>
                                <label for="workLifeBalanceStar1" title="1 Star Rating">&#9733;</label>
                            </div>
                        </div>

                        <!-- Compare Div --->
                        <div class="col-md-4 d-flex align-items-center align-content-center justify-content-center">
                            <div class="star-rating disabled myChange">
                                <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="workLifeBalanceCompare" id="workLifeBalanceCompareStar5"
                                    value="5" disabled>
                                <label for="workLifeBalanceCompareStar5" title="5 Stars Rating">&#9733;</label>
                                <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="workLifeBalanceCompare" id="workLifeBalanceCompareStar4"
                                    value="4" disabled>
                                <label for="workLifeBalanceCompareStar4" title="4 Stars Rating">&#9733;</label>
                                <!-- 3 Star ✬ ✬ ✬ -->
                                <input type="radio" name="workLifeBalanceCompare" id="workLifeBalanceCompareStar3"
                                    value="3" disabled>
                                <label for="workLifeBalanceCompareStar3" title="3 Stars Rating">&#9733;</label>
                                <!-- 2 Star ✬ ✬ -->
                                <input type="radio" name="workLifeBalanceCompare" id="workLifeBalanceCompareStar2"
                                    value="2" disabled>
                                <label for="workLifeBalanceCompareStar2" title="2 Stars Rating">&#9733;</label>
                                <!-- 1 Star ✬ -->
                                <input type="radio" name="workLifeBalanceCompare" id="workLifeBalanceCompareStar1"
                                    value="1" disabled>
                                <label for="workLifeBalanceCompareStar1" title="1 Star Rating">&#9733;</label>
                            </div>
                        </div>
                    </div>

                    <!-- hr line -->
                    <hr class="mt-1" style="margin-bottom: 20px;">

                    <!-- Compensation and Benefits -->
                    <div class="row form-group mb-2">
                        <div class="col-md-4 d-flex align-items-center ">
                            <span class="labelHeading text-nowrap">Compensation and Benefits</span>
                        </div>
                        <div class="col-md-4 d-flex align-items-center align-content-center justify-content-center">
                            <div class="star-rating disabled">
                                <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="compensationBenefit" id="compensationBenefitStar5"
                                    value="5" disabled>
                                <label for="compensationBenefitStar5" title="5 Stars Rating">&#9733;</label>
                                <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="compensationBenefit" id="compensationBenefitStar4"
                                    value="4" disabled>
                                <label for="compensationBenefitStar4" title="4 Stars Rating">&#9733;</label>
                                <!-- 3 Star ✬ ✬ ✬ -->
                                <input type="radio" name="compensationBenefit" id="compensationBenefitStar3"
                                    value="3" disabled>
                                <label for="compensationBenefitStar3" title="3 Stars Rating">&#9733;</label>
                                <!-- 2 Star ✬ ✬ -->
                                <input type="radio" name="compensationBenefit" id="compensationBenefitStar2"
                                    value="2" disabled>
                                <label for="compensationBenefitStar2" title="2 Stars Rating">&#9733;</label>
                                <!-- 1 Star ✬ -->
                                <input type="radio" name="compensationBenefit" id="compensationBenefitStar1"
                                    value="1" disabled>
                                <label for="compensationBenefitStar1" title="1 Star Rating">&#9733;</label>
                            </div>
                        </div>

                        <!-- Compare Div --->
                        <div class="col-md-4 d-flex align-items-center align-content-center justify-content-center">
                            <div class="star-rating disabled myChange">
                                <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="compensationBenefitCompare"
                                    id="compensationBenefitCompareStar5" value="5" disabled>
                                <label for="compensationBenefitCompareStar5" title="5 Stars Rating">&#9733;</label>
                                <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="compensationBenefitCompare"
                                    id="compensationBenefitCompareStar4" value="4" disabled>
                                <label for="compensationBenefitCompareStar4" title="4 Stars Rating">&#9733;</label>
                                <!-- 3 Star ✬ ✬ ✬ -->
                                <input type="radio" name="compensationBenefitCompare"
                                    id="compensationBenefitCompareStar3" value="3" disabled>
                                <label for="compensationBenefitCompareStar3" title="3 Stars Rating">&#9733;</label>
                                <!-- 2 Star ✬ ✬ -->
                                <input type="radio" name="compensationBenefitCompare"
                                    id="compensationBenefitCompareStar2" value="2" disabled>
                                <label for="compensationBenefitCompareStar2" title="2 Stars Rating">&#9733;</label>
                                <!-- 1 Star ✬ -->
                                <input type="radio" name="compensationBenefitCompare"
                                    id="compensationBenefitCompareStar1" value="1" disabled>
                                <label for="compensationBenefitCompareStar1" title="1 Star Rating">&#9733;</label>
                            </div>
                        </div>
                    </div>

                    <!-- hr line -->
                    <hr class="mt-1" style="margin-bottom: 20px;">

                    <!-- Job Stability -->
                    <div class="row form-group mb-2">
                        <div class="col-md-4 d-flex align-items-center ">
                            <span class="labelHeading">Job Stability</span>
                        </div>
                        <div class="col-md-4 d-flex align-items-center align-content-center justify-content-center">
                            <div class="star-rating disabled">
                                <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="jobStability" id="jobStabilityStar5" value="5"
                                    disabled>
                                <label for="jobStabilityStar5" title="5 Stars Rating">&#9733;</label>
                                <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="jobStability" id="jobStabilityStar4" value="4"
                                    disabled>
                                <label for="jobStabilityStar4" title="4 Stars Rating">&#9733;</label>
                                <!-- 3 Star ✬ ✬ ✬ -->
                                <input type="radio" name="jobStability" id="jobStabilityStar3" value="3"
                                    disabled>
                                <label for="jobStabilityStar3" title="3 Stars Rating">&#9733;</label>
                                <!-- 2 Star ✬ ✬ -->
                                <input type="radio" name="jobStability" id="jobStabilityStar2" value="2"
                                    disabled>
                                <label for="jobStabilityStar2" title="2 Stars Rating">&#9733;</label>
                                <!-- 1 Star ✬ -->
                                <input type="radio" name="jobStability" id="jobStabilityStar1" value="1"
                                    disabled>
                                <label for="jobStabilityStar1" title="1 Star Rating">&#9733;</label>
                            </div>
                        </div>

                        <!-- Compare Div --->
                        <div class="col-md-4 d-flex align-items-center align-content-center justify-content-center">
                            <div class="star-rating disabled    myChange">
                                <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="jobStabilityCompare" id="jobStabilityCompareStar5"
                                    value="5" disabled>
                                <label for="jobStabilityCompareStar5" title="5 Stars Rating">&#9733;</label>
                                <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="jobStabilityCompare" id="jobStabilityCompareStar4"
                                    value="4" disabled>
                                <label for="jobStabilityCompareStar4" title="4 Stars Rating">&#9733;</label>
                                <!-- 3 Star ✬ ✬ ✬ -->
                                <input type="radio" name="jobStabilityCompare" id="jobStabilityCompareStar3"
                                    value="3" disabled>
                                <label for="jobStabilityCompareStar3" title="3 Stars Rating">&#9733;</label>
                                <!-- 2 Star ✬ ✬ -->
                                <input type="radio" name="jobStabilityCompare" id="jobStabilityCompareStar2"
                                    value="2" disabled>
                                <label for="jobStabilityCompareStar2" title="2 Stars Rating">&#9733;</label>
                                <!-- 1 Star ✬ -->
                                <input type="radio" name="jobStabilityCompare" id="jobStabilityCompareStar1"
                                    value="1" disabled>
                                <label for="jobStabilityCompareStar1" title="1 Star Rating">&#9733;</label>
                            </div>
                        </div>
                    </div>

                    <!-- hr line -->
                    <hr class="mt-1" style="margin-bottom: 20px;">

                    <!-- Workplace Diversity, Equity and Inculsion -->
                    <div class="row form-group mb-2">
                        <div class="col-md-4 d-flex align-items-center ">
                            <span class="labelHeading">Workplace Diversity, Equity and Inculsion</span>
                        </div>
                        <div class="col-md-4 d-flex align-items-center align-content-center justify-content-center">
                            <div class="star-rating disabled">
                                <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="workplaceDEI" id="workplaceDEIStar5" value="5"
                                    disabled>
                                <label for="workplaceDEIStar5" title="5 Stars Rating">&#9733;</label>
                                <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="workplaceDEI" id="workplaceDEIStar4" value="4"
                                    disabled>
                                <label for="workplaceDEIStar4" title="4 Stars Rating">&#9733;</label>
                                <!-- 3 Star ✬ ✬ ✬ -->
                                <input type="radio" name="workplaceDEI" id="workplaceDEIStar3" value="3"
                                    disabled>
                                <label for="workplaceDEIStar3" title="3 Stars Rating">&#9733;</label>
                                <!-- 2 Star ✬ ✬ -->
                                <input type="radio" name="workplaceDEI" id="workplaceDEIStar2" value="2"
                                    disabled>
                                <label for="workplaceDEIStar2" title="2 Stars Rating">&#9733;</label>
                                <!-- 1 Star ✬ -->
                                <input type="radio" name="workplaceDEI" id="workplaceDEIStar1" value="1"
                                    disabled>
                                <label for="workplaceDEIStar1" title="1 Star Rating">&#9733;</label>
                            </div>
                        </div>

                        <!-- Compare Div --->
                        <div class="col-md-4 d-flex align-items-center align-content-center justify-content-center">
                            <div class="star-rating disabled    myChange">
                                <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="workplaceDEICompare" id="workplaceDEICompareStar5"
                                    value="5" disabled>
                                <label for="workplaceDEICompareStar5" title="5 Stars Rating">&#9733;</label>
                                <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="workplaceDEICompare" id="workplaceDEICompareStar4"
                                    value="4" disabled>
                                <label for="workplaceDEICompareStar4" title="4 Stars Rating">&#9733;</label>
                                <!-- 3 Star ✬ ✬ ✬ -->
                                <input type="radio" name="workplaceDEICompare" id="workplaceDEICompareStar3"
                                    value="3" disabled>
                                <label for="workplaceDEICompareStar3" title="3 Stars Rating">&#9733;</label>
                                <!-- 2 Star ✬ ✬ -->
                                <input type="radio" name="workplaceDEICompare" id="workplaceDEICompareStar2"
                                    value="2" disabled>
                                <label for="workplaceDEICompareStar2" title="2 Stars Rating">&#9733;</label>
                                <!-- 1 Star ✬ -->
                                <input type="radio" name="workplaceDEICompare" id="workplaceDEICompareStar1"
                                    value="1" disabled>
                                <label for="workplaceDEICompareStar1" title="1 Star Rating">&#9733;</label>
                            </div>
                        </div>
                    </div>

                    <!-- hr line -->
                    <hr class="mt-1" style="margin-bottom: 20px;">

                    <!-- Company Reputation -->
                    <div class="row form-group mb-2">
                        <div class="col-md-4 d-flex align-items-center ">
                            <span class="labelHeading">Company Reputation</span>
                        </div>
                        <div class="col-md-4 d-flex align-items-center align-content-center justify-content-center">
                            <div class="star-rating disabled">
                                <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="companyReputation" id="companyReputationStar5"
                                    value="5" disabled>
                                <label for="companyReputationStar5" title="5 Stars Rating">&#9733;</label>
                                <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="companyReputation" id="companyReputationStar4"
                                    value="4" disabled>
                                <label for="companyReputationStar4" title="4 Stars Rating">&#9733;</label>
                                <!-- 3 Star ✬ ✬ ✬ -->
                                <input type="radio" name="companyReputation" id="companyReputationStar3"
                                    value="3" disabled>
                                <label for="companyReputationStar3" title="3 Stars Rating">&#9733;</label>
                                <!-- 2 Star ✬ ✬ -->
                                <input type="radio" name="companyReputation" id="companyReputationStar2"
                                    value="2" disabled>
                                <label for="companyReputationStar2" title="2 Stars Rating">&#9733;</label>
                                <!-- 1 Star ✬ -->
                                <input type="radio" name="companyReputation" id="companyReputationStar1"
                                    value="1" disabled>
                                <label for="companyReputationStar1" title="1 Star Rating">&#9733;</label>
                            </div>
                        </div>

                        <!-- Compare Div --->
                        <div class="col-md-4 d-flex align-items-center align-content-center justify-content-center">
                            <div class="star-rating disabled    myChange">
                                <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="companyReputationCompare" id="companyReputationCompareStar5"
                                    value="5" disabled>
                                <label for="companyReputationCompareStar5" title="5 Stars Rating">&#9733;</label>
                                <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="companyReputationCompare" id="companyReputationCompareStar4"
                                    value="4" disabled>
                                <label for="companyReputationCompareStar4" title="4 Stars Rating">&#9733;</label>
                                <!-- 3 Star ✬ ✬ ✬ -->
                                <input type="radio" name="companyReputationCompare" id="companyReputationCompareStar3"
                                    value="3" disabled>
                                <label for="companyReputationCompareStar3" title="3 Stars Rating">&#9733;</label>
                                <!-- 2 Star ✬ ✬ -->
                                <input type="radio" name="companyReputationCompare" id="companyReputationCompareStar2"
                                    value="2" disabled>
                                <label for="companyReputationCompareStar2" title="2 Stars Rating">&#9733;</label>
                                <!-- 1 Star ✬ -->
                                <input type="radio" name="companyReputationCompare" id="companyReputationCompareStar1"
                                    value="1" disabled>
                                <label for="companyReputationCompareStar1" title="1 Star Rating">&#9733;</label>
                            </div>
                        </div>
                    </div>

                    <!-- hr line -->
                    <hr class="mt-1" style="margin-bottom: 20px;">

                    <!-- Workplace Safety and Security -->
                    <div class="row form-group mb-2">
                        <div class="col-md-4 d-flex align-items-center ">
                            <span class="labelHeading text-nowrap">Workplace Safety and Security</span>
                        </div>
                        <div class="col-md-4 d-flex align-items-center align-content-center justify-content-center">
                            <div class="star-rating disabled">
                                <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="workplaceSS" id="workplaceSSStar5" value="5" disabled>
                                <label for="companyReputationStar5" title="5 Stars Rating">&#9733;</label>
                                <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="workplaceSS" id="workplaceSSStar4" value="4" disabled>
                                <label for="workplaceSSStar4" title="4 Stars Rating">&#9733;</label>
                                <!-- 3 Star ✬ ✬ ✬ -->
                                <input type="radio" name="workplaceSS" id="workplaceSSStar3" value="3" disabled>
                                <label for="workplaceSSStar3" title="3 Stars Rating">&#9733;</label>
                                <!-- 2 Star ✬ ✬ -->
                                <input type="radio" name="workplaceSS" id="workplaceSSStar2" value="2" disabled>
                                <label for="workplaceSSStar2" title="2 Stars Rating">&#9733;</label>
                                <!-- 1 Star ✬ -->
                                <input type="radio" name="workplaceSS" id="workplaceSSStar1" value="1" disabled>
                                <label for="workplaceSSStar1" title="1 Star Rating">&#9733;</label>
                            </div>
                        </div>

                        <!-- Compare Div --->
                        <div class="col-md-4 d-flex align-items-center align-content-center justify-content-center">
                            <div class="star-rating disabled    myChange">
                                <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="workplaceSSCompare" id="workplaceSSCompareStar5"
                                    value="5" disabled>
                                <label for="workplaceSSCompareStar5" title="5 Stars Rating">&#9733;</label>
                                <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="workplaceSSCompare" id="workplaceSSCompareStar4"
                                    value="4" disabled>
                                <label for="workplaceSSCompareStar4" title="4 Stars Rating">&#9733;</label>
                                <!-- 3 Star ✬ ✬ ✬ -->
                                <input type="radio" name="workplaceSSCompare" id="workplaceSSCompareStar3"
                                    value="3" disabled>
                                <label for="workplaceSSCompareStar3" title="3 Stars Rating">&#9733;</label>
                                <!-- 2 Star ✬ ✬ -->
                                <input type="radio" name="workplaceSSCompare" id="workplaceSSCompareStar2"
                                    value="2" disabled>
                                <label for="workplaceSSCompareStar2" title="2 Stars Rating">&#9733;</label>
                                <!-- 1 Star ✬ -->
                                <input type="radio" name="workplaceSSCompare" id="workplaceSSCompareStar1"
                                    value="1" disabled>
                                <label for="workplaceSSCompareStar1" title="1 Star Rating">&#9733;</label>
                            </div>
                        </div>
                    </div>

                    <!-- hr line -->
                    <hr class="mt-1" style="margin-bottom: 20px;">

                    <!-- Company Growth and Future Plans -->
                    <div class="row form-group mb-2">
                        <div class="col-md-4 d-flex align-items-center ">
                            <span class="labelHeading">Company Growth and Future Plans</span>
                        </div>
                        <div class="col-md-4 d-flex align-items-center align-content-center justify-content-center">
                            <div class="star-rating disabled">
                                <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="growthFuturePlan" id="growthFuturePlanStar5" value="5"
                                    disabled>
                                <label for="growthFuturePlanStar5" title="5 Stars Rating">&#9733;</label>
                                <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="growthFuturePlan" id="growthFuturePlanStar4" value="4"
                                    disabled>
                                <label for="growthFuturePlanStar4" title="4 Stars Rating">&#9733;</label>
                                <!-- 3 Star ✬ ✬ ✬ -->
                                <input type="radio" name="growthFuturePlan" id="growthFuturePlanStar3" value="3"
                                    disabled>
                                <label for="growthFuturePlanStar3" title="3 Stars Rating">&#9733;</label>
                                <!-- 2 Star ✬ ✬ -->
                                <input type="radio" name="growthFuturePlan" id="growthFuturePlanStar2" value="2"
                                    disabled>
                                <label for="growthFuturePlanStar2" title="2 Stars Rating">&#9733;</label>
                                <!-- 1 Star ✬ -->
                                <input type="radio" name="growthFuturePlan" id="growthFuturePlanStar1" value="1"
                                    disabled>
                                <label for="growthFuturePlanStar1" title="1 Star Rating">&#9733;</label>
                            </div>
                        </div>

                        <!-- Compare Div --->
                        <div class="col-md-4 d-flex align-items-center align-content-center justify-content-center">
                            <div class="star-rating disabled    myChange">
                                <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="growthFuturePlanCompare" id="growthFuturePlanCompareStar5"
                                    value="5" disabled>
                                <label for="growthFuturePlanCompareStar5" title="5 Stars Rating">&#9733;</label>
                                <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="growthFuturePlanCompare" id="growthFuturePlanCompareStar4"
                                    value="4" disabled>
                                <label for="growthFuturePlanCompareStar4" title="4 Stars Rating">&#9733;</label>
                                <!-- 3 Star ✬ ✬ ✬ -->
                                <input type="radio" name="growthFuturePlanCompare" id="growthFuturePlanCompareStar3"
                                    value="3" disabled>
                                <label for="growthFuturePlanCompareStar3" title="3 Stars Rating">&#9733;</label>
                                <!-- 2 Star ✬ ✬ -->
                                <input type="radio" name="growthFuturePlanCompare" id="growthFuturePlanCompareStar2"
                                    value="2" disabled>
                                <label for="growthFuturePlanCompareStar2" title="2 Stars Rating">&#9733;</label>
                                <!-- 1 Star ✬ -->
                                <input type="radio" name="growthFuturePlanCompare" id="growthFuturePlanCompareStar1"
                                    value="1" disabled>
                                <label for="growthFuturePlanCompareStar1" title="1 Star Rating">&#9733;</label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('script')
    <!-- Script file to display loader  -->
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
    </script>

    <!-- Select 2 JS -->
    <script src="{{ asset('select2/select2.min.js') }}"></script>

    <!-- Global Variable -->
    <script type="text/javascript">
        var employeeHappiness = "{{ $data['employeeHappynessRating'] ? $data['employeeHappynessRating'] : 0 }}";
        var companyCulture = "{{ $data['companyCultureOverAllRating'] ? $data['companyCultureOverAllRating'] : 0 }}";
        var careerDevelopment =
            "{{ $data['careerDevelopmentOverAllRating'] ? $data['careerDevelopmentOverAllRating'] : 0 }}";
        var workLifeBalance = "{{ $data['workLifeBalanceOverAllRating'] ? $data['workLifeBalanceOverAllRating'] : 0 }}";
        var compensationBenefit =
            "{{ $data['compensationBenefitOverAllRating'] ? $data['compensationBenefitOverAllRating'] : 0 }}";
        var jobStability = "{{ $data['jobStabilityOverAllRating'] ? $data['jobStabilityOverAllRating'] : 0 }}";
        var workplaceDEI = "{{ $data['workplaceDEIOverAllRating'] ? $data['workplaceDEIOverAllRating'] : 0 }}";
        var companyReputation =
            "{{ $data['companyReputationOverAllRating'] ? $data['companyReputationOverAllRating'] : 0 }}";
        var workplaceSS = "{{ $data['workplaceSSOverAllRating'] ? $data['workplaceSSOverAllRating'] : 0 }}";
        var growthFuturePlan =
            "{{ $data['growthFuturePlanOverAllRating'] ? $data['growthFuturePlanOverAllRating'] : 0 }}";
        var searchIconUrl = "{{ asset('img/icons/searchIconCompareOrganization.svg') }}";

        // Url for 2nd -Compare div to Get the Organization Details to Compare
        var routeName =
            "{{ Auth::check() ? route('user.organization.compareOrganization', ['organizationId' => ':id']) : route('organization.compareOrganization', ['organizationId' => ':id']) }}";

        // Url for 2nd -Compare div to Show the Organization Details on Click
        var secondDivUrl =
            "{{ Auth::check() ? route('user.organization.show', ['id' => ':id']) : route('organization.show', ['id' => ':id']) }}";
    </script>
    <!-- Custom Script file -->
    <script type="text/javascript" src="{{ asset('js/user/organization/compareOrganization.js') }}"></script>

@endsection
