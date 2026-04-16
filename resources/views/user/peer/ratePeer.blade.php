@extends('common.layouts.master')
@section('title', 'Peer - Rating')
@section('headerHeading', 'Peer Rating')
@section('style')
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/user/customBorder.css') }}">
    <!-- Rating Star CSS -->
    <link rel="stylesheet" href="{{ asset('css/user/starRating.css') }}">

    <!-- Rate Peer CSS -->
    <link rel="stylesheet" href="{{ asset('css/user/peer/ratePeer.css') }}">
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">

            <br>
            <!-- First box Peer Info -->
            <div class="card customParentCardStyle">
                <div class="card-body">
                    <div class="row">
                        <!-- Peer Initial and Info Section -->
                        <div class="col-lg-4 col-md-12 col-sm-12 d-flex align-items-center mb-3">
                            <!-- Peer Initial Here -->
                            <div class="initialsOutsideDiv">
                                <div class="initialsInsideDiv" style="background-color: {{ $randomColor }};">
                                    <span class="initialsDivInsideText">
                                        {{ $peer->getPeerInitialsAttribute() }}
                                    </span>
                                </div>
                            </div>

                            <!-- Peer info -->
                            <div style="margin-left: 16px">
                                <div class="peerName" title="{{ $peer->getPeerFullNameAttribute() }}">
                                    {{ $peer->getPeerFullNameAttribute() }}
                                </div>
                                <div class="peerAddress" title="{{ $peer->jobTitle }} at {{ $peer->organization->name }}">
                                    {{ $peer->jobTitle }} at {{ $peer->organization->name }}
                                </div>
                            </div>
                        </div>

                        <!-- Work with Again Section -->
                        <div
                            class="col-lg-4 col-md-12 col-sm-12 d-flex align-items-center justify-content-lg-center justify-content-md-end mb-3">
                            <label class="overAllWorkAgain">Work with again: </label>

                            @if (
                                ($overAllRating['workAgainYesPercentage'] > $overAllRating['workAgainNoPercentage'] ||
                                    $overAllRating['workAgainYesPercentage'] >= $overAllRating['workAgainNoPercentage']) &&
                                    !($overAllRating['workAgainYesPercentage'] == 0 && $overAllRating['workAgainNoPercentage'] == 0))
                                <div class="overAllWorkAgainValue" style="background-color:#11951E;">
                                </div>
                                <span style="color: #58585D; font-size:18px; font-weight:500">
                                    {{ $overAllRating['workAgainYesPercentage'] }}% Yes
                                </span>
                            @elseif ($overAllRating['workAgainNoPercentage'] > $overAllRating['workAgainYesPercentage'])
                                <div class="overAllWorkAgainValue" style="background-color:#F94747;">
                                </div>
                                <span style="color: #58585D; font-size:18px; font-weight:500">
                                    {{ $overAllRating['workAgainNoPercentage'] }}% No
                                </span>
                            @elseif ($overAllRating['workAgainYesPercentage'] == 0 && $overAllRating['workAgainNoPercentage'] == 0)
                                <div class="overAllWorkAgainValue" style="background-color:#11951E;">
                                </div>
                                <span style="color: #58585D; font-size:18px; font-weight:500">
                                    0% Yes/No
                                </span>
                            @endif
                        </div>

                        <!-- Overall Rating and Save Section -->
                        <div class="col-lg-4 col-md-12 col-sm-12 d-flex align-items-center justify-content-end mb-3">

                            <div style="display: flex; align-items:center">
                                <label class="lblOverAllScore">Overall score:</label>
                                <label class="lblRatingOverAll">{{ $overAllRating['overAllRating'] }}</label>
                            </div>
                            <div class="star-rating disabled" style="margin-right: 15px;">
                                <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="rating" id="star5" value="5" disabled>
                                <label for="star5" title="5 Stars Rating">&#9733;</label>

                                <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                <input type="radio" name="rating" id="star4" value="4" disabled>
                                <label for="star4" title="4 Stars Rating">&#9733;</label>

                                <!-- 3 Star ✬ ✬ ✬ -->
                                <input type="radio" name="rating" id="star3" value="3" disabled>
                                <label for="star3" title="3 Stars Rating">&#9733;</label>

                                <!-- 2 Star ✬ ✬ -->
                                <input type="radio" name="rating" id="star2" value="2" disabled>
                                <label for="star2" title="2 Stars Rating">&#9733;</label>

                                <!-- 1 Star ✬ -->
                                <input type="radio" name="rating" id="star1" value="1" disabled>
                                <label for="star1" title="1 Star Rating">&#9733;</label>
                            </div>
                            <div class="align-items-center d-flex">
                                <form action="{{ route('user.peer.savedPeer') }}" method="POST" id="savedPeerForm">
                                    @csrf
                                    <input type="hidden" name="savedPeerId" id="savedPeerId" value="{{ $peer->id }}"
                                        readonly>
                                    <!-- Peer is already saved -->
                                    <a href="#" class="savedPeer" id="savedPeer"
                                        style="display: {{ $isSavedPeer == true ? 'block' : 'none' }};">
                                        <img src="{{ asset('img/icons/blueSavedIcon.png') }}" alt="Save">
                                    </a>

                                    <!-- Peer is not saved -->
                                    <a href="#" class="unSavedPeer" id="unSavedPeer"
                                        style="display: {{ $isSavedPeer == false ? 'block' : 'none' }};">
                                        <img src="{{ asset('img/icons/saveIcon.png') }}" alt="Un-Save">
                                    </a>
                                </form>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <!-- Second box Rate Organization -->
            <div class="card customChildCardStyle">
                <div class="card-body">
                    <!-- Introduction -->
                    <div class="form-group" style="margin-bottom: 24px;">
                        <label class="lblPeerName_Child">
                            Give Rating to <span id="peerName">{{ $peer->getPeerFullNameAttribute() }}</span>
                        </label>
                        <p class="peerRatingDesc">
                            We value your feedback! Please rate your experience with the peer using the star rating system
                            below. Your input helps us improve our services
                        </p>
                    </div>

                    <form action="{{ route('user.peer.savePeerRating') }}" method="POST" id="ratePeerForm">
                        @csrf
                        <input type="hidden" name="peerId" id="peerId" value="{{ $peer->id }}" readonly>
                        <input type="hidden" name="ratingId" id="ratingId" value="{{ $ratingId }}" readonly>
                        @if (isset($edit) && $edit == 1)
                            <input type="hidden" name="edit" value="1">
                        @endif
                        <!-- Easy Work -->
                        <div class="row form-group mb-2">
                            <div class="col-md-6 col-6 d-flex align-items-center ">
                                <label class="lblRating">How easy was it to work with this peer?</label>
                            </div>
                            <div class="col-md-6 col-6 d-flex align-items-center align-content-end justify-content-end">
                                <div class="star-rating enabled" id="easyWorkid">
                                    <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                    <input type="radio" value="5" name="easyWork" id="easyWorkStar5"
                                        {{ old('easyWork') == 5 ? 'checked' : '' }}>
                                    <label for="easyWorkStar5" title="5 Stars Rating">&#9733;</label>
                                    <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                    <input type="radio" value="4" name="easyWork" id="easyWorkStar4"
                                        {{ old('easyWork') == 4 ? 'checked' : '' }}>
                                    <label for="easyWorkStar4" title="4 Stars Rating">&#9733;</label>
                                    <!-- 3 Star ✬ ✬ ✬ -->
                                    <input type="radio" value="3" name="easyWork" id="easyWorkStar3"
                                        {{ old('easyWork') == 3 ? 'checked' : '' }}>
                                    <label for="easyWorkStar3" title="3 Stars Rating">&#9733;</label>
                                    <!-- 2 Star ✬ ✬ -->
                                    <input type="radio" value="2" name="easyWork" id="easyWorkStar2"
                                        {{ old('easyWork') == 2 ? 'checked' : '' }}>
                                    <label for="easyWorkStar2" title="2 Stars Rating">&#9733;</label>
                                    <!-- 1 Star ✬ -->
                                    <input type="radio" value="1" name="easyWork" id="easyWorkStar1"
                                        {{ old('easyWork') == 1 ? 'checked' : '' }}>
                                    <label for="easyWorkStar1" title="1 Star Rating">&#9733;</label>
                                </div>
                            </div>
                            <div class="col" style="text-align: end">
                                <span class="invalid-feedback validationError" id="easyWorkError" style="display: none"
                                    role="alert"></span>
                                @error('easyWork')
                                    <span class="invalid-feedback validationError" id="easyWorkError" style="display: none"
                                        role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- hr line -->
                        <hr class="mt-1" style="margin-bottom: 20px;">

                        <!-- Work Again -->
                        <div class="row form-group mb-2">
                            <div class="col-md-6 col-6 d-flex align-items-center ">
                                <label class="lblRating">Would you want to work with this peer again?</label>
                            </div>
                            <div class="col-md-6 col-6 d-flex align-items-center align-content-end justify-content-end">
                                <div style="display: flex; align-items: center; margin-bottom: 8px;">
                                    <!-- Yes Radio Button -->
                                    <div style="display: flex; align-items: center; margin-right: 20px;">
                                        <input type="radio" value="1" name="workAgain" id="workAgainYes"
                                            style="width: 24px; height: 24px;"
                                            {{ old('workAgain') == 1 ? 'checked' : '' }}>
                                        <label for="workAgainYes" title="Yes"
                                            style="color: #161617; font-size:16px; font-weight:600; margin-left: 5px; margin-bottom: 0px;">Yes</label>
                                    </div>

                                    <!-- No Radio Button -->
                                    <div style="display: flex; align-items: center;">
                                        <input type="radio" value="0" name="workAgain" id="workAgainNo"
                                            style="width: 24px; height: 24px;"
                                            {{ old('workAgain') == 0 ? 'checked' : '' }}>
                                        <label for="workAgainNo" title="No"
                                            style="color: #161617; font-size:16px; font-weight:600; margin-left: 5px; margin-bottom: 0px;">No</label>
                                    </div>
                                </div>

                            </div>
                            <div class="col" style="text-align: end">
                                <span class="invalid-feedback " id="workAgainError" role="alert"
                                    style="display: none"></span>
                                @error('workAgain')
                                    <span class="invalid-feedback" id="workAgainError" style="display: none"
                                        role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- hr line -->
                        <hr class="mt-1" style="margin-bottom: 20px;">

                        <!-- Dependable Work  -->
                        <div class="row form-group mb-2">
                            <div class="col-md-6 col-6 d-flex align-items-center ">
                                <label class="lblRating">How dependable is this peer in their work habits?</label>
                            </div>
                            <div class="col-md-6 col-6 d-flex align-items-center align-content-end justify-content-end">
                                <div class="star-rating enabled">
                                    <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                    <input type="radio" name="dependableWork" id="dependableWorkStar5"
                                        {{ old('dependableWork') == 5 ? 'checked' : '' }} value="5">
                                    <label for="dependableWorkStar5" title="5 Stars Rating">&#9733;</label>
                                    <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                    <input type="radio" value="4" name="dependableWork" id="dependableWorkStar4"
                                        {{ old('dependableWork') == 4 ? 'checked' : '' }}>
                                    <label for="dependableWorkStar4" title="4 Stars Rating">&#9733;</label>
                                    <!-- 3 Star ✬ ✬ ✬ -->
                                    <input type="radio" value="3" name="dependableWork" id="dependableWorkStar3"
                                        {{ old('dependableWork') == 3 ? 'checked' : '' }}>
                                    <label for="dependableWorkStar3" title="3 Stars Rating">&#9733;</label>
                                    <!-- 2 Star ✬ ✬ -->
                                    <input type="radio" value="2" name="dependableWork" id="dependableWorkStar2"
                                        {{ old('dependableWork') == 2 ? 'checked' : '' }}>
                                    <label for="dependableWorkStar2" title="2 Stars Rating">&#9733;</label>
                                    <!-- 1 Star ✬ -->
                                    <input type="radio" value="1" name="dependableWork" id="dependableWorkStar1"
                                        {{ old('dependableWork') == 1 ? 'checked' : '' }}>
                                    <label for="dependableWorkStar1" title="1 Star Rating">&#9733;</label>
                                </div>
                            </div>
                            <div class="col" style="text-align: end">
                                <span class="invalid-feedback" id="dependableWorkError" role="alert"
                                    style="display: none"></span>
                                @error('dependableWork')
                                    <span class="invalid-feedback" id="dependableWorkError" style="display: none"
                                        role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- hr line -->
                        <hr class="mt-1" style="margin-bottom: 20px;">

                        <!-- Communicate Under Pressure  -->
                        <div class="row form-group mb-2">
                            <div class="col-md-6 col-6 d-flex align-items-center ">
                                <label class="lblRating">How does this peer communicate when under pressure?</label>
                            </div>
                            <div class="col-md-6 col-6 d-flex align-items-center align-content-end justify-content-end">
                                <div class="star-rating enabled">
                                    <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                    <input type="radio" value="5" name="communicateUnderPressure"
                                        id="communicateUnderPressureStar5"
                                        {{ old('communicateUnderPressure') == 5 ? 'checked' : '' }}>
                                    <label for="communicateUnderPressureStar5" title="5 Stars Rating">&#9733;</label>
                                    <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                    <input type="radio" value="4" name="communicateUnderPressure"
                                        id="communicateUnderPressureStar4"
                                        {{ old('communicateUnderPressure') == 4 ? 'checked' : '' }}>
                                    <label for="communicateUnderPressureStar4" title="4 Stars Rating">&#9733;</label>
                                    <!-- 3 Star ✬ ✬ ✬ -->
                                    <input type="radio" value="3" name="communicateUnderPressure"
                                        id="communicateUnderPressureStar3"
                                        {{ old('communicateUnderPressure') == 3 ? 'checked' : '' }}>
                                    <label for="communicateUnderPressureStar3" title="3 Stars Rating">&#9733;</label>
                                    <!-- 2 Star ✬ ✬ -->
                                    <input type="radio" value="2" name="communicateUnderPressure"
                                        id="communicateUnderPressureStar2"
                                        {{ old('communicateUnderPressure') == 2 ? 'checked' : '' }}>
                                    <label for="communicateUnderPressureStar2" title="2 Stars Rating">&#9733;</label>
                                    <!-- 1 Star ✬ -->
                                    <input type="radio" value="1" name="communicateUnderPressure"
                                        id="communicateUnderPressureStar1"
                                        {{ old('communicateUnderPressure') == 1 ? 'checked' : '' }}>
                                    <label for="communicateUnderPressureStar1" title="1 Star Rating">&#9733;</label>
                                </div>
                            </div>
                            <div class="col" style="text-align: end">
                                <span class="invalid-feedback" id="communicateUnderPressureError" style="display: none"
                                    role="alert"></span>
                                @error('communicateUnderPressure')
                                    <span class="invalid-feedback" id="communicateUnderPressureError" style="display: none"
                                        role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- hr line -->
                        <hr class="mt-1" style="margin-bottom: 20px;">

                        <!-- Meet Deeadines -->
                        <div class="row form-group mb-2">
                            <div class="col-md-6 col-6 d-flex align-items-center ">
                                <label class="lblRating">How often does this peer meet deadlines?</label>
                            </div>
                            <div class="col-md-6 col-6 d-flex align-items-center align-content-end justify-content-end">
                                <div class="star-rating enabled">
                                    <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                    <input type="radio" value="5" name="meetDeadline" id="meetDeadlineStar5"
                                        {{ old('meetDeadline') == 5 ? 'checked' : '' }}>
                                    <label for="meetDeadlineStar5" title="5 Stars Rating">&#9733;</label>
                                    <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                    <input type="radio" value="4" name="meetDeadline" id="meetDeadlineStar4"
                                        {{ old('meetDeadline') == 4 ? 'checked' : '' }}>
                                    <label for="meetDeadlineStar4" title="4 Stars Rating">&#9733;</label>
                                    <!-- 3 Star ✬ ✬ ✬ -->
                                    <input type="radio" value="3" name="meetDeadline" id="meetDeadlineStar3"
                                        {{ old('meetDeadline') == 3 ? 'checked' : '' }}>
                                    <label for="meetDeadlineStar3" title="3 Stars Rating">&#9733;</label>
                                    <!-- 2 Star ✬ ✬ -->
                                    <input type="radio" value="2" name="meetDeadline" id="meetDeadlineStar2"
                                        {{ old('meetDeadline') == 2 ? 'checked' : '' }}>
                                    <label for="meetDeadlineStar2" title="2 Stars Rating">&#9733;</label>
                                    <!-- 1 Star ✬ -->
                                    <input type="radio" value="1" name="meetDeadline" id="meetDeadlineStar1"
                                        {{ old('meetDeadline') == 1 ? 'checked' : '' }}>
                                    <label for="meetDeadlineStar1" title="1 Star Rating">&#9733;</label>
                                </div>
                            </div>
                            <div class="col" style="text-align: end">
                                <span class="invalid-feedback" id="meetDeadlineError" style="display: none"
                                    role="alert"></span>
                                @error('meetDeadline')
                                    <span class="invalid-feedback" id="meetDeadlineError" style="display: none"
                                        role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- hr line -->
                        <hr class="mt-1" style="margin-bottom: 20px;">

                        <!-- Recieving Feedback -->
                        <div class="row form-group mb-2">
                            <div class="col-md-6 col-6 d-flex align-items-center ">
                                <label class="lblRating">How open is this peer to receiving feedback?</label>
                            </div>
                            <div class="col-md-6 col-6 d-flex align-items-center align-content-end justify-content-end">
                                <div class="star-rating enabled">
                                    <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                    <input type="radio" value="5" name="receivingFeedback"
                                        id="receivingFeedbackStar5" {{ old('receivingFeedback') == 5 ? 'checked' : '' }}>
                                    <label for="receivingFeedbackStar5" title="5 Stars Rating">&#9733;</label>
                                    <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                    <input type="radio" value="4" name="receivingFeedback"
                                        id="receivingFeedbackStar4" {{ old('receivingFeedback') == 4 ? 'checked' : '' }}>
                                    <label for="receivingFeedbackStar4" title="4 Stars Rating">&#9733;</label>
                                    <!-- 3 Star ✬ ✬ ✬ -->
                                    <input type="radio" value="3" name="receivingFeedback"
                                        id="receivingFeedbackStar3" {{ old('receivingFeedback') == 3 ? 'checked' : '' }}>
                                    <label for="receivingFeedbackStar3" title="3 Stars Rating">&#9733;</label>
                                    <!-- 2 Star ✬ ✬ -->
                                    <input type="radio" value="2" name="receivingFeedback"
                                        id="receivingFeedbackStar2" {{ old('receivingFeedback') == 2 ? 'checked' : '' }}>
                                    <label for="receivingFeedbackStar2" title="2 Stars Rating">&#9733;</label>
                                    <!-- 1 Star ✬ -->
                                    <input type="radio" value="1" name="receivingFeedback"
                                        id="receivingFeedbackStar1" {{ old('receivingFeedback') == 1 ? 'checked' : '' }}>
                                    <label for="receivingFeedbackStar1" title="1 Star Rating">&#9733;</label>
                                </div>
                            </div>
                            <div class="col" style="text-align: end">
                                <span class="invalid-feedback" id="receivingFeedbackError" style="display: none"
                                    role="alert"></span>
                                @error('receivingFeedback')
                                    <span class="invalid-feedback" id="receivingFeedbackError" style="display: none"
                                        role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- hr line -->
                        <hr class="mt-1" style="margin-bottom: 20px;">

                        <!-- Respectfull Other -->
                        <div class="row form-group mb-2">
                            <div class="col-md-6 col-6 d-flex align-items-center ">
                                <label class="lblRating">How respectful is this peer towards others?</label>
                            </div>
                            <div class="col-md-6 col-6 d-flex align-items-center align-content-end justify-content-end">
                                <div class="star-rating enabled">
                                    <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                    <input type="radio" value="5" name="respectfullOther"
                                        id="respectfullOtherStar5" {{ old('respectfullOther') == 5 ? 'checked' : '' }}>
                                    <label for="respectfullOtherStar5" title="5 Stars Rating">&#9733;</label>
                                    <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                    <input type="radio" value="4" name="respectfullOther"
                                        id="respectfullOtherStar4" {{ old('respectfullOther') == 4 ? 'checked' : '' }}>
                                    <label for="respectfullOtherStar4" title="4 Stars Rating">&#9733;</label>
                                    <!-- 3 Star ✬ ✬ ✬ -->
                                    <input type="radio" value="3" name="respectfullOther"
                                        id="respectfullOtherStar3" {{ old('respectfullOther') == 3 ? 'checked' : '' }}>
                                    <label for="respectfullOtherStar3" title="3 Stars Rating">&#9733;</label>
                                    <!-- 2 Star ✬ ✬ -->
                                    <input type="radio" value="2" name="respectfullOther"
                                        id="respectfullOtherStar2" {{ old('respectfullOther') == 2 ? 'checked' : '' }}>
                                    <label for="respectfullOtherStar2" title="2 Stars Rating">&#9733;</label>
                                    <!-- 1 Star ✬ -->
                                    <input type="radio" value="1" name="respectfullOther"
                                        id="respectfullOtherStar1" {{ old('respectfullOther') == 1 ? 'checked' : '' }}>
                                    <label for="respectfullOtherStar1" title="1 Star Rating">&#9733;</label>
                                </div>
                            </div>
                            <div class="col" style="text-align: end">
                                <span class="invalid-feedback" id="respectfullOtherError" style="display: none"
                                    role="alert"></span>
                                @error('respectfullOther')
                                    <span class="invalid-feedback" id="respectfullOtherError" style="display: none"
                                        role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- hr line -->
                        <hr class="mt-1" style="margin-bottom: 20px;">

                        <!-- Assit Other -->
                        <div class="row form-group mb-2">
                            <div class="col-md-6 col-6 d-flex align-items-center ">
                                <label class="lblRating">How often does this peer assist others when needed?</label>
                            </div>
                            <div class="col-md-6 col-6 d-flex align-items-center align-content-end justify-content-end">
                                <div class="star-rating enabled">
                                    <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                    <input type="radio" value="5" name="assistOther" id="assistOtherStar5"
                                        {{ old('assistOther') == 5 ? 'checked' : '' }}>
                                    <label for="assistOtherStar5" title="5 Stars Rating">&#9733;</label>
                                    <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                    <input type="radio" value="4" name="assistOther" id="assistOtherStar4"
                                        {{ old('assistOther') == 4 ? 'checked' : '' }}>
                                    <label for="assistOtherStar4" title="4 Stars Rating">&#9733;</label>
                                    <!-- 3 Star ✬ ✬ ✬ -->
                                    <input type="radio" value="3" name="assistOther" id="assistOtherStar3"
                                        {{ old('assistOther') == 3 ? 'checked' : '' }}>
                                    <label for="assistOtherStar3" title="3 Stars Rating">&#9733;</label>
                                    <!-- 2 Star ✬ ✬ -->
                                    <input type="radio" value="2" name="assistOther" id="assistOtherStar2"
                                        {{ old('assistOther') == 2 ? 'checked' : '' }}>
                                    <label for="assistOtherStar2" title="2 Stars Rating">&#9733;</label>
                                    <!-- 1 Star ✬ -->
                                    <input type="radio" value="1" name="assistOther" id="assistOtherStar1"
                                        {{ old('assistOther') == 1 ? 'checked' : '' }}>
                                    <label for="assistOtherStar1" title="1 Star Rating">&#9733;</label>
                                </div>
                            </div>
                            <div class="col" style="text-align: end">
                                <span class="invalid-feedback" id="assistOtherError" style="display: none"
                                    role="alert"></span>
                                @error('assistOther')
                                    <span class="invalid-feedback" id="assistOtherError" style="display: none"
                                        role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- hr line -->
                        <hr class="mt-1" style="margin-bottom: 20px;">

                        <!-- Collaborate Team -->
                        <div class="row form-group mb-2">
                            <div class="col-md-6 col-6 d-flex align-items-center ">
                                <label class="lblRating">How well does this peer collaborate with the team?</label>
                            </div>
                            <div class="col-md-6 col-6 d-flex align-items-center align-content-end justify-content-end">
                                <div class="star-rating enabled">
                                    <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                    <input type="radio" value="5" name="collaborateTeam"
                                        id="collaborateTeamStar5" {{ old('collaborateTeam') == 5 ? 'checked' : '' }}>
                                    <label for="collaborateTeamStar5" title="5 Stars Rating">&#9733;</label>
                                    <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                    <input type="radio" value="4" name="collaborateTeam"
                                        id="collaborateTeamStar4" {{ old('collaborateTeam') == 4 ? 'checked' : '' }}>
                                    <label for="collaborateTeamStar4" title="4 Stars Rating">&#9733;</label>
                                    <!-- 3 Star ✬ ✬ ✬ -->
                                    <input type="radio" value="3" name="collaborateTeam"
                                        id="collaborateTeamStar3" {{ old('collaborateTeam') == 3 ? 'checked' : '' }}>
                                    <label for="collaborateTeamStar3" title="3 Stars Rating">&#9733;</label>
                                    <!-- 2 Star ✬ ✬ -->
                                    <input type="radio" value="2" name="collaborateTeam"
                                        id="collaborateTeamStar2" {{ old('collaborateTeam') == 2 ? 'checked' : '' }}>
                                    <label for="collaborateTeamStar2" title="2 Stars Rating">&#9733;</label>
                                    <!-- 1 Star ✬ -->
                                    <input type="radio" value="1" name="collaborateTeam"
                                        id="collaborateTeamStar1" {{ old('collaborateTeam') == 1 ? 'checked' : '' }}>
                                    <label for="collaborateTeamStar1" title="1 Star Rating">&#9733;</label>
                                </div>
                            </div>
                            <div class="col" style="text-align: end">
                                <span class="invalid-feedback" id="collaborateTeamError" style="display: none"
                                    role="alert"></span>
                                @error('collaborateTeam')
                                    <span class="invalid-feedback" id="collaborateTeamError" style="display: none"
                                        role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- hr line -->
                        <hr class="mt-1" style="margin-bottom: 20px;">

                        <br>
                        <br>
                        <div class="form-group mb-1">
                            <label class=" experienceHeading">
                                Share your experience working with this peer.<br>
                                What strengths did the demonstrate? What areas could use improvements?
                            </label>
                            <ul class="" style="font-size:16px;font-weight:400; color: #00000080;">
                                <li>We may remove your rating if it includes inappropriate language.</li>
                                <li>Use the rating categories to provide the feedback.</li>
                            </ul>
                        </div>

                        <!-- Experience -->
                        <div class="form-group mb-3">
                            <div class="mb-2">
                                <textarea name="experience" id="experience" class="form-control customBorderRadius" maxlength="600"
                                    placeholder="What information do you want to share about this peer?" style="">{{ $peerRating ? $peerRating->experience : old('experience') }}</textarea>
                            </div>
                            <div>
                                <span class="invalid-feedback" id="experienceError" style="display: none"
                                    role="alert"></span>
                                @error('experience')
                                    <span class="invalid-feedback validationError" id="experienceError" style="display: none"
                                        role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <span id="charCount">
                                0/600
                            </span>
                        </div>

                        <!-- Terms & Conditions -->
                        <div class="form-group mb-2">
                            <p class="">
                                By clicking the "Submit" button, I confirmed that I have read and agreed to the RateMyPeers
                                Suite Guidelines,
                                <a href="{{ route('termsAndCondition') }}" target="_blank">Terms of Service</a>, and
                                <a href="{{ route('privacyPolicy') }}" target="_blank">Privacy Policy</a>.
                                Submittted reviews become the property of Rate Together Now .
                            </p>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group mb-1">
                            <button type="submit" id="btnRatePeer" style="height:50px;"
                                class="btn btn-primary customBorderRadius customBtnColor">Submit</button>
                        </div>
                    </form>

                </div>
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    @include('user.peer.modal.ratedPeerModal')
@endsection
@section('script')
    <!-- Script file to display loader  -->
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
    </script>

    <!-- Sweet aler 2 Script files -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Custom Script Files -->
    <script type="text/javascript" src="{{ asset('js/user/peer/ratePeer.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/user/peer/saveUnSavePeer.js') }}"></script>

    <!-- Global Variable -->
    <script type="text/javascript">
        // Gloable Variable to Set redirectBackUrl on Rating
        var redirectBackUrl =
            "{{ auth()->check() ? route('user.peer.show', ['id' => $peer->id]) : route('peer.show', ['id' => $peer->id]) }}";
        var sessionPeerRated = "{{ session('peerRated') ? 'true' : 'false' }}";
        var userLoggedIn = "{{ Auth::check() ? 'true' : 'false' }}";
        var overAllRating = {{ $overAllRating['overAllRating'] }};
        var easyWork = "{{ $peerRating ? $peerRating->easyWork : 0 }}";
        var workAgain = "{{ $peerRating ? $peerRating->workAgain : 'null' }}";
        var dependableWork = "{{ $peerRating ? $peerRating->dependableWork : 0 }}";
        var communicateUnderPressure = "{{ $peerRating ? $peerRating->communicateUnderPressure : 0 }}";
        var meetDeadline = "{{ $peerRating ? $peerRating->meetDeadline : 0 }}";
        var receivingFeedback = "{{ $peerRating ? $peerRating->receivingFeedback : 0 }}";
        var respectfullOther = "{{ $peerRating ? $peerRating->respectfullOther : 0 }}";
        var assistOther = "{{ $peerRating ? $peerRating->assistOther : 0 }}";
        var collaborateTeam = "{{ $peerRating ? $peerRating->collaborateTeam : 0 }}";
    </script>
@endsection
