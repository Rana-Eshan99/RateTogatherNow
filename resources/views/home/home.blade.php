@extends('common.layouts.master')
@section('title', 'Home')
@section('headerHeading') Home @endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('css/home/homePage.css') }}">
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper  backgroundImage">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center">
                        <h1 class="text-dark h1">Discover, Insight, Connect, Unite</h1>
                        <p class="p">
                            Empower your career choices with transparent reviews
                            <span class="d-none d-md-inline"><br></span> <!-- This will only show on screens larger than 768px -->
                            of peers and workplaces.
                        </p>

                    </div>
                </div>
            </div>
        </div>

        {{-- nav tabs Organizations and peer  --}}
        <div class="container mt-4  listManage">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-md-8">
                    <div class="card-body listManageBody">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist"
                            style="padding: 4px 36px 0px 36px; gap: 12px; border-radius: 12px 12px 0px 0px; background-color: white; width: fit-content;">
                            <a class="nav-item nav-link active" id="nav-organizations-tab" data-toggle="tab"
                                href="#nav-organizations" role="tab" aria-controls="nav-organizations"
                                aria-selected="true"><span class="changeText">Organizations</span></a>
                            <a class="nav-item nav-link changeText" id="nav-peers-tab" data-toggle="tab" href="#nav-peers"
                                role="tab" aria-controls="nav-peers" aria-selected="false"><span
                                    class="changeText">Peers</span></a>
                        </div>
                        <div class="tab-content" style="box-shadow: 0px 35px 52px 0px #918F8F0F;">
                            <div class="tab-pane fade show active" id="nav-organizations" role="tabpanel"
                                aria-labelledby="nav-organizations-tab">
                                <div class="input-group mb-1 mycustom">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"
                                            style="padding: 0 0 0 36px; display: flex; align-items: center;">
                                            <img class="img-responsive"
                                                src="{{ asset('img/icons/searchIconListOrganization.svg') }}" alt="Search"
                                                style="height: 24px; width: 24px; object-fit: cover;">
                                        </span>
                                    </div>
                                    <input type="text" id="search-organizations" class="form-control mycustom"
                                        placeholder="Search organization name here..." aria-label="Search"
                                        aria-describedby="basic-addon1"
                                        style="padding-left: 10px; font-size: 15px; font-weight: 400;">

                                    <div class="input-group-append">
                                        <button class="btn btncus" type="submit" disabled>View</button>
                                    </div>

                                </div>
                            </div>

                            <div class="tab-pane fade" id="nav-peers" role="tabpanel" aria-labelledby="nav-peers-tab">
                                <div class="input-group mb-1 mycustom">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"
                                            style="padding: 0 0 0 36px; display: flex; align-items: center;">
                                            <img class="img-responsive"
                                                src="{{ asset('img/icons/searchIconListOrganization.svg') }}" alt="Search"
                                                style="height: 24px; width: 24px; object-fit: cover;">
                                        </span>
                                    </div>
                                    <input type="text" id="search-peers" class="form-control mycustom"
                                        placeholder="Search peer name here..." aria-label="Search"
                                        aria-describedby="basic-addon1"
                                        style="padding-left: 10px; font-size: 15px; font-weight: 400;">

                                    <div class="input-group-append">
                                        <button class="btn btncus" type="submit" disabled>View</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="visitorId" id="visitorId" />
    <!-- /.content-wrapper -->
@endsection
@php $hideFooter = true; @endphp
@section('script')
    <script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/home/home.js') }}"></script>
    <script>
        var getDataHome =
            "{{ Auth::check() ? route('user.organization-peer.getData') : route('organization-peer.getData') }}";
        var organizationUrl =
            "{{ Auth::check() ? route('user.organization.show', ['id' => ':id']) : route('organization.show', ['id' => ':id']) }}";
        var peerUrl =
            "{{ Auth::check() ? route('user.peer.show', ['id' => ':id']) : route('peer.show', ['id' => ':id']) }}";
        var userLoggedIn = "{{ Auth::check() ? 'true' : 'false' }}";
    </script>
    <script>
        var addOrganizationUrl = "{{ route('user.organization.addOrganizationForm') }}";
        var addPeerUrl = "{{ route('user.peer.addPeerForm') }}";
    </script>
     <script src="https://cdn.jsdelivr.net/npm/@fingerprintjs/fingerprintjs@3/dist/fp.min.js"></script>
@endsection
