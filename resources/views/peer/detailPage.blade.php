@extends('common.layouts.master')
@section('title', 'Peer - Details')
@section('headerHeading') Peer Details @endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('css/peer/detailPage.css') }}">
    <!-- Custom CSS file -->
    <link rel="stylesheet" href="{{ asset('css/user/customBorder.css') }}">
@endsection
@section('content')
    <!-- /.content-wrapper -->
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card mt-3 customParentCardStyle">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <!-- Left Section with Avatar, Name, Role, and Rating -->
                                <div class="col-lg-4 col-md-12 col-sm-12 d-flex align-items-start mb-3 mb-md-0">
                                    <!-- Avatar with initials -->
                                    <!-- Random Background color for Anonymous -->
                                    @php
                                        // Array of possible background colors
                                        $backgroundColors = ['#B6BC9E', '#F4BC81', '#81BDC3'];
                                        // Select a random color
                                        $randomColor = $backgroundColors[array_rand($backgroundColors)];
                                    @endphp

                                    <div>
                                        <!-- Initials Shown here -->
                                        <div class="initialsInsideDivs" style="background-color:{{ $randomColor }};">
                                            <label>{{ $peer->getPeerInitialsAttribute() }}</label>
                                        </div>
                                    </div>
                                    <div class="pl-3">
                                        <!-- Name and position -->
                                        <strong class="title" title="{{ $peer->getPeerFullNameAttribute() }}">
                                            {{ $peer->getPeerFullNameAttribute() }}
                                        </strong><br>
                                        <small class="peer-designation"
                                            title="{{ $peer->jobTitle }} at {{ $peer->organization }}">
                                            {{ $peer->jobTitle }} at {{ $peer->organization }}
                                        </small>
                                        <!-- Rating Section -->
                                        <div class="d-flex align-items-center mt-2">

                                            <h4 class="mb-0 ratings-point">{{ number_format($formattedOverAllRating, 1) }}
                                            </h4>
                                            <div class="pl-2">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <span
                                                        class="star peers-stars {{ $formattedOverAllRating >= $i ? 'filled' : '' }}"
                                                        title="{{ $i }} Stars">&#9733;</span>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Middle Section with Work with Again Percentage -->
                                <div class="col-lg-4 col-md-12 col-sm-12 d-flex align-items-center justify-content-lg-center justify-content-md-end mb-3">

                                    <div class="d-flex align-items-center">
                                        <span class="work-again">Work with again:</span>

                                        @if (($yesPercentage > $noPercentage || $yesPercentage >= $noPercentage) && !($yesPercentage == 0 && $noPercentage == 0))
                                            <div
                                                style="width: 27px; height: 27px; background-color: #11951E; margin: 0 5px;  border-radius: 4px;">
                                            </div>
                                            <span class="work-agains">{{ number_format($yesPercentage) }}% Yes</span>
                                        @elseif ($noPercentage > $yesPercentage)
                                            <div
                                                style="width: 27px; height: 27px; background-color: #F94747; margin: 0 5px;  border-radius: 4px;">
                                            </div>
                                            <span class="work-agains">{{ number_format($noPercentage) }}% No</span>
                                        @elseif ($yesPercentage == 0 && $noPercentage == 0)
                                            <div
                                                style="width: 27px; height: 27px; background-color: #11951E; margin: 0 5px;  border-radius: 4px;">
                                            </div>
                                            <span class="work-agains">0% Yes/No</span>
                                        @endif
                                    </div>

                                </div>

                                <!-- Right Section with Action Buttons -->
                                <div
                                    class="col-lg-4 col-md-12 col-sm-12 d-flex align-items-center justify-content-end mb-3">
                                    <!-- Rate this Peer-->
                                    <a href="{{ auth()->check() ? route('user.peer.ratePeerForm', ['peerId' => $peer->id]) : route('peer.ratePeerForm', ['peerId' => $peer->id]) }}"
                                        class="btn btn-primary btnStyles mr-2">
                                        Rate
                                    </a>

                                    <!-- Compare this Peer -->
                                    <a href="{{ auth()->check() ? route('user.peer.comparePeerForm', ['peerId' => $peer->id]) : route('peer.comparePeerForm', ['peerId' => $peer->id]) }}"
                                        class="btn btn-outline-primary btnStyle mr-2">
                                        Compare
                                    </a>

                                    <!-- Save or Un-Saved peer -->
                                    <form action="{{ route('user.peer.savedPeer') }}" method="POST" id="savedPeerForm">
                                        @csrf
                                        <input type="hidden" name="savedPeerId" id="savedPeerId"
                                            value="{{ $peer->id }}" readonly>
                                        <!-- Peer is already saved -->
                                        <a href="#" class="unSavedPeer" id="unSavedPeer"
                                            style="display: {{ $isSavedPeer == true ? 'block' : 'none' }};">
                                            <img src="{{ asset('img/icons/blueSavedIcon.png') }}" alt="Save"
                                                style="height: 24px; width:24px;">
                                        </a>

                                        <!-- Peer is not saved -->
                                        <a href="#" class="savedPeer" id="savedPeer"
                                            style="display: {{ $isSavedPeer == false ? 'block' : 'none' }};">
                                            <img src="{{ asset('img/icons/saveIcon.png') }}" alt="Un-Save"
                                                style="height: 24px; width:24px;">
                                        </a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Content Header End (Page header) -->

        <!-- Content Body (Peer Rating) -->
        <div class="container-fluid content-user-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <div class="card customParentCardStyle">
                        <div class="card-body m-0 p-3">
                            <div class="row  p-2">
                                <div class="col-md-12">
                                    @if ($totalResponses == 0)
                                        <span class="rattings-title">Ratings:</span>
                                    @else
                                        <span class="rattings-title">{{ $totalResponses }} Ratings:</span>
                                    @endif
                                </div>

                            </div>

                            <div class="row mt-2 p-2" id="data-wrapper-final">
                                @include('peer.rating')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Content Body End (Peer Rating) -->
    </div>
    @include('common.layouts.compulsorySweetAlert')
