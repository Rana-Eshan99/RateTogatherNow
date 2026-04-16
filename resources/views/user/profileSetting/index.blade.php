@extends('common.layouts.master')
@section('title', 'User Setting')
@section('headerHeading') User Setting @endsection
@section('style')
    <!-- Select 2  CSS-->
    <link rel="stylesheet" href="{{ asset('select2/select2.min.css') }}">
    <!-- Custom CSS for Select2 box -->
    <link rel="stylesheet" href="{{ asset('css/user/customSelect2Box.css') }}">
    <!-- Star Rating CSS -->
    <link rel="stylesheet" href="{{ asset('css/user/starRating.css') }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/user/customBorder.css') }}">
    <!-- Custom CSS for Saved Organizations -->
    <link rel="stylesheet" href="{{ asset('css/user/profileSetting/savedOrganization.css') }}">

    <!-- Custom CSS for Saved Peer -->
    <link rel="stylesheet" href="{{ asset('css/user/profileSetting/savedPeer.css') }}">

    <!-- Custom CSS for User's Profile Update -->
    <link rel="stylesheet" href="{{ asset('css/user/profileSetting/profileSetting.css') }}">

    <link rel="stylesheet" href="{{ asset('css/user/profileSetting/index.css') }}">

    <!-- Custom CSS for User Rated Organizations -->
    <link rel="stylesheet" href="{{ asset('css/user/profileSetting/myRatings.css') }}">



@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <br>

        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="card"
                style="margin-bottom: 0px; width: fit-content; border-radius: 8px 8px 0px 0px; background-color: #FFFFFF;">
                <!-- Nav tabs -->
                <div class="card-body d-flex" style="font-size: 16px; font-weight: 400; padding: 4px 122px 0px 36px;">
                    <ul class="nav flex-column flex-sm-row">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#profile">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#myRatings">My Ratings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#savedPeers">Saved Peers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#savedOrganizations">Saved Organizations</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Tab content -->
            <div class="card" style="margin-top: 0px; border-radius: 0px 8px 8px 8px; background-color: #FFFFFF;">
                <div class="card-body">
                    <div class="tab-content">
                        <!-- Profile Setting content goes here -->
                        <div id="profile" class="tab-pane active">
                            <!-- Profile Setting content goes here -->
                            @include('user.profileSetting.tabs.profileSetting')
                        </div>
                        <!-- /........ Profile Setting content goes here -->

                        <!-- My Rating content goes here -->
                        <div id="myRatings" class="tab-pane fade"
                            style="margin-top: 24px; margin-left:15px; margin-right:15px">
                            <!-- My Ratings content goes here -->
                            @include('user.profileSetting.tabs.ratings.index')
                        </div>
                        <!-- /.......... My Rating content goes here -->


                        <!-- Saved Peers content goes here -->
                        <div id="savedPeers" class="tab-pane fade">
                            <!-- Saved Peers content goes here -->
                            <div class="row" style="margin-top: 24px; margin-bottom:32px">
                                <div class="col-lg-8 col-md-6 col-sm-12 mb-1">
                                    <span id="savedPeerCount">
                                        {{ $userSavedsPeers['count'] }}
                                    </span>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12 mb-1 justify-content-end">
                                    <input type="hidden" name="routeNameSavedPeer" id="routeNameSavedPeer"
                                        value="{{ route('user.profileSetting.profileSettingForm') }}">
                                    <div class="input-group">
                                        <div class="input-group-prepend" style="position: relative; width:100%;">
                                            <input type="text" name="searchSavedPeer" id="searchSavedPeer"
                                                class="form-control customBorderRadius inputFieldHeight"
                                                placeholder="Search" style="padding-left: 40px;">
                                            <img class="img-responsive" src="{{ asset('img/icons/searchIcon.svg') }}"
                                                alt="Search"
                                                style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); pointer-events: none; height:20px; width:20px; object-fit: cover;"></img>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="savedPeerList">
                                @include('user.profileSetting.tabs.savedPeer.savedsPeer')
                            </div>
                        </div>
                        <!-- /.......... Saved Peers content goes here -->

                        <!-- Saved Organization content goes here -->
                        <div id="savedOrganizations" class="tab-pane fade">
                            <!-- Saved Organizations content goes here -->
                            <div class="row" style="margin-top: 24px; margin-bottom:32px">
                                <div class="col-lg-8 col-md-6 col-sm-12 mb-1">
                                    <span id="organizationCount">
                                        {{ $userSavedsOrganizations['count'] }}
                                    </span>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12 mb-1 justify-content-end">
                                    <input type="hidden" name="routeName" id="routeName"
                                        value="{{ route('user.profileSetting.profileSettingForm') }}">
                                    <div class="input-group">
                                        <div class="input-group-prepend" style="position: relative; width:100%;">
                                            <input type="text" name="searchOrganization" id="searchOrganization"
                                                class="form-control customBorderRadius inputFieldHeight"
                                                placeholder="Search" style="padding-left: 40px;">
                                            <img class="img-responsive" src="{{ asset('img/icons/searchIcon.svg') }}"
                                                alt="Search"
                                                style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); pointer-events: none; height:20px; width:20px; object-fit: cover;"></img>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="organizationList">
                                @include('user.profileSetting.tabs.savedOrganization.savedsOrganization')
                            </div>
                        </div>
                        <!-- /.......... Saved Organization content goes here -->

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

    <!-- Jquery Version -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <!-- Jquery Validation -->
    <script src="{{ asset('jquery/jquery.validate.min.js') }}"></script>
    <!-- Select 2 JS -->
    <script src="{{ asset('select2/select2.min.js') }}"></script>
    <!-- Script to show Add Department Modal -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Script file to display loader  -->
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
    </script>


    <!-- Sweet aler 2 Script files -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!--Custom Script files -->
    <script type="text/javascript" src="{{ asset('js/user/profileSetting/profileSetting.js') }}"></script>
    <!-- Custom Script file for Saveds Organization -->
    <script type="text/javascript" src="{{ asset('js/user/profileSetting/savedOrganization.js') }}"></script>
    <!-- Custom Script file to Un-Save the Organization -->
    <script type="text/javascript" src="{{ asset('js/user/profileSetting/unSaveOrganization.js') }}"></script>

    <!-- Custom Script file for Saveds Peer -->
    <script type="text/javascript" src="{{ asset('js/user/profileSetting/savedPeer.js') }}"></script>
    <!-- Custom Script file to Un-Save the Peer -->
    <script type="text/javascript" src="{{ asset('js/user/profileSetting/unSavePeer.js') }}"></script>


    <!-- Custom Script file for the Rated Organization -->
    <script type="text/javascript" src="{{ asset('js/user/profileSetting/ratingOrganization.js') }}"></script>
    <!-- Custom Script file for the Rated Peer -->
    <script type="text/javascript" src="{{ asset('js/user/profileSetting/ratingPeer.js') }}"></script>

    <script type="text/javascript">
        var userAvatarUrl = "{{ Auth::user()->getAvatarFullUrlAttribute() }}";

        var editProfile =
            @if ($errors->any())
                true
            @else
                false
            @endif ;
    </script>
    <script>
        var addDepartmentsUrl = "{{ route('user.department.add') }}";
    </script>

@endsection
