<div class="row">
    @if ($userSavedsPeers['count'] == 'Saved Peer')
        <div class="col mb-2">
            <div class="card" style="height: 320px; align-items: center;">
                <div class="card-body" style="align-content: center;">
                    <span style="font-size:16px; color: #00000080;">No Peer Found!</span>
                </div>
            </div>
        </div>
    @endif


    @foreach ($userSavedsPeers['peerRatings'] as $peerId => $peerRating)
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
            <a class="text-decoration-none" href="{{ route('user.peer.show', ['id' => $peerRating['peer']->id]) }}">
                <!-- Create the Peer Card Using loop -->
                <div class="card" style="border-radius: 8px;">
                    <div class="card-body">
                        <!-- 1st Row -->
                        <div class="row" style="margin-bottom:28px;">
                            <div class="col d-flex">
                                <table>
                                    <tr>
                                        <td style="vertical-align: top;">
                                            <div style="margin-right: 14px;">
                                                @php
                                                    // Array of possible background colors
                                                    $backgroundColors = ['#FF47B5', '#FF8947', '#B6BC9E'];
                                                    // Select a random color
                                                    $randomColor = $backgroundColors[array_rand($backgroundColors)];
                                                @endphp
                                                <div class="savedPeerInitialsDivs"
                                                    style="background-color:{{ $randomColor }};">
                                                    <span style="">
                                                        {{ $peerRating['peer']->getPeerInitialsAttribute() }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="vertical-align: top;">
                                            <div style="align-content: center">
                                                <div class="peerFirstLastName"
                                                    title="{{ $peerRating['peer']->getPeerFullNameAttribute() }}">
                                                    {{ $peerRating['peer']->getPeerFullNameAttribute() }}
                                                </div>
                                                <div class="peerDesignation_OrgName"
                                                    title="{{ $peerRating['peer']->jobTitle }} at {{ $peerRating['peer']->organization->name }}">
                                                    {{ $peerRating['peer']->jobTitle }} at
                                                    {{ $peerRating['peer']->organization->name }}
                                                </div>
                                            </div>
                                        </td>
                                        <td style="vertical-align: baseline;">

                                            <div style="position: absolute; right: 10px">
                                                <form action="{{ route('user.profileSetting.unSavePeer') }}"
                                                    method="POST" id="savedPeerForm_{{ $peerId }}">
                                                    @csrf
                                                    <input type="hidden" name="savedPeerId"
                                                        id="savedPeerId_{{ $peerId }}"
                                                        value="{{ $peerId }}"
                                                        placeholder="Enter Peer id to save." readonly>
                                                    <!-- Peer is saved -->
                                                    <a href="#" class="unSavedPeer"
                                                        data-peer-id="{{ $peerId }}"
                                                        id="unSavedPeerId_{{ $peerId }}">
                                                        <img src="{{ asset('img/icons/blueSavedIcon.png') }}"
                                                            alt="Save Organization" style="height: 24px; width:24px;">
                                                    </a>
                                                </form>
                                            </div>

                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- 2nd Row  ===> Work with again -->
                        <div class="row align-items-center" style="margin-bottom:12px">
                            <!-- Left: Work with again Rating label -->
                            <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                <span style="font-size: 14px; font-weight:500; color: #58585D;">Work with again:</span>
                            </div>

                            <!-- Right: Rating value and %age -->
                            <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                <div class="d-flex align-items-center justify-content-end">
                                    <div
                                        style="background-color:{{ $peerRating['workAgainYesPercentage'] >= 50 ? '#11951E' : '#F94747' }}; border-radius:3px; height: 16px; width: 16px; margin-right:3px">
                                    </div>
                                    <span
                                        style="color: #58585D; font-size:14px; font-weight:500">{{ $peerRating['workAgainYesPercentage'] }}%
                                        Yes</span>
                                </div>
                            </div>
                        </div>

                        <!-- 3rd Row ==> Overall Rating -->
                        <div class="row align-items-center" style="margin-bottom:12px">
                            <!-- Left: Overall Rating label -->
                            <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                <span style="font-size: 14px; font-weight:500; color: #58585D;">Overall Rating:</span>
                            </div>

                            <!-- Right: Rating value and stars -->
                            <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                <div class="star-rating disabled" style="display: flex; align-items: center;">
                                    <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                    <input type="radio" name="overAllRating_savedPeer_{{ $peerId }}" disabled
                                        id="overAllRatingStar5_savedPeer_{{ $peerId }}" value="5"
                                        @if ($peerRating['overAllRating'] > '4.9') checked @endif>
                                    <label for="overAllRatingStar5_savedPeer_{{ $peerId }}"
                                        title="5 Stars Rating">&#9733;</label>

                                    <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                    <input type="radio"
                                        name="overAllRatingoverAllRating_savedPeer_{{ $peerId }}" disabled
                                        id="overAllRatingStar4_savedPeer_{{ $peerId }}" value="4"
                                        @if ($peerRating['overAllRating'] > 3.9 && $peerRating['overAllRating'] < 5.0) checked @endif>
                                    <label for="overAllRatingStar4_savedPeer_{{ $peerId }}"
                                        title="4 Stars Rating">&#9733;</label>

                                    <!-- 3 Star ✬ ✬ ✬ -->
                                    <input type="radio" name="overAllRating_savedPeer_{{ $peerId }}" disabled
                                        id="overAllRatingStar3_savedPeer_{{ $peerId }}" value="3"
                                        @if ($peerRating['overAllRating'] > 2.9 && $peerRating['overAllRating'] < 4.0) checked @endif>
                                    <label for="overAllRatingStar3_savedPeer_{{ $peerId }}"
                                        title="3 Stars Rating">&#9733;</label>

                                    <!-- 2 Star ✬ ✬ -->
                                    <input type="radio" name="overAllRating_savedPeer_{{ $peerId }}" disabled
                                        id="overAllRatingStar2_savedPeer_{{ $peerId }}" value="2"
                                        @if ($peerRating['overAllRating'] > 1.9 && $peerRating['overAllRating'] < 3.0) checked @endif>
                                    <label for="overAllRatingStar2_savedPeer_{{ $peerId }}"
                                        title="2 Stars Rating">&#9733;</label>

                                    <!-- 1 Star ✬ -->
                                    <input type="radio" name="overAllRating_savedPeer_{{ $peerId }}" disabled
                                        id="overAllRatingStar1_savedPeer_{{ $peerId }}" value="1"
                                        @if ($peerRating['overAllRating'] >= 1.0 && $peerRating['overAllRating'] < 2.0) checked @endif>
                                    <label for="overAllRatingStar1_savedPeer_{{ $peerId }}"
                                        title="1 Star Rating">&#9733;</label>

                                    <!-- Overall Rating -->
                                    <span
                                        style="font-size: 24px;font-weight:500;color: #000000; padding-right:5px;">{{ $peerRating['overAllRating'] }}</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- \...........Create the Card Using loop Ends -->
            </a>
        </div>
    @endforeach
</div>
<div class="row">
    <div class="col-12 d-flex justify-content-end" id="savedsPeerPagination">
        @if ($userSavedsPeers['paginatedRatings'] && $userSavedsPeers['paginatedRatings']->count())
            {{ $userSavedsPeers['paginatedRatings']->appends(['searchSavedPeer' => request('searchSavedPeer')])->links('user.pagination.customPagination') }}
        @endif
    </div>
</div>

<!-- /.......... Saved Peer content goes here -->