@endsection
@php $hideFooter = true; @endphp
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Script to Show loader -->
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fingerprintjs/fingerprintjs@3/dist/fp.min.js"></script>

    <!-- Custom Script Files -->
    <script src="{{ asset('js/peer/peerDetail.js') }}"></script>

    <!-- Custom Script File to Save-UnSave the Peer -->
    <script type="text/javascript" src="{{ asset('js/user/peer/common/saveUnSavePeer.js') }}"></script>

    <!-- Custom Script files to Save, Un-Save the Record of thumbs-up and down (Create, Update & Delete the record) -->
    <script type="text/javascript" src="{{ asset('js/home/helpful/helpful.js') }}"></script>

    <!-- Global Variable -->
    <script type="text/javascript">
        var peerId = {{ $peer->id }};
        var ENDPOINT = "{{ route('peer.show', ['id' => ':id']) }}".replace(':id', peerId);
        var authlogin = "{{ Auth::check() ? 'true' : 'false' }}";
        var userLoggedIn = "{{ Auth::check() ? 'true' : 'false' }}";

        // Thumbs-Up Image Url
        var thumbsUpImageUrl = "{{ asset('img/overallRatingIcons/thumpsup.png') }}";
        // Green Thumbs-Up Image Url
        var greenThumbsUpImageUrl = "{{ asset('img/overallRatingIcons/thumpsupGreen.png') }}";
        // Thumbs-Down Image Url
        var thumbsDownImageUrl = "{{ asset('img/overallRatingIcons/thumbsdown.png') }}";
        // Red Thumbs-Down Image Url
        var redThumbsDownImageUrl = "{{ asset('img/overallRatingIcons/thumbsdownRed.png') }}";
    </script>
@endsection
