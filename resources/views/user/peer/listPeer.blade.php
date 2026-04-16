@extends('common.layouts.master')
@section('title', 'Peer - List')
@section('headerHeading', 'Peers')
@section('style')
    <!-- Select 2  CSS-->
    <link rel="stylesheet" href="{{ asset('select2/select2.min.css') }}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/user/customBorder.css') }}">
    <!-- Custom CSS for Select2 box -->
    <link rel="stylesheet" href="{{ asset('css/user/customSelect2Box.css') }}">
    <!-- Star Rating CSS -->
    <link rel="stylesheet" href="{{ asset('css/user/starRating.css') }}">

    <!-- Custom CSS for List Peer -->
    <link rel="stylesheet" href="{{ asset('css/user/peer/listPeer.css') }}">

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
                    <div class="row">
                        <div class="col-md-10">
                            <label class="cardHeading">Peers</label>
                            <p class="headingParagraph">
                                Please provide the necessary details to register a new peer.
                                This information will help us maintain accurate and up-to-date records, ensuring that all
                                related activities are properly documented and managed.
                                This process will help us build a comprehensive profile for your organization, promoting
                                transparency and fostering stronger relationships.
                            </p>
                        </div>
                        <div class="col-md-2 d-flex justify-content-end" style="height: fit-content;">
                            <a href="{{ $organizationId ? route('user.peer.addPeerForm', ['id' => $organizationId]) : route('user.peer.addPeerForm') }}"
                                id="btnAddPeer" class="btn btn-primary btnStyles">
                                Add a Peer
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->


            <!-- List box -->
            <div class="card customParentCardStyle">
                <div class="card-body">
                    <!-- Peer Cont & Search Filter  -->
                    <div class="row" style="margin-top: 24px; margin-bottom:28px">
                        <!-- Peer Count -->
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label id="peerCount">{{ $peerCount }}</label>
                        </div>

                        <!-- Search Peer and Filters -->
                        <div class="col-lg-8 col-md-8 col-sm-12 d-flex flex-wrap justify-content-end">
                            <!-- Search Peer -->
                            <div class="input-group col-lg-4 col-md-4 col-sm-12 mb-1">
                                <div class="input-group-prepend" style="position: relative; width:100%;">
                                    <input type="text" name="searchPeer" id="searchPeer"
                                        class="form-control customBorderRadius inputFieldHeight" placeholder="Search"
                                        style="padding-left: 40px;">
                                    <img class="img-responsive searchIcon" alt="Search"
                                        src="{{ asset('img/icons/searchIconListOrganization.svg') }}"></img>
                                </div>
                            </div>

                            <!-- Organization Filter -->
                            <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                                <select name="organization" id="organization" class="organizationSelectBox form-control">
                                    <option value="" selected disabled>All Organizations</option>
                                    <option value="-1" id="customOption">All Organizations</option>
                                    @foreach ($organizations as $organization)
                                        <option value="{{ $organization->id }}" class="organizationOption"
                                            data-name="{{ $organization->name }}" data-address="{{ $organization->address }}"
                                            {{ $organizationId == $organization->id ? 'selected' : '' }}>
                                            {{ $organization->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Department Filter -->
                            <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                                <select name="department" id="department" class="form-control">
                                    <option value="" selected disabled>Select Department</option>
                                    @if ($departments && $departments->isNotEmpty())
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    @else
                                        <option value="" disabled>No Departments Available</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>


                    <!-- Peer List -->
                    <div id="peerList">
                        @include('user.peer.ajaxView.peerDataList')
                        <input type="hidden" name="visitorId" id="visitorId" />

                    </div>
                    <!-- /.......... Saved Peer content goes here -->


                    <!-- -->
                </div>
            </div>
            <!-- /.card -->


        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('script')
    <!-- Select 2 JS -->
    <script src="{{ asset('select2/select2.min.js') }}"></script>
    <!-- Script file to display loader  -->
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
    </script>
    <!-- Sweet alert 2 Script files -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        var userLoggedIn = "{{ Auth::check() ? 'true' : 'false' }}";
    </script>

    <!-- Custom Script Files -->
    <script type="text/javascript" src="{{ asset('js/user/peer/listPeer.js') }}"></script>
    <!-- Script file to Save, Un-Save the Peer -->
    <script type="text/javascript" src="{{ asset('js/user/peer/listSaveUnSavePeer.js') }}"></script>
@endsection
