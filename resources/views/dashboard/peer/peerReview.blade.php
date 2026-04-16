@extends('common.layouts.master')
@section('title', 'Peer Reviews')
@section('headerHeading')  @endsection
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
    <link rel="stylesheet" href="{{ asset('css/dashboard/organization/organizationDetailView.css') }}">


@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header" style="margin-top: 10px;">
            <div class="container-fluid">
                <div style="max-width: 100%;" >
                    <div style="display: flex; justify-content: flex-start; align-items: center; margin-bottom: 10px;">
                        <a href="{{ url()->previous() }}" style="margin-right: 10px;">
                            <svg width="24" height="24 " viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.90056 14.0208L14.4172 22.5375L12.25 24.6666L0.083374 12.5L12.25 0.333313L14.4172 2.46248L5.90056 10.9791H24.4167V14.0208H5.90056Z" fill="#1C1B1F"/>
                            </svg>
                        </a>
                        <h1 class="orgTitle">Peer Reviews</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">

                    <!-- Peers Table Section -->
                    <div class="col-md-12 peer-table">
                        <div class="row">
                            <div class="col-12">
                                <div class="card" style="border-radius: 12px;">
                                    <div class="card-body p-0 mt-3">
                                        <div class="col-12 ">
                                            <div class="row align-items-center">
                                                <!-- Nav for Tabs -->
                                                <!-- Search Input -->
                                                <div class="col-xl-6 col-lg-6 col-md-6">
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
                                                    <table id="peers-review-table" class="table">
                                                        <thead>
                                                            <tr class="thead-dark-custom">
                                                                <th class="customHead">#</th>
                                                                <th class="customHead head">Given By</th>
                                                                <th class="customHead">Peer Name</th>
                                                                <th class="customHead">Organization</th>
                                                                <th class="customHead">Date</th>
                                                                <th class="customHead">Overall</th>
                                                                <th class="customHead">Review</th>
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
    @include("dashboard.peer.modal.viewReview")
    <!-- /.content-wrapper -->
@endsection
@push('scripts')
    <script src="{{ asset('js/dashboard/peer/peerReview.js') }}"></script>
    <script>
        var peerId = {{ $peer->id }};
        var fetchPeerData = "{{ route('admin.peer.peerRating', ['id' => ':id']) }}".replace(':id', peerId);
        var organizationReview = "{{ route('admin.peer.peerReviewsDetail', ['id' => ':id']) }}".replace(':id', peerId);
    </script>
@endpush
