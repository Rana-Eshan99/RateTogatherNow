@extends('common.layouts.master')
@section('title', 'Feedback')
@section('headerHeading') Feedback @endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('css/appFeedback/feedbackPage.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
@endsection
@section('content')
    <!-- /.content-wrapper -->
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-3 custom-card">
                        <div class="card-body">
                            <form action="{{ route('user.appFeedback.saveAppFeedback') }}" method="POST">
                                @csrf
                                <input type="hidden" name="visitorId" id="visitorId" />
                                <div class="form-group mb-3">
                                    <span class="title">Give Feedback</span>
                                </div>
                                <div class="form-group mb-3">
                                    <span class="description">Tell us what you love about Rate Together Now  or what we could be
                                        doing better.</span>
                                </div>
                                <div class="form-group feedback-container">
                                    <div class="emoji-option emoji-option-bad" data-value="bad">
                                        <img src="{{ asset('img/feedbackIcons/bad_grey.png') }}" alt="Bad"
                                            class="emoji-image">
                                        <label>Bad</label>
                                    </div>
                                    <div class="emoji-option ml-3" data-value="somewhat">
                                        <img src="{{ asset('img/feedbackIcons/somewhat_grey.png') }}" alt="Somewhat">
                                        <label>Somewhat</label>
                                    </div>
                                    <div class="emoji-option ml-3" data-value="neutral">
                                        <img src="{{ asset('img/feedbackIcons/neutral_grey.png') }}" alt="Neutral">
                                        <label>Neutral</label>
                                    </div>
                                    <div class="emoji-option ml-3" data-value="good">
                                        <img src="{{ asset('img/feedbackIcons/good_grey.png') }}" alt="Good">
                                        <label>Good</label>
                                    </div>
                                    <div class="emoji-option ml-3" data-value="great">
                                        <img src="{{ asset('img/feedbackIcons/great_grey.png') }}" alt="Great">
                                        <label>Great</label>
                                    </div>
                                </div>
                                <span class="invalid-feedback d-block" id="emojiError" role="alert"></span>
                                <!-- Hidden input to store selected value for database -->
                                <input type="hidden" id="feedbackInput" name="feelings">

                                <div class="form-group mb-3 mt-5 marign-top">
                                    <div class="mb-2">
                                        <textarea name="feedback" id="experience" class="form-control customBorderRadiusExperience"
                                            placeholder="Enter feedback..."></textarea>
                                    </div>
                                    <div>
                                        <span class="invalid-feedback d-block" id="experienceError" role="alert"></span>
                                    </div>
                                    <span id="charCount">
                                        0/250
                                    </span>
                                </div>

                                <div class="form-group mb-1">
                                    <button type="submit" id="btnFeedbackSubmit"
                                        class="btn btn-primary customBorderRadius customBtnColor btnStyles">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('appFeedback.modal.appFeedbackModal')
@endsection
@section('script')
    <!-- Script file to display loader  -->
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
    </script>

    <!-- Sweet aler 2 Script files -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fingerprintjs/fingerprintjs@3/dist/fp.min.js"></script>
    <!-- Script file custom  -->
    <script src="{{ asset('js/appFeedback/appFeedback.js') }}"></script>
    <script>
        var storageBaseUrl = "{{ asset('') }}";
    </script>
@endsection
