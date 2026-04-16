@extends('common.layouts.master')
@section('title', 'Organization - List')
@section('headerHeading', 'Organizations')
@section('style')
    <!-- Star Rating CSS -->
    <link rel="stylesheet" href="{{ asset('css/user/starRating.css') }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/user/customBorder.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/organization/listOrganization.css') }}">
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content" style="margin: 10px;">

            <!-- Default box -->
            <div class="card customParentCardStyle">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10">
                            <span class="cardHeading">Organizations</span>
                            <p class="cardHeadingText">
                                Please provide the necessary details to register a new organization.
                                This information will help us maintain accurate and up-to-date records, ensuring that all
                                related activities are properly documented and managed.
                                This process will help us build a comprehensive profile for your organization, promoting
                                transparency and fostering stronger relationships.
                            </p>
                        </div>
                        <div class="col-md-2 d-flex justify-content-end" style="height: fit-content;">
                            <a href="{{ route('user.organization.addOrganizationForm') }}" id="btnAddOrganization"
                                class="btn btn-primary customBtnColor btnStyles">Add Organization</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->

            <!-- Default box -->
            <div class="card customParentCardStyle">
                <div class="card-body">
                    <div class="row d-flex justify-content-between" style="margin-top: 24px; margin-bottom:28px">
                        <!-- Organization Count -->
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-1">
                            <span id="organizationCount">{{ $organizationCount }}</span>
                        </div>

                        <!-- Organization Search Filter -->
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-1 justify-content-end">
                            <input type="hidden" name="routeName" id="routeName"
                                value="{{ Auth::check() ? route('user.organization.list.organizationName') : route('organization.list.organizationName') }}">
                            <div class="input-group">
                                <div class="input-group-prepend" style="position: relative; width:100%;">
                                    <input type="text" name="searchOrganization" id="searchOrganization"
                                        class="form-control customBorderRadius inputFieldHeight" placeholder="Search">
                                    <img class="img-responsive" id="searchIcon" alt="Search"
                                        src="{{ asset('img/icons/searchIconListOrganization.svg') }}"></img>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="organizationList">
                        <!-- Display the Organization list in the card using pagination -->
                        @include('user.organization.ajaxView.listOrganizationAjaxView')
                        <input type="hidden" name="visitorId" id="visitorId" />

                    </div>

                </div>
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>


    <!-- /.content-wrapper -->
    @include('common.layouts.compulsorySweetAlert')
@endsection
@section('script')
    <!-- Script file to display loader  -->
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
    </script>
    <!-- Sweet alert 2 Script files -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        var userLoggedIn = "{{ Auth::check() ? 'true' : 'false' }}";
    </script>
    <script type="text/javascript" src="{{ asset('js/user/organization/listSaveUnSaveOrganization.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/user/organization/listOrganization.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fingerprintjs/fingerprintjs@3/dist/fp.min.js"></script>
@endsection
