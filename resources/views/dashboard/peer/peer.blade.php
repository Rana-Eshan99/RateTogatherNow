@extends('common.layouts.master')
@section('title', 'Peers')
@section('headerHeading') @endsection
@section('style')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard/reportedComments/reportedComments.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/dashboard/peer/viewmodel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard/peer/peer.css') }}">
    <link rel="stylesheet" href="{{ asset('select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/customBorder.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/customSelect2Box.css') }}">
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper customPadding" style="font-family: 'Source Sans 3', sans-serif !important;">
        <div class="container-fluid mt-2">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="title titleStyle"style="font-family: Source Sans 3;">Peers</h1>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card" style="border-radius: 12px;">
                        <div class="card-body p-0 mt-3">
                            <div class="col-12 ">
                                <div class="row align-items-center">
                                    <!-- Nav for Tabs -->
                                    <div class="form-group col-xxl-4 col-xl-4 col-lg-12 col-md-12">
                                        <ul class="nav">
                                            <li class="nav-item">
                                                <a href="#active-peer" id="active-peers" class="nav-link active btn-primarys pr-3" data-toggle="tab">
                                                    Active Peers
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#pending-appro" id="pending-approval" class="nav-link btn-link text-dark pl-3" data-toggle="tab">
                                                    Pending Approval
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Organization Filter -->
                                    <div class="col-xxl-2 col-xl-2 col-lg-6 col-md-6 changePaddingOrg">
                                        <div class="form-group">
                                            <div class="input-group-prepend" style="position: relative; width: 100%;">
                                                <select name="organization" id="organization" class="organizationSelectBox form-control">
                                                    <option value="" selected disabled>All Organizations</option>
                                                    <option value="-1" id="customOption">All Organizations</option>
                                                    @foreach ($organizations as $organization)
                                                        <option value="{{ $organization->id }}" class="organizationOption">
                                                            {{ $organization->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Department Filter -->
                                    <div class="col-xxl-2 col-xl-2 col-lg-6 col-md-6 changePaddingDep">
                                        <div class="form-group">
                                            <div class="input-group-prepend" style="position: relative; width: 100%;">
                                                <select name="department" id="department" class="form-control">
                                                    <option value="" selected disabled>Select Department</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Search Input -->
                                    <div class="col-xxl-4 col-xl-4 col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <div class="input-group-prepend" style="position: relative; width: 100%; height:52px">
                                                <input type="text" name="customSearchBox" id="customSearchBox"
                                                    class="form-control customBorderRadius inputFieldHeights customSearchBox"
                                                    placeholder="Search here..."
                                                    style="padding-left: 46px; border-radius: 8px !important;">
                                                <!-- Search Icon -->
                                                <img class="img-responsive" src="{{ asset('img/search.png') }}" alt="Search"
                                                    style="position: absolute; left: 21px; top: 50%; transform: translateY(-50%); pointer-events: none; height: 18px; width: 18px; object-fit: cover;">
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Tab Content -->
                                <div class="tab-content mt-1">
                                    <div class="tab-pane fade show active" id="active-peer">
                                        <!-- Content for Organizations Reported Comments -->
                                        <section class="content p-0">
                                            <div class="container-fluid p-0">
                                                <div class="row">
                                                    <div class="col-12 p-0">
                                                        <table id="active-peers-table" class="table">
                                                            <thead>
                                                                <tr class="thead-dark-custom">
                                                                    <th class="customHead">#</th>
                                                                    <th class="customHead head">Name</th>
                                                                    <th class="customHead">Status</th>
                                                                    <th class="customHead">Organization</th>
                                                                    <th class="customHead">Department</th>
                                                                    <th class="customHead">Job Title</th>
                                                                    <th class="customHead">Reviews</th>
                                                                    <th class="customHead">Actions</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                    <div class="tab-pane fade" id="pending-appro">
                                        <!-- Content for Peers Reported Comments -->
                                        <section class="content p-0">
                                            <div class="container-fluid p-0">
                                                <div class="row">
                                                    <div class="col-12 p-0">
                                                        <table id="pending-approval-table" class="table">
                                                            <thead>
                                                                <tr class="thead-dark-custom">
                                                                    <th class="customHead">#</th>
                                                                    <th class="customHead">Name</th>
                                                                    <th class="customHead">Status</th>
                                                                    <th class="customHead">Organization</th>
                                                                    <th class="customHead">Department</th>
                                                                    <th class="customHead">Job Title</th>
                                                                    <th class="customHead">Actions</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        @include('dashboard.peer.modal.delete')
        @include('dashboard.peer.modal.view')
        @include('dashboard.peer.modal.reject')
    </div>


@endsection
@push('scripts')
    <!-- Select 2 JS -->
    <script src="{{ asset('select2/select2.min.js') }}"></script>
    <!-- Script file to display loader  -->
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
    <!-- Sweet alert 2 Script files -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/dashboard/peer/peer.js') }}"></script>
    <script>
        var fetchActiveOrganizationsData = '{!! route('admin.peer.fetchData') !!}';
        var fetchPendingApprovelOrganization = '{!! route('admin.peer.pendingApproval') !!}';
    </script>
@endpush
