@extends('common.layouts.master')
@section('title', 'Peer - Compare')
@section('headerHeading', 'Compare Peers')
@section('style')
    <!-- Select 2  CSS-->
    <link rel="stylesheet" href="{{ asset('select2/select2.min.css') }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/user/customBorder.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/customSelect2Box.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/peer/comparePeer.css') }}">
    <!-- Star Rating CSS -->
    <link rel="stylesheet" href="{{ asset('css/user/starRating.css') }}">

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
                    <div class="row form-group mb-4">
                        <!-- 1st Div -->
                        <div class="col-md-6 d-flex align-items-top">
                            <span class="cardHeading">Compare Peers</span>
                        </div>

                        <!-- 2nd Div -->
                        <div class="col-md-6 d-flex align-items-center justify-content-end" style="padding-right: 15px;">
                            <button type="reset" class="btn resetBtnColor" id="btnReset" disabled>Reset</button>
                        </div>
                    </div>

                    <div class="row form-group mb-4">
                        <div class="col-md-4 d-flex align-items-center">
                            <input type="hidden"
                                value="{{ Auth::check() ? route('user.peer.show', ['id' => $data['id']]) : route('peer.show', ['id' => $data['id']]) }}"
                                id="divUrl">
                        </div>
                        <div
                            class="col-md-4 d-flex align-items-center align-content-center justify-content-center form-group mb-2">
                            <div id="firstDivOverAllRating" class="container">
                                <div class="peerFullName" title="{{ $data['peerFullName'] }}">
                                    {{ $data['peerFullName'] }}
                                </div>
                                <div class="overall-rating">
                                    <span>Overall Rating</span><br>
                                    <span class="rating-value">{{ $data['overAllRating'] }}</span>
                                </div>
                            </div>
                        </div>

                        <div
                            class="col-md-4 d-flex align-items-center align-content-center justify-content-center form-group mb-2">
                            <div id="comparePeerDiv" class="comparePeerContainer">
                                <div class="input-group" id="searchComparePeerDiv" style="text-align: left;">
                                    <select id="searchComparePeer" name="searchComparePeer" class="form-control inputFieldHeight customBorderRadius">
                                        <option value="" selected disabled>Search Peer</option>
                                        @if ($peerCompareList)
                                            @foreach ($peerCompareList as $peer)
                                                <option value="{{ $peer->id }}"
                                                    data-peer-name="{{ $peer->getPeerFullNameAttribute() }}"
                                                    data-job-title="{{ $peer->jobTitle }}"
                                                    data-organization="{{ $peer->organization->name }}">
                                                    {{ $peer->getPeerFullNameAttribute() }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <span id="comparePeerName" title=""></span>
                                <div class="overall-rating">
                                    <span>Overall Rating</span><br>
                                    <span id="overAllRatingCompare" class="rating-value">N/A</span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Easy Work -->
                    <div class="row form-group mb-2">
                        <div class="col-md-4 d-flex align-items-center ">
                            <label class="lblRating">How easy was it to work with this peer?</label>
                        </div>
                        <div class="col-md-4 d-flex align-items-center align-content-center justify-content-center">
                            <div class="star-rating disabled">
                                <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                <input type="radio" value="5" disabled name="easyWork" id="easyWorkStar5">
                                <label for="easyWorkStar5" title="5 Stars Rating">&#9733;</label>
                                <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                <input type="radio" value="4" disabled name="easyWork" id="easyWorkStar4">
                                <label for="easyWorkStar4" title="4 Stars Rating">&#9733;</label>
                                <!-- 3 Star ✬ ✬ ✬ -->
                                <input type="radio" value="3" disabled name="easyWork" id="easyWorkStar3">
                                <label for="easyWorkStar3" title="3 Stars Rating">&#9733;</label>
                                <!-- 2 Star ✬ ✬ -->
                                <input type="radio" value="2" disabled name="easyWork" id="easyWorkStar2">
                                <label for="easyWorkStar2" title="2 Stars Rating">&#9733;</label>
                                <!-- 1 Star ✬ -->
                                <input type="radio" value="1" disabled name="easyWork" id="easyWorkStar1">
                                <label for="easyWorkStar1" title="1 Star Rating">&#9733;</label>
                            </div>
                        </div>

                        <!-- Compare Div --->
                        <div class="col-md-4 d-flex align-items-center align-content-center justify-content-center">
                            <div class="star-rating disabled    myChange">
                                <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                <input type="radio" value="5" disabled name="easyWorkCompare"
                                    id="easyWorkCompareStar5">
                                <label for="easyWorkCompareStar5" title="5 Stars Rating">&#9733;</label>
                                <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                <input type="radio" value="4" disabled name="easyWorkCompare"
                                    id="easyWorkCompareStar4">
                                <label for="easyWorkCompareStar4" title="4 Stars Rating">&#9733;</label>
                                <!-- 3 Star ✬ ✬ ✬ -->
                                <input type="radio" value="3" disabled name="easyWorkCompare"
                                    id="easyWorkCompareStar3">
                                <label for="easyWorkCompareStar3" title="3 Stars Rating">&#9733;</label>
                                <!-- 2 Star ✬ ✬ -->
                                <input type="radio" value="2" disabled name="easyWorkCompare"
                                    id="easyWorkCompareStar2">
                                <label for="easyWorkCompareStar2" title="2 Stars Rating">&#9733;</label>
                                <!-- 1 Star ✬ -->
                                <input type="radio" value="1" disabled name="easyWorkCompare"
                                    id="easyWorkCompareStar1">
                                <label for="easyWorkCompareStar1" title="1 Star Rating">&#9733;</label>
                            </div>
                        </div>
                    </div>

                    <!-- hr line -->
                    <hr class="mt-1" style="margin-bottom: 20px;">

                    <!-- Work Again -->
                    <div class="row form-group mb-2">
                        <div class="col-md-4 d-flex align-items-center ">
                            <label class="lblRating">Would you want to work with this peer again?</label>
                        </div>
                        <div class="col-md-4 d-flex align-items-center align-content-center justify-content-center">
                            <div class="d-flex align-items-center justify-content-end">
                                @if (
                                    ($data['workAgainYesPercentage'] > $data['workAgainNoPercentage'] ||
                                        $data['workAgainYesPercentage'] >= $data['workAgainNoPercentage']) &&
                                        !($data['workAgainYesPercentage'] == 0 && $data['workAgainNoPercentage'] == 0))
                                    <div class="workAgainBox" style="background-color: #11951E;">
                                    </div>
                                    <label class="workAgainYesRating">{{ $data['workAgainYesPercentage'] }}% Yes</label>
                                @elseif ($data['workAgainNoPercentage'] > $data['workAgainYesPercentage'])
                                    <div class="workAgainBox" style="background-color: #F94747;">
                                    </div>
                                    <label class="workAgainYesRating">{{ $data['workAgainNoPercentage'] }}% No</label>
                                @elseif ($data['workAgainYesPercentage'] == 0 && $data['workAgainNoPercentage'] == 0)
                                    <div class="workAgainBox" style="background-color: #11951E;">
                                    </div>
                                    <label class="workAgainYesRating">0% Yes/No</label>
                                @endif
                            </div>
                        </div>

                        <!-- Compare Div --->
                        <div class="col-md-4 d-flex align-items-center align-content-center justify-content-center">
                            <div class="d-flex align-items-center justify-content-end">
                                <div class="workAgainBox    myChange" id="compareWorkAgainBox">
                                </div>
                                <label class="workAgainYesRating" id="workAgainYesRatingCompare"></label>
                            </div>
                        </div>
                    </div>

                    <!-- hr line -->
                    <hr class="mt-1" style="margin-bottom: 20px;">

                    <!-- Dependable Work  -->
                    <div class="row form-group mb-2">
                        <div class="col-md-4 d-flex align-items-center ">
                            <label class="lblRating">How dependable is this peer in their work habits?</label>
                        </div>
                        <div class="col-md-4 d-flex align-items-center align-content-center justify-content-center">
                            <div class="star-rating disabled">
                                <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                <input type="radio" value="5" disabled name="dependableWork"
                                    id="dependableWorkStar5">
                                <label for="dependableWorkStar5" title="5 Stars Rating">&#9733;</label>
                                <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                <input type="radio" value="4" disabled name="dependableWork"
                                    id="dependableWorkStar4">
                                <label for="dependableWorkStar4" title="4 Stars Rating">&#9733;</label>
                                <!-- 3 Star ✬ ✬ ✬ -->
                                <input type="radio" value="3" disabled name="dependableWork"
                                    id="dependableWorkStar3">
                                <label for="dependableWorkStar3" title="3 Stars Rating">&#9733;</label>
                                <!-- 2 Star ✬ ✬ -->
                                <input type="radio" value="2" disabled name="dependableWork"
                                    id="dependableWorkStar2">
                                <label for="dependableWorkStar2" title="2 Stars Rating">&#9733;</label>
                                <!-- 1 Star ✬ -->
                                <input type="radio" value="1" disabled name="dependableWork"
                                    id="dependableWorkStar1">
                                <label for="dependableWorkStar1" title="1 Star Rating">&#9733;</label>
                            </div>
                        </div>

                        <!-- Compare Div --->
                        <div class="col-md-4 d-flex align-items-center align-content-center justify-content-center">
                            <div class="star-rating disabled    myChange">
                                <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                <input type="radio" value="5" disabled name="dependableWorkCompare"
                                    id="dependableWorkCompareStar5">
                                <label for="dependableWorkCompareStar5" title="5 Stars Rating">&#9733;</label>
                                <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                <input type="radio" value="4" disabled name="dependableWorkCompare"
                                    id="dependableWorkCompareStar4">
                                <label for="dependableWorkCompareStar4" title="4 Stars Rating">&#9733;</label>
                                <!-- 3 Star ✬ ✬ ✬ -->
                                <input type="radio" value="3" disabled name="dependableWorkCompare"
                                    id="dependableWorkCompareStar3">
                                <label for="dependableWorkCompareStar3" title="3 Stars Rating">&#9733;</label>
                                <!-- 2 Star ✬ ✬ -->
                                <input type="radio" value="2" disabled name="dependableWorkCompare"
                                    id="dependableWorkCompareStar2">
                                <label for="dependableWorkCompareStar2" title="2 Stars Rating">&#9733;</label>
                                <!-- 1 Star ✬ -->
                                <input type="radio" value="1" disabled name="dependableWorkCompare"
                                    id="dependableWorkCompareStar1">
                                <label for="dependableWorkCompareStar1" title="1 Star Rating">&#9733;</label>
                            </div>
                        </div>
                    </div>

                    <!-- hr line -->
                    <hr class="mt-1" style="margin-bottom: 20px;">

                    <!-- Communicate Under Pressure  -->
                    <div class="row form-group mb-2">
                        <div class="col-md-4 d-flex align-items-center ">
                            <label class="lblRating">How does this peer communicate when under pressure?</label>
                        </div>
                        <div class="col-md-4 d-flex align-items-center align-content-center justify-content-center">
                            <div class="star-rating disabled">
                                <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                <input type="radio" value="5" disabled name="communicateUnderPressure"
                                    id="communicateUnderPressureStar5">
                                <label for="communicateUnderPressureStar5" title="5 Stars Rating">&#9733;</label>
                                <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                <input type="radio" value="4" disabled name="communicateUnderPressure"
                                    id="communicateUnderPressureStar4">
                                <label for="communicateUnderPressureStar4" title="4 Stars Rating">&#9733;</label>
                                <!-- 3 Star ✬ ✬ ✬ -->
                                <input type="radio" value="3" disabled name="communicateUnderPressure"
                                    id="communicateUnderPressureStar3">
                                <label for="communicateUnderPressureStar3" title="3 Stars Rating">&#9733;</label>
                                <!-- 2 Star ✬ ✬ -->
                                <input type="radio" value="2" disabled name="communicateUnderPressure"
                                    id="communicateUnderPressureStar2">
                                <label for="communicateUnderPressureStar2" title="2 Stars Rating">&#9733;</label>
                                <!-- 1 Star ✬ -->
                                <input type="radio" value="1" disabled name="communicateUnderPressure"
                                    id="communicateUnderPressureStar1">
                                <label for="communicateUnderPressureStar1" title="1 Star Rating">&#9733;</label>
                            </div>
                        </div>

                        <!-- Compare Div --->
                        <div class="col-md-4 d-flex align-items-center align-content-center justify-content-center">
                            <div class="star-rating disabled    myChange">
                                <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                <input type="radio" value="5" disabled name="communicateUnderPressureCompare"
                                    id="communicateUnderPressureCompareStar5">
                                <label for="communicateUnderPressureCompareStar5" title="5 Stars Rating">&#9733;</label>
                                <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                <input type="radio" value="4" disabled name="communicateUnderPressureCompare"
                                    id="communicateUnderPressureCompareStar4">
                                <label for="communicateUnderPressureCompareStar4" title="4 Stars Rating">&#9733;</label>
                                <!-- 3 Star ✬ ✬ ✬ -->
                                <input type="radio" value="3" disabled name="communicateUnderPressureCompare"
                                    id="communicateUnderPressureCompareStar3">
                                <label for="communicateUnderPressureCompareStar3" title="3 Stars Rating">&#9733;</label>
                                <!-- 2 Star ✬ ✬ -->
                                <input type="radio" value="2" disabled name="communicateUnderPressureCompare"
                                    id="communicateUnderPressureCompareStar2">
                                <label for="communicateUnderPressureCompareStar2" title="2 Stars Rating">&#9733;</label>
                                <!-- 1 Star ✬ -->
                                <input type="radio" value="1" disabled name="communicateUnderPressureCompare"
                                    id="communicateUnderPressureCompareStar1">
                                <label for="communicateUnderPressureCompareStar1" title="1 Star Rating">&#9733;</label>
                            </div>
                        </div>
                    </div>

                    <!-- hr line -->
                    <hr class="mt-1" style="margin-bottom: 20px;">

                    <!-- Meet Deeadines -->
                    <div class="row form-group mb-2">
                        <div class="col-md-4 d-flex align-items-center ">
                            <label class="lblRating">How often does this peer meet deadlines?</label>
                        </div>
                        <div class="col-md-4 d-flex align-items-center align-content-center justify-content-center">
                            <div class="star-rating disabled">
                                <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                <input type="radio" value="5" disabled name="meetDeadline"
                                    id="meetDeadlineStar5">
                                <label for="meetDeadlineStar5" title="5 Stars Rating">&#9733;</label>
                                <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                <input type="radio" value="4" disabled name="meetDeadline"
                                    id="meetDeadlineStar4">
                                <label for="meetDeadlineStar4" title="4 Stars Rating">&#9733;</label>
                                <!-- 3 Star ✬ ✬ ✬ -->
                                <input type="radio" value="3" disabled name="meetDeadline"
                                    id="meetDeadlineStar3">
                                <label for="meetDeadlineStar3" title="3 Stars Rating">&#9733;</label>
                                <!-- 2 Star ✬ ✬ -->
                                <input type="radio" value="2" disabled name="meetDeadline"
                                    id="meetDeadlineStar2">
                                <label for="meetDeadlineStar2" title="2 Stars Rating">&#9733;</label>
                                <!-- 1 Star ✬ -->
                                <input type="radio" value="1" disabled name="meetDeadline"
                                    id="meetDeadlineStar1">
                                <label for="meetDeadlineStar1" title="1 Star Rating">&#9733;</label>
                            </div>
                        </div>

                        <!-- Compare Div --->
                        <div class="col-md-4 d-flex align-items-center align-content-center justify-content-center">
                            <div class="star-rating disabled    myChange">
                                <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                <input type="radio" value="5" disabled name="meetDeadlineCompare"
                                    id="meetDeadlineCompareStar5">
                                <label for="meetDeadlineCompareStar5" title="5 Stars Rating">&#9733;</label>
                                <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                <input type="radio" value="4" disabled name="meetDeadlineCompare"
                                    id="meetDeadlineCompareStar4">
                                <label for="meetDeadlineCompareStar4" title="4 Stars Rating">&#9733;</label>
                                <!-- 3 Star ✬ ✬ ✬ -->
                                <input type="radio" value="3" disabled name="meetDeadlineCompare"
                                    id="meetDeadlineCompareStar3">
                                <label for="meetDeadlineCompareStar3" title="3 Stars Rating">&#9733;</label>
                                <!-- 2 Star ✬ ✬ -->
                                <input type="radio" value="2" disabled name="meetDeadlineCompare"
                                    id="meetDeadlineCompareStar2">
                                <label for="meetDeadlineCompareStar2" title="2 Stars Rating">&#9733;</label>
                                <!-- 1 Star ✬ -->
                                <input type="radio" value="1" disabled name="meetDeadlineCompare"
                                    id="meetDeadlineCompareStar1">
                                <label for="meetDeadlineCompareStar1" title="1 Star Rating">&#9733;</label>
                            </div>
                        </div>
                    </div>

                    <!-- hr line -->
                    <hr class="mt-1" style="margin-bottom: 20px;">

                    <!-- Recieving Feedback -->
                    <div class="row form-group mb-2">
                        <div class="col-md-4 d-flex align-items-center ">
                            <label class="lblRating">How open is this peer to receiving feedback?</label>
                        </div>
                        <div class="col-md-4 d-flex align-items-center align-content-center justify-content-center">
                            <div class="star-rating disabled">
                                <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                <input type="radio" value="5" disabled name="receivingFeedback"
                                    id="receivingFeedbackStar5">
                                <label for="receivingFeedbackStar5" title="5 Stars Rating">&#9733;</label>
                                <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                <input type="radio" value="4" disabled name="receivingFeedback"
                                    id="receivingFeedbackStar4">
                                <label for="receivingFeedbackStar4" title="4 Stars Rating">&#9733;</label>
                                <!-- 3 Star ✬ ✬ ✬ -->
                                <input type="radio" value="3" name="receivingFeedback"
                                    id="receivingFeedbackStar3">
                                <label for="receivingFeedbackStar3" title="3 Stars Rating">&#9733;</label>
                                <!-- 2 Star ✬ ✬ -->
                                <input type="radio" value="2" disabled name="receivingFeedback"
                                    id="receivingFeedbackStar2">
                                <label for="receivingFeedbackStar2" title="2 Stars Rating">&#9733;</label>
                                <!-- 1 Star ✬ -->
                                <input type="radio" value="1" disabled name="receivingFeedback"
                                    id="receivingFeedbackStar1">
                                <label for="receivingFeedbackStar1" title="1 Star Rating">&#9733;</label>
                            </div>
                        </div>

                        <!-- Compare Div --->
                        <div class="col-md-4 d-flex align-items-center align-content-center justify-content-center">
                            <div class="star-rating disabled    myChange">
                                <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                <input type="radio" value="5" disabledname="receivingFeedbackCompare"
                                    id="receivingFeedbackCompareStar5">
                                <label for="receivingFeedbackCompareStar5" title="5 Stars Rating">&#9733;</label>
                                <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                <input type="radio" value="4" disabled name="receivingFeedbackCompare"
                                    id="receivingFeedbackCompareStar4">
                                <label for="receivingFeedbackCompareStar4" title="4 Stars Rating">&#9733;</label>
                                <!-- 3 Star ✬ ✬ ✬ -->
                                <input type="radio" value="3" disabled name="receivingFeedbackCompare"
                                    id="receivingFeedbackCompareStar3">
                                <label for="receivingFeedbackCompareStar3" title="3 Stars Rating">&#9733;</label>
                                <!-- 2 Star ✬ ✬ -->
                                <input type="radio" value="2" disabled name="receivingFeedbackCompare"
                                    id="receivingFeedbackCompareStar2">
                                <label for="receivingFeedbackCompareStar2" title="2 Stars Rating">&#9733;</label>
                                <!-- 1 Star ✬ -->
                                <input type="radio" value="1" disabled name="receivingFeedbackCompare"
                                    id="receivingFeedbackCompareStar1">
                                <label for="receivingFeedbackCompareStar1" title="1 Star Rating">&#9733;</label>
                            </div>
                        </div>
                    </div>

                    <!-- hr line -->
                    <hr class="mt-1" style="margin-bottom: 20px;">

                    <!-- Respectfull Other -->
                    <div class="row form-group mb-2">
                        <div class="col-md-4 d-flex align-items-center ">
                            <label class="lblRating">How respectful is this peer towards others?</label>
                        </div>
                        <div class="col-md-4 d-flex align-items-center align-content-center justify-content-center">
                            <div class="star-rating disabled">
                                <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                <input type="radio" value="5" disabled name="respectfullOther"
                                    id="respectfullOtherStar5">
                                <label for="respectfullOtherStar5" title="5 Stars Rating">&#9733;</label>
                                <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                <input type="radio" value="4" disabled name="respectfullOther"
                                    id="respectfullOtherStar4">
                                <label for="respectfullOtherStar4" title="4 Stars Rating">&#9733;</label>
                                <!-- 3 Star ✬ ✬ ✬ -->
                                <input type="radio" value="3" disabled name="respectfullOther"
                                    id="respectfullOtherStar3">
                                <label for="respectfullOtherStar3" title="3 Stars Rating">&#9733;</label>
                                <!-- 2 Star ✬ ✬ -->
                                <input type="radio" value="2" disabled name="respectfullOther"
                                    id="respectfullOtherStar2">
                                <label for="respectfullOtherStar2" title="2 Stars Rating">&#9733;</label>
                                <!-- 1 Star ✬ -->
                                <input type="radio" value="1" disabled name="respectfullOther"
                                    id="respectfullOtherStar1">
                                <label for="respectfullOtherStar1" title="1 Star Rating">&#9733;</label>
                            </div>
                        </div>

                        <!-- Compare Div --->
                        <div class="col-md-4 d-flex align-items-center align-content-center justify-content-center">
                            <div class="star-rating disabled    myChange">
                                <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                <input type="radio" value="5" disabled name="respectfullOtherCompare"
                                    id="respectfullOtherCompareStar5">
                                <label for="respectfullOtherCompareStar5" title="5 Stars Rating">&#9733;</label>
                                <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                <input type="radio" value="4" disabled name="respectfullOtherCompare"
                                    id="respectfullOtherCompareStar4">
                                <label for="respectfullOtherCompareStar4" title="4 Stars Rating">&#9733;</label>
                                <!-- 3 Star ✬ ✬ ✬ -->
                                <input type="radio" value="3" disabled name="respectfullOtherCompare"
                                    id="respectfullOtherCompareStar3">
                                <label for="respectfullOtherCompareStar3" title="3 Stars Rating">&#9733;</label>
                                <!-- 2 Star ✬ ✬ -->
                                <input type="radio" value="2" disabled name="respectfullOtherCompare"
                                    id="respectfullOtherCompareStar2">
                                <label for="respectfullOtherCompareStar2" title="2 Stars Rating">&#9733;</label>
                                <!-- 1 Star ✬ -->
                                <input type="radio" value="1" disabled name="respectfullOtherCompare"
                                    id="respectfullOtherCompareStar1">
                                <label for="respectfullOtherCompareStar1" title="1 Star Rating">&#9733;</label>
                            </div>
                        </div>
                    </div>

                    <!-- hr line -->
                    <hr class="mt-1" style="margin-bottom: 20px;">

                    <!-- Assit Other -->
                    <div class="row form-group mb-2">
                        <div class="col-md-4 d-flex align-items-center ">
                            <label class="lblRating">How often does this peer assist others when needed?</label>
                        </div>
                        <div class="col-md-4 d-flex align-items-center align-content-center justify-content-center">
                            <div class="star-rating disabled">
                                <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                <input type="radio" value="5" disabled name="assistOther" id="assistOtherStar5">
                                <label for="assistOtherStar5" title="5 Stars Rating">&#9733;</label>
                                <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                <input type="radio" value="4" disabled name="assistOther" id="assistOtherStar4">
                                <label for="assistOtherStar4" title="4 Stars Rating">&#9733;</label>
                                <!-- 3 Star ✬ ✬ ✬ -->
                                <input type="radio" value="3" disabled name="assistOther" id="assistOtherStar3">
                                <label for="assistOtherStar3" title="3 Stars Rating">&#9733;</label>
                                <!-- 2 Star ✬ ✬ -->
                                <input type="radio" value="2" disabled name="assistOther" id="assistOtherStar2">
                                <label for="assistOtherStar2" title="2 Stars Rating">&#9733;</label>
                                <!-- 1 Star ✬ -->
                                <input type="radio" value="1" disabled name="assistOther" id="assistOtherStar1">
                                <label for="assistOtherStar1" title="1 Star Rating">&#9733;</label>
                            </div>
                        </div>

                        <!-- Compare Div --->
                        <div class="col-md-4 d-flex align-items-center align-content-center justify-content-center">
                            <div class="star-rating disabled    myChange">
                                <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                <input type="radio" value="5" disabled name="assistOtherCompare"
                                    id="assistOtherCompareStar5">
                                <label for="assistOtherCompareStar5" title="5 Stars Rating">&#9733;</label>
                                <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                <input type="radio" value="4" disabled name="assistOtherCompare"
                                    id="assistOtherCompareStar4">
                                <label for="assistOtherCompareStar4" title="4 Stars Rating">&#9733;</label>
                                <!-- 3 Star ✬ ✬ ✬ -->
                                <input type="radio" value="3" disabled name="assistOtherCompare"
                                    id="assistOtherCompareStar3">
                                <label for="assistOtherCompareStar3" title="3 Stars Rating">&#9733;</label>
                                <!-- 2 Star ✬ ✬ -->
                                <input type="radio" value="2" disabled name="assistOtherCompare"
                                    id="assistOtherCompareStar2">
                                <label for="assistOtherCompareStar2" title="2 Stars Rating">&#9733;</label>
                                <!-- 1 Star ✬ -->
                                <input type="radio" value="1" disabled name="assistOtherCompare"
                                    id="assistOtherCompareStar1">
                                <label for="assistOtherCompareStar1" title="1 Star Rating">&#9733;</label>
                            </div>
                        </div>
                    </div>

                    <!-- hr line -->
                    <hr class="mt-1" style="margin-bottom: 20px;">

                    <!-- Collaborate Team -->
                    <div class="row form-group mb-2">
                        <div class="col-md-4 d-flex align-items-center ">
                            <label class="lblRating">How weel does this peer collaborate with the team?</label>
                        </div>
                        <div class="col-md-4 d-flex align-items-center align-content-center justify-content-center">
                            <div class="star-rating disabled">
                                <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                <input type="radio" value="5" disabled name="collaborateTeam"
                                    id="collaborateTeamStar5">
                                <label for="collaborateTeamStar5" title="5 Stars Rating">&#9733;</label>
                                <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                <input type="radio" value="4" disabled name="collaborateTeam"
                                    id="collaborateTeamStar4">
                                <label for="collaborateTeamStar4" title="4 Stars Rating">&#9733;</label>
                                <!-- 3 Star ✬ ✬ ✬ -->
                                <input type="radio" value="3" disabled name="collaborateTeam"
                                    id="collaborateTeamStar3">
                                <label for="collaborateTeamStar3" title="3 Stars Rating">&#9733;</label>
                                <!-- 2 Star ✬ ✬ -->
                                <input type="radio" value="2" disabled name="collaborateTeam"
                                    id="collaborateTeamStar2">
                                <label for="collaborateTeamStar2" title="2 Stars Rating">&#9733;</label>
                                <!-- 1 Star ✬ -->
                                <input type="radio" value="1" disabled name="collaborateTeam"
                                    id="collaborateTeamStar1">
                                <label for="collaborateTeamStar1" title="1 Star Rating">&#9733;</label>
                            </div>
                        </div>

                        <!-- Compare Div --->
                        <div class="col-md-4 d-flex align-items-center align-content-center justify-content-center">
                            <div class="star-rating disabled    myChange">
                                <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                <input type="radio" value="5" disabled name="collaborateTeamCompare"
                                    id="collaborateTeamCompareStar5">
                                <label for="collaborateTeamCompareStar5" title="5 Stars Rating">&#9733;</label>
                                <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                <input type="radio" value="4" disabled name="collaborateTeamCompare"
                                    id="collaborateTeamCompareStar4">
                                <label for="collaborateTeamCompareStar4" title="4 Stars Rating">&#9733;</label>
                                <!-- 3 Star ✬ ✬ ✬ -->
                                <input type="radio" value="3" disabled name="collaborateTeamCompare"
                                    id="collaborateTeamCompareStar3">
                                <label for="collaborateTeamCompareStar3" title="3 Stars Rating">&#9733;</label>
                                <!-- 2 Star ✬ ✬ -->
                                <input type="radio" value="2" disabled name="collaborateTeamCompare"
                                    id="collaborateTeamCompareStar2">
                                <label for="collaborateTeamCompareStar2" title="2 Stars Rating">&#9733;</label>
                                <!-- 1 Star ✬ -->
                                <input type="radio" value="1" disabled name="collaborateTeamCompare"
                                    id="collaborateTeamCompareStar1">
                                <label for="collaborateTeamCompareStar1" title="1 Star Rating">&#9733;</label>
                            </div>
                        </div>
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
    <!-- Script file to display loader  -->
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
    </script>

    <!-- Select 2 JS -->
    <script src="{{ asset('select2/select2.min.js') }}"></script>

    <!-- Global Variable -->
    <script type="text/javascript">
        var searchIconUrl = "{{ asset('img/icons/searchIconCompareOrganization.svg') }}"

        // Gloable Variable to Set redirectBackUrl on Rating
        var overAllRating = "{{ $data['overAllRating'] }}";
        var easyWork = "{{ $data['easyWorkRating'] ? $data['easyWorkRating'] : 0 }}";
        var dependableWork = "{{ $data['dependableWorkRating'] ? $data['dependableWorkRating'] : 0 }}";
        var communicateUnderPressure =
            "{{ $data['communicateUnderPressureRating'] ? $data['communicateUnderPressureRating'] : 0 }}";
        var meetDeadline = "{{ $data['meetDeadlineRating'] ? $data['meetDeadlineRating'] : 0 }}";
        var receivingFeedback = "{{ $data['receivingFeedbackRating'] ? $data['receivingFeedbackRating'] : 0 }}";
        var respectfullOther = "{{ $data['respectfullOtherRating'] ? $data['respectfullOtherRating'] : 0 }}";
        var assistOther = "{{ $data['assistOtherRating'] ? $data['assistOtherRating'] : 0 }}";
        var collaborateTeam = "{{ $data['collaborateTeamRating'] ? $data['collaborateTeamRating'] : 0 }}";

        // Url for 2nd -Compare div to Get the peer Details to Compare
        var routeName =
            "{{ Auth::check() ? route('user.peer.comparePeer', ['peerId' => ':id']) : route('peer.comparePeer', ['peerId' => ':id']) }}";

        // Url for 2nd -Compare div to Show the peer Details on Click
        var secondDivUrl =
            "{{ Auth::check() ? route('user.peer.show', ['id' => ':id']) : route('peer.show', ['id' => ':id']) }}";
    </script>

    <!-- Custom Script file -->
    <script type="text/javascript" src="{{ asset('js/user/peer/comparePeer.js') }}"></script>

@endsection
