<div class="row">
  
    @if ($peerCount === '0 Peer')
        <div class="col mb-2">
            <div class="card" style="height: 320px; align-items: center;">
                <div class="card-body" style="align-content: center;">
                    <span style="font-size:16px; color: #00000080;">No Peer Found!</span>
                </div>
            </div>
        </div>
    @endif


    @foreach ($peerList as $peerId => $peer)
        <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
            <a class="text-decoration-none"
                href="{{ auth()->check() ? route('user.peer.show', ['id' => $peerId]) : route('peer.show', ['id' => $peerId]) }}">
                <!-- Create the Peer Card Using loop -->
                <div class="card" style="border-radius: 8px">
                    <div class="card-body">
                        <!-- 1st Row -->
                        <div class="row" style="margin-bottom:16px;">
                            <div class="col d-flex">
                                <table>
                                    <tr>
                                        <td style="vertical-align: top;">
                                            <div style="margin-right: 14px;">
                                                @php
                                                    // Array of possible background colors
                                                    $backgroundColors = ['#B6BC9E', '#FF47B5', '#FF8947'];
                                                    // Select a random color
                                                    $randomColor = $backgroundColors[array_rand($backgroundColors)];
                                                @endphp
                                                <div class="initialsInsideDiv" style="background-color: {{ $randomColor }}; width: 64px; height: 64px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                    <label style="color: #fff; font-size: 18px; font-weight: bold;">{{ $peer['peerData']['peerInitials'] }}</label>
                                                </div>
                                            </div>
                                        </td>

                                        <td style="vertical-align: top;">
                                            <div style="align-content: center">
                                                <div class="peerFirstLastName"
                                                    title="{{ $peer['peerData']['peerFullName'] }}">
                                                    {{ $peer['peerData']['peerFullName'] }}
                                                </div>
                                                <div class="peerDesignation_OrgName"
                                                    title="{{ $peer['peerData']['jobTitle'] }} at {{ $peer['peerData']['organizationName'] }}">
                                                    {{ $peer['peerData']['jobTitle'] }} at
                                                    {{ $peer['peerData']['organizationName'] }}
                                                </div>
                                            </div>
                                        </td>
                                        <td style="vertical-align: baseline;">
                                            <div style="position: absolute; right: 10px">
                                                <form action="{{ route('user.peer.savedPeer') }}" method="POST"
                                                    id="savedPeerForm_{{ $peerId }}">
                                                    @csrf
                                                    <input type="hidden" name="savedPeerId" readonly
                                                        value="{{ $peerId }}"
                                                        id="peerSavedId_{{ $peerId }}"
                                                        placeholder="Enter Peer id to save.">
                                                    <!-- Peer is saved -->
                                                    <a href="#" class="unSavedPeer"
                                                        data-peer-id="{{ $peerId }}"
                                                        id="unSavedPeerId_{{ $peerId }}"
                                                        style="display: {{ $peer['saved'] == true ? 'block' : 'none' }};">
                                                        <img src="{{ asset('img/icons/blueSavedIcon.png') }}"
                                                            alt="Save" class="save">
                                                    </a>
                                                    <!-- Peer is not saved -->
                                                    <a href="#" class="savedPeer"
                                                        data-peer-id="{{ $peerId }}"
                                                        id="savedPeerId_{{ $peerId }}"
                                                        style="display: {{ $peer['saved'] == false ? 'block' : 'none' }};">
                                                        <img src="{{ asset('img/icons/saveIcon.png') }}" alt="Un-Save"
                                                            class="unSave">
                                                    </a>

                                                </form>
                                            </div>

                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>


                        <!-- 2nd Row  ===> Work with again -->
                        <div class="row align-items-center justify-content-between pt-3 pl-3 pr-3 pb-0">
                            <!-- Left: Work with again Rating label -->
                            <label class="workAgainLabel">Work with again:</label>

                            @if (
                                ($peer['workAgainYesPercentage'] > $peer['workAgainNoPercentage'] ||
                                    $peer['workAgainYesPercentage'] >= $peer['workAgainNoPercentage']) &&
                                    !($peer['workAgainYesPercentage'] == 0 && $peer['workAgainNoPercentage'] == 0))
                                <div class="d-flex align-items-center">
                                    <div class="workAgainInsideDiv" style="background-color: #11951E;">
                                    </div>
                                    <label class="workAgainValue">
                                        {{ $peer['workAgainYesPercentage'] }}% Yes
                                    </label>
                                </div>
                            @elseif ($peer['workAgainNoPercentage'] > $peer['workAgainYesPercentage'])
                                <div class="d-flex align-items-center">
                                    <div class="workAgainInsideDiv" style="background-color: #F94747;">
                                    </div>
                                    <label class="workAgainValue">
                                        {{ $peer['workAgainNoPercentage'] }}% No
                                    </label>
                                </div>
                            @elseif ($peer['workAgainYesPercentage'] == 0 && $peer['workAgainNoPercentage'] == 0)
                                <div class="d-flex align-items-center">
                                    <div class="workAgainInsideDiv" style="background-color: #11951E;">
                                    </div>
                                    <label class="workAgainValue">
                                        0% Yes/No
                                    </label>
                                </div>
                            @endif


                        </div>

                        <!-- 3rd Row ==> Overall Rating -->

                        <div class="row align-items-center justify-content-between pt-0 pl-3 pr-3 pb-0">
                            <!-- Left: Overall Rating label -->
                            <label class="overAllRating">Overall Rating:</label>

                            <!-- Right: Rating value and stars -->
                            <div class="d-flex align-items-center">
                                <!-- Overall Rating Value -->
                                <span class="overAllRatingValue" style="margin-left: 8px;">
                                    {{ $peer['overAllRating'] }}
                                </span>
                                <div class="star-rating disabled" style="display: flex; align-items: center;">
                                    <!-- 5 Star -->
                                    <input type="radio" name="overAllRating_savedPeer_{{ $peerId }}" disabled
                                        id="overAllRatingStar5_savedPeer_{{ $peerId }}" value="5"
                                        @if ($peer['overAllRating'] > 4.9) checked @endif>
                                    <label for="overAllRatingStar5_savedPeer_{{ $peerId }}"
                                        title="5 Stars Rating">&#9733;</label>

                                    <!-- 4 Star -->
                                    <input type="radio" name="overAllRating_savedPeer_{{ $peerId }}" disabled
                                        id="overAllRatingStar4_savedPeer_{{ $peerId }}" value="4"
                                        @if ($peer['overAllRating'] > 3.9 && $peer['overAllRating'] < 5.0) checked @endif>
                                    <label for="overAllRatingStar4_savedPeer_{{ $peerId }}"
                                        title="4 Stars Rating">&#9733;</label>

                                    <!-- 3 Star -->
                                    <input type="radio" name="overAllRating_savedPeer_{{ $peerId }}" disabled
                                        id="overAllRatingStar3_savedPeer_{{ $peerId }}" value="3"
                                        @if ($peer['overAllRating'] > 2.9 && $peer['overAllRating'] < 4.0) checked @endif>
                                    <label for="overAllRatingStar3_savedPeer_{{ $peerId }}"
                                        title="3 Stars Rating">&#9733;</label>

                                    <!-- 2 Star -->
                                    <input type="radio" name="overAllRating_savedPeer_{{ $peerId }}" disabled
                                        id="overAllRatingStar2_savedPeer_{{ $peerId }}" value="2"
                                        @if ($peer['overAllRating'] > 1.9 && $peer['overAllRating'] < 3.0) checked @endif>
                                    <label for="overAllRatingStar2_savedPeer_{{ $peerId }}"
                                        title="2 Stars Rating">&#9733;</label>

                                    <!-- 1 Star -->
                                    <input type="radio" name="overAllRating_savedPeer_{{ $peerId }}" disabled
                                        id="overAllRatingStar1_savedPeer_{{ $peerId }}" value="1"
                                        @if ($peer['overAllRating'] >= 1.0 && $peer['overAllRating'] < 2.0) checked @endif>
                                    <label for="overAllRatingStar1_savedPeer_{{ $peerId }}"
                                        title="1 Star Rating">&#9733;</label>
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
    <div class="col-12 d-flex justify-content-end" id="peerPagination">
        @if ($paginatedRatings && $paginatedRatings->count())
            {{ $paginatedRatings->appends(['searchPeer' => request('searchPeer')])->links('user.pagination.customPagination') }}
        @endif
    </div>
</div>
