@extends('common.layouts.master')
@section('title', 'Organizations')
@section('headerHeading')  @endsection
@section('style')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard/reportedComments/reportedComments.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard/organization/viewmodel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard/organization/table.css') }}">
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper customPadding"  style="font-family: 'Source Sans 3', sans-serif !important;">
        <div class="container-fluid mt-2">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="title titleStyle"style="font-family: Source Sans 3;">Organizations</h1>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card" style="border-radius: 12px;">
                        <div class="card-body p-0 mt-3">
                            <div class="col-12 ">
                                <div class="row align-items-center">
                                    <!-- Nav for Tabs -->
                                    <div class="form-group col-xl-6 col-lg-6 col-md-6 pr-0">
                                        <ul class="nav">
                                            <li class="nav-item">
                                                <a href="#active-org" id="active-organizations"
                                                    class="nav-link active btn-primarys pr-3" data-toggle="tab">
                                                    Active Organizations
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#pending-appro" id="pending-approval"
                                                    class="nav-link btn-link text-dark pl-3" data-toggle="tab">
                                                    Pending Approval
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-xl-1 col-lg-1 col-md-1"></div>
                                    <!-- Search Input -->
                                    <div class="col-xl-5 col-lg-5 col-md-5">
                                        <div class="form-group">
                                            <div class="input-group-prepend"
                                                style="position: relative; width: 100%;">
                                                <input type="text" name="customSearchBox"
                                                    id="customSearchBox"
                                                    class="form-control customBorderRadius inputFieldHeights customSearchBox"
                                                    placeholder="Search here..."
                                                    style="padding-left: 46px; border-radius: 8px !important; ">
                                                <!-- Search Icon -->
                                                <img class="img-responsive" src="{{ asset('img/search.png') }}"
                                                    alt="Search"
                                                    style="position: absolute; left: 21px; top: 50%; transform: translateY(-50%); pointer-events: none; height: 18px; width: 18px; object-fit: cover;">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab Content -->
                                <div class="tab-content mt-1">
                                    <div class="tab-pane fade show active" id="active-org">
                                        <!-- Content for Organizations Reported Comments -->
                                        <section class="content p-0">
                                            <div class="container-fluid p-0">
                                                <div class="row">
                                                    <div class="col-12 p-0">
                                                        <table id="active-organizations-table" class="table">
                                                            <thead>
                                                                <tr class="thead-dark-custom">
                                                                    <th class="customHead">#</th>
                                                                    <th class="customHead head">Name</th>
                                                                    <th class="customHead">Status</th>
                                                                    <th class="customHead">Country</th>
                                                                    <th class="customHead">State or Province</th>
                                                                    <th class="customHead">City</th>
                                                                    <th class="customHead">Street Address</th>
                                                                    <th class="customHead">Reviews</th>
                                                                    <th class="customHead">Peers</th>
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
                                                                    <th class="customHead">Country</th>
                                                                    <th class="customHead">State or Province</th>
                                                                    <th class="customHead">City</th>
                                                                    <th class="customHead">Street Address</th>
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
        @include('dashboard.organization.modal.delete')
        @include('dashboard.organization.modal.view')
        @include('dashboard.organization.modal.reject')
    </div>


@endsection
@push('scripts')
    <script src="{{ asset('js/dashboard/organization/organization.js') }}"></script>
    <script>
       var fetchActiveOrganizationsData = '{!! route('admin.organization.fetchData') !!}';
       var fetchPendingApprovelOrganization = '{!! route('admin.organization.pendingApproval') !!}';
    </script>
    <script>
        var AWSURL = "{{ env('AWS_URL') }}";
        var defaultImage = "{{ asset('img/organizationDefaultAvatar.png') }}";
    </script>
@endpush
