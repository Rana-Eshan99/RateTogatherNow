@extends('common.layouts.master')
@section('title', request()->is('user/organization/*') ? 'Organization - Feedback' : 'Peer - Feedback')
@section('headerHeading') Feedback @endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('css/home/reportRating/reportRating.css') }}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/user/customBorder.css') }}">
@endsection
@section('content')
    <!-- /.content-wrapper -->
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-3 customParentCardStyle">
                        <div class="card-body">
                            <form method="POST"
                                action="{{ request()->is('user/organization/*') ? route('user.organization.addReportRatingOrganization') : route('user.peer.addReportRatingPeer') }}">
                                @csrf
                                <div class="form-group mb-3">
                                    <span class="title">Report Harassment or Bullying</span>
                                </div>
                                <div class="form-group mb-3">
                                    <span class="description">We are committed to maintaining a safe and respectful
                                        environment for all users. If you feel that a comment is bullying, offensive, or
                                        inappropriate, please let us know. All reports are confidential and will be handled
                                        promptly..</span>
                                </div>
                                <div class="form-group mb-3 mt-5">
                                    <div class="mb-2">
                                        <input type="hidden" name="organization_peerRatingId"
                                            id="organization_peerRatingId" value="{{ $organization_peerRatingId }}"
                                            readonly>
                                        <textarea name="experience" id="experience" class="form-control customBorderRadiusExperience"
                                            placeholder="What information do you want to share..">{{ $data ? $data->report : old('experience') }}</textarea>
                                    </div>
                                    <div>
                                        <span class="invalid-feedback d-block" id="experienceError" role="alert"></span>
                                        @error('experience')
                                            <span class="invalid-feedback validationError d-block" id="experienceError"
                                                role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <span id="charCount">
                                        0/250
                                    </span>
                                </div>

                                <div class="form-group mb-1">
                                    <button type="submit" id="btnReportRating"
                                        class="btn btn-primary customBtnColor">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('home.modal.reportRatingModal')
@endsection
@section('script')
    <!-- Script file to display loader  -->
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
    </script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Custom Script file -->
    <script type="text/javascript" src="{{ asset('js/home/reportRating/reportRating.js') }}"></script>


    <!-- Define Global Variable -->
    <script type="text/javascript">
        var sessionReportRated = "{{ session('reportRated') ? true : false }}";
        // Determine the redirect URL based on the session 'type'
        var redirectBackUrl = "#"; // Default value

        @if (session('type') === 'organization')
            redirectBackUrl = "{{ auth()->check() ? route('user.organization.show', ['id' => $data->organizationId]) : route('organization.show', ['id' => $data->organizationId]) }}";
        @elseif (session('type') === 'peer')
            redirectBackUrl = "{{ auth()->check() ? route('user.peer.show', ['id' => $data->peerId]) : route('peer.show', ['id' => $data->peerId]) }}";
        @endif
    </script>

@endsection
