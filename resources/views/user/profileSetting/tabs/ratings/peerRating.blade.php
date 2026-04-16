<!-- My Rating-Peer content goes here -->
<!-- 1st Heading Row -->
<div class="row" style="margin-bottom: 20px;">
    <div class="col">
        <span class="cardHeading" id="myPeerRatingCount">
            {{ $dataPeerRated['count'] }}
        </span>
    </div>
</div>


@if ($dataPeerRated['count'] == 'Peer Rating')
    <div class="col mb-2">
        <div class="card" style="height: 320px; align-items: center;">
            <div class="card-body" style="align-content: center;">
                <span style="font-size:16px; color: #00000080;">No Peer Found!</span>
            </div>
        </div>
    </div>
@endif


@foreach ($dataPeerRated['peers'] as $peerRatingId => $peerRating)
    <!-- My Rating-Peer Here -->
    <div class="form-group row">
        <div class="col-lg-3 col-md-4 col-sm-6 d-flex flex-wrap">
            <div class="d-flex">
                <!-- Peer Initial Here -->
                @php
                    // Array of possible background colors
                    $backgroundColors = ['#B6BC9E', '#FF47B5', '#FF8947'];
                    // Select a random color
                    $randomColor = $backgroundColors[array_rand($backgroundColors)];
                @endphp
                <div style="height: 64px; width: 64px; margin-right:20px;">
                    <div
                        style="height: 64px; width: 64px;border-radius: 50%; background-color: {{ $randomColor }};
                               display: flex; align-items: center; justify-content: center; box-shadow: 0px 0px 4px 0px #00000040;">
                        <span style="font-size:18px; font-weight:600; color:#FFFFFF">
                            {{ $peerRating['peer']->getPeerInitialsAttribute() }}
                        </span>
                    </div>

                </div>

                <a class="text-decoration-none" href="{{ route('user.peer.show', ['id' => $peerRating['peer']->id]) }}">
                    <!-- Peer Info -->
                    <div class="peer-info">
                        <div class="d-flex">
                            <div class="peerName" title="{{ $peerRating['peer']->getPeerFullNameAttribute() }}">
                                {{ $peerRating['peer']->getPeerFullNameAttribute() }}
                            </div>
                        </div>
                        <div class="peerAddress"
                            title="{{ $peerRating['peer']->jobTitle }} at {{ $peerRating['peerRating']->organization->name }}">
                            {{ $peerRating['peer']->jobTitle }} at {{ $peerRating['peerRating']->organization->name }}
                        </div>
                        <div>
                            <label class="" for="overAllRatingStar_Peer" title="Over all Rating"
                                style="font-weight: 700; font-size: 28px; color: #F9C154;">&#9733;</label>
                            <span
                                style="color: #161617; font-size:32px; font-weight:500">{{ $peerRating['overAllRating'] }}</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>


        <div class="col-lg-9 col-md-8 col-sm-6">
            <!--- Creation Date -->
            <div class="row">
                <div class="col">
                    <span style="font-size: 16px; font-weight:500; color: #161617;">
                        {{ \Carbon\Carbon::parse($peerRating['peerRating']->createdAt)->format('F j, Y') }}
                    </span>
                </div>
            </div>

            <!-- Experience -->
            <div class="row" style="margin-bottom: 16px">
                <div class="col">
                    <span style="font-size: 16px; font-weight:500; color: #58585D;">
                        {{ $peerRating['peerRating']->experience }}
                    </span>
                </div>

            </div>

            <!-- Rating Stars -->
            <!-- Easy Work - Work Again Row -->
            <div class="row align-items-center" style="margin-bottom: 16px;">
                <!-- Easy Work -->
                <div class="col-xl-4 col-lg-9 col-md-6 col-sm-6 col-6">
                    <span class="text-justify myRatingOrganizationLabel">
                        How easy was it to work with this peer?
                    </span>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6 star-rating-org disabled">
                    @php
                        $easyWorkRating = (int) $peerRating['peerRating']['easyWork'];
                    @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="star user-star-rating-org {{ $easyWorkRating >= $i ? 'filled' : '' }}"
                            title="{{ $i }} Stars">&#9733;</span>
                    @endfor
                </div>

                <!-- Work Again -->
                <div class="col-xl-4 col-lg-9 col-md-6 col-sm-6 col-6">
                    <span class="text-justify myRatingOrganizationLabel">
                        Would you want to work with this peer again?
                    </span>
                </div>

                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6 d-flex justify-content-end">
                    <div class="d-flex align-items-center">
                        <div
                            style="background-color: {{ $peerRating['peerRating']->workAgain == 1 ? '#11951E' : '#F94747' }}; border-radius: 3px; height: 26px; width: 26px; margin-right: 6px;">
                        </div>
                        <span style="color: #58585D; font-size: 16px; font-weight: 500;">
                            {{ $peerRating['peerRating']->workAgain == 1 ? 'Yes' : 'No' }}
                        </span>
                    </div>
                </div>
            </div>


            <!-- Dependable Work  -  Communicate Under Pressure  Row -->
            <div class="row align-items-center" style="margin-bottom: 16px;">
                <!-- Dependable Work -->
                <div class="col-xl-4 col-lg-9 col-md-6 col-sm-6 col-6">
                    <span class="text-justify myRatingOrganizationLabel">
                        How dependable is this peer in their work habits?
                    </span>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6 star-rating-org disabled">
                    @php
                        $dependableWorkRating = (int) $peerRating['peerRating']['dependableWork'];
                    @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="star user-star-rating-org {{ $dependableWorkRating >= $i ? 'filled' : '' }}"
                            title="{{ $i }} Stars">&#9733;</span>
                    @endfor
                </div>

                <!-- Communicate Under Pressure -->
                <div class="col-xl-4 col-lg-9 col-md-6 col-sm-6 col-6">
                    <span class="text-justify myRatingOrganizationLabel">
                        How well does this peer communicate when under pressure?
                    </span>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6 star-rating-org disabled">
                    @php
                        $communicateUnderPressureRating = (int) $peerRating['peerRating']['communicateUnderPressure'];
                    @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        <span
                            class="star user-star-rating-org {{ $communicateUnderPressureRating >= $i ? 'filled' : '' }}"
                            title="{{ $i }} Stars">&#9733;</span>
                    @endfor
                </div>
            </div>


            <!-- Meet Deadline - Receiving Feedback Row -->
            <div class="row align-items-center" style="margin-bottom: 16px;">
                <!-- Meet Deadline -->
                <div class="col-xl-4 col-lg-9 col-md-6 col-sm-6 col-6">
                    <span class="text-justify myRatingOrganizationLabel">
                        How does often this peer meet deadlines?
                    </span>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6 star-rating-org disabled">
                    @php
                        $meetDeadlineRating = (int) $peerRating['peerRating']['meetDeadline'];
                    @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="star user-star-rating-org {{ $meetDeadlineRating >= $i ? 'filled' : '' }}"
                            title="{{ $i }} Stars">&#9733;</span>
                    @endfor
                </div>

                <!-- Receiving Feedback -->
                <div class="col-xl-4 col-lg-9 col-md-6 col-sm-6 col-6">
                    <span class="text-justify myRatingOrganizationLabel">
                        How open is this peer to receiving feedback?
                    </span>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6 star-rating-org disabled">
                    @php
                        $receivingFeedbackRating = (int) $peerRating['peerRating']['receivingFeedback'];
                    @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="star user-star-rating-org {{ $receivingFeedbackRating >= $i ? 'filled' : '' }}"
                            title="{{ $i }} Stars">&#9733;</span>
                    @endfor
                </div>
            </div>


            <!-- Respectfull Other - Assist Other Row -->
            <div class="row align-items-center" style="margin-bottom: 16px;">
                <!-- Respectful to Others -->
                <div class="col-xl-4 col-lg-9 col-md-6 col-sm-6 col-6">
                    <span class="text-justify myRatingOrganizationLabel">
                        How respectful is this peer towards others?
                    </span>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6 star-rating-org disabled">
                    @php
                        $respectfulOtherRating = (int) $peerRating['peerRating']['respectfullOther'];
                    @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="star user-star-rating-org {{ $respectfulOtherRating >= $i ? 'filled' : '' }}"
                            title="{{ $i }} Stars">&#9733;</span>
                    @endfor
                </div>

                <!-- Assist Others -->
                <div class="col-xl-4 col-lg-9 col-md-6 col-sm-6 col-6">
                    <span class="text-justify myRatingOrganizationLabel">
                        How often does this peer assist others when needed?
                    </span>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6 star-rating-org disabled">
                    @php
                        $assistOtherRating = (int) $peerRating['peerRating']['assistOther'];
                    @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="star user-star-rating-org {{ $assistOtherRating >= $i ? 'filled' : '' }}"
                            title="{{ $i }} Stars">&#9733;</span>
                    @endfor
                </div>
            </div>


            <!-- Collaborate Team   Row -->
            <div class="row align-items-center" style="margin-bottom: 16px;">
                <!-- Collaborate Team -->
                <div class="col-xl-4 col-lg-9 col-md-6 col-sm-6 col-6">
                    <span class="text-justify myRatingOrganizationLabel">How well does this peer collaborate with the
                        team?</span>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6 star-rating-org disabled">
                    @php
                        $collaborateTeamRating = (int) $peerRating['peerRating']['collaborateTeam'];
                    @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="star user-star-rating-org {{ $collaborateTeamRating >= $i ? 'filled' : '' }}"
                            title="{{ $i }} Stars">&#9733;</span>
                    @endfor
                </div>
            </div>

            <!-- Edit Button -->
            <div class="row align-items-center">
                <div class="col">
                    <a href="{{ route('user.peer.ratePeerForm', ['peerId' => $peerRating['peer']->id, 'edit' => 1, 'ratingId' => $peerRating['peerRating']->id]) }}"
                        class="btn btn-primary btnHeight editRating btnStyles" id="btnEditMyPeerRating">
                        Edit
                    </a>
                </div>
            </div>

        </div>
    </div>

    <hr style="margin-top:32px; margin-bottom:32px">
    <!-- /...... My Rating-Organization Ends -->
@endforeach


<div class="row">
    <div class="col-12 d-flex justify-content-end" id="myPeerRating">
        @if ($dataPeerRated['paginatedRatings'] && $dataPeerRated['paginatedRatings']->count())
            {{ $dataPeerRated['paginatedRatings']->appends(['searchMyOrganizationRating' => request('searchMyOrganizationRating')])->links('user.pagination.customPagination') }}
        @endif
    </div>
</div>
