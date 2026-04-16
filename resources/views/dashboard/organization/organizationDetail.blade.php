@extends('common.layouts.master')
@section('title', 'Organization Detail')
@section('headerHeading') @endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('css/user/customBorder.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard/reportedComments/reportedComments.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard/organization/viewmodel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard/organization/table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard/organization/organizationDetail.css') }}">

@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header" style="margin-top: 10px;">
            <div class="container-fluid">
                <div style="max-width: 100%;" >
                    <div style="display: flex; justify-content: flex-start; align-items: center; margin-bottom: 10px;">
                        <a href="{{ route('admin.organization.index') }}" style="margin-right: 10px;">
                            <svg width="24" height="24 " viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.90056 14.0208L14.4172 22.5375L12.25 24.6666L0.083374 12.5L12.25 0.333313L14.4172 2.46248L5.90056 10.9791H24.4167V14.0208H5.90056Z" fill="#1C1B1F"/>
                            </svg>
                        </a>
                        <h1 class="orgTitle">Organization</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- Organization Details Section -->
                    <div class="col-md-4 org-details mb-4">
                        <div class="card" style="border-radius: 4px;">
                            <div class="card-body">
                                <div class="text-center">
                                    <img src="{{ $organization->getImageFullUrlAttribute() }}" alt="Avatar" class="rounded-circle" width="100" height="100" style="height: 100px; width: 100px; border-radius: 999px; margin-bottom: 16px; border: 2px solid; border-color: rgb(227, 242, 254);"
                                    onerror="this.onerror=null;this.src='{{ asset('img/organizationDefaultAvatar.png') }}';">
                                    <h5 class="mt-2 orgName">{{ $organization->name }}</h5>
                                    <a href="{{ route('admin.organization.organizationRating', $organization->id) }}" class="customChanges">{{ $organizationRatings }} Reviews</a>
                                </div>
                                <div>
                                    <hr>
                                </div>
                                <ul class="list-group list-group-flush marifnChange">

                                    <li class="list-group-item d-flex align-items-center justify-content-between pl-1 pr-1 mt-0">
                                        <strong class="changeStyle">Rating</strong>
                                        <span class="customChange">{{ number_format($formattedOverAllRating, 1) }}</span>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center justify-content-between pl-1 pr-1">
                                        <strong class="changeStyle">Country</strong>
                                        <span class="truncate customChange" title="{{ $organization->country }}">
                                            {{ \Illuminate\Support\Str::words($organization->country, 3, '...') }}
                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center justify-content-between pl-1 pr-1">
                                        <strong class="changeStyle">State/Province</strong>
                                        <span class="truncate customChange" title="{{ $organization->state }}">
                                            {{ \Illuminate\Support\Str::words($organization->state, 3, '...') }}
                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center justify-content-between pl-1 pr-1">
                                        <strong class="changeStyle">City</strong>
                                        <span class="truncate customChange" title="{{ $organization->city }}">
                                            {{ $organization->city }}
                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center justify-content-between pl-1 pr-1">
                                        <strong class="changeStyle">Street Address</strong>
                                        <span class="truncate customChange" title="{{ $organization->address }}" style="text-align: end">
                                            {{ $organization->address }}
                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center justify-content-between pl-1 pr-1">
                                        <strong class="changeStyle">Peers</strong>
                                        <span class="customChange">{{ $organization->peers?->count() ?? 0 }}</span>
                                    </li>

                                </ul>
                                <div class="text-center mt-2 mb-4 pl-2 pr-2">
                                    <button type="button" class="delete-peer-btn delete" data-id="{{ $organization->id }}" id="peerDelete" data-toggle="modal" data-target="#delete">
                                        <img src="{{ asset('img/icons/deleteutton.svg') }}" alt="Delete Icon">
                                       <span class="del">Delete</span>
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                    @include('dashboard.organization.modal.organizationDetailDelete')
                    <!-- Peers Table Section -->
                    <div class="col-md-8 peer-table">
                        <div class="row">
                            <div class="col-12">
                                <div class="card" style="border-radius: 12px;">
                                    <div class="card-body p-0">
                                        <div class="col-12 ">
                                            <div class="row align-items-center">
                                                <!-- Nav for Tabs -->
                                                <div class="form-group col-xl-6 col-lg-6 col-md-6 pr-0 mt-2">
                                                    <h3 class="titleStylePeer">Peers at {{ \Illuminate\Support\Str::words($organization->name, 5, '...') }}
                                                    </h3>
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

                                            <div class="row">
                                                <div class="col-12 p-0">
                                                    <table id="active-organizations-table" class="table">
                                                        <thead>
                                                            <tr class="thead-dark-custom">
                                                                <th class="customHead">#</th>
                                                                <th class="customHead head">Name</th>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@include('dashboard.organization.modal.organizationPeerDelete')
    <!-- /.content-wrapper -->
@endsection
@push('scripts')
    <script src="{{ asset('js/dashboard/organization/organizationDetail.js') }}"></script>
    <script>
        var organizationId = {{ $organization->id }};
        var fetchOrganizationPeerData = "{{ route('admin.organization.organizationPeers', ['id' => ':id']) }}".replace(':id', organizationId);
        var organizationDelete = "{{ route('admin.organization.delete', ['id' => ':id']) }}".replace(':id', organizationId);
    </script>
@endpush
