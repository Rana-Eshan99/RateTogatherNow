@foreach ($peerRating as $rating)
    <div class="col-xl-4 col-lg-4 col-md-5 col-12 p-2">
        <div class="row">
            <div class="col-12 d-flex align-items-top">

                <!-- Random Background color for Anonymous -->
                @php
                    // Array of possible background colors
                    $backgroundColors = ['#B6BC9E', '#81BDC3', '#F4BC81'];
                    // Select a random color
                    $randomColor = $backgroundColors[array_rand($backgroundColors)];
                @endphp

                <!-- Initials Shown here -->
                <div class="initialsInsideDivs" style="background-color:{{ $randomColor }};">
                    <label>AY</label>
                </div>
                <div class="organization-name pl-3">
                    <div class="d-flex align-items-center">
                        <h3 class="user-name mb-0 mr-2">Anonymous</h3>
                        @if ($rating->userId != null)
                            <img src="{{ asset('img/overallRatingIcons/verified.png') }}" height="24" width="24"
                                alt="verified">
                        @endif
                    </div>

                    @php
                        $totalScore =
                            $rating->assistOther +
                            $rating->collaborateTeam +
                            $rating->communicateUnderPressure +
                            $rating->dependableWork +
                            $rating->easyWork +
                            $rating->meetDeadline +
                            $rating->receivingFeedback +
                            $rating->respectfullOther;

                        $criteriaCount = 8; // Total number of criteria
                        $averageRating = $totalScore / $criteriaCount;
                    @endphp
                    <span class="star-filled  user-star">&#9733;</span> <span
                        class="user-rates">{{ number_format($averageRating, 1) }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-8 col-lg-8 col-md-7 col-12 p-2">
        <div class="row">
            <div class="col-12">
                <span style="font-weight: 500; font-size: 16px; color: rgba(22, 22, 23, 1);">
                    {{ \Carbon\Carbon::parse($rating->createdAt)->format('F j, Y') }}
                </span>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12" style="font-weight: 500; font-size: 16px; color: rgba(88, 88, 93, 1);">
                {{ $rating->experience }}
            </div>
        </div>
        <!-- Criteria Sections -->

        <div class="row mt-3">
            <div class="col-xl-6 col-md-12 col-12">
                <div class="d-flex align-items-center justify-content-between">
                    <p class="user-rating-title">How easy was it to work with this peer?</p>
                    <div class="star-rating d-flex align-items-center manage-spacing">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="star user-star-rating {{ $rating->easyWork >= $i ? 'filled' : '' }}"
                                title="{{ $i }} Stars">&#9733;</span>
                        @endfor
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-12 col-12">
                <div class="d-flex align-items-center justify-content-between">
                    <p class="user-rating-title"> Would you want to work with this peer again?</p>
                    <div class="star-rating d-flex align-items-center  mb-2" style="padding-right: 29px;">
                        @php
                            $color = $rating->workAgain == 1 ? '#11951E' : '#FF0000'; // Green for 1, Red for 0
                            $statusText = $rating->workAgain == 1 ? 'Yes' : 'No'; // Yes for 1, No for 0
                        @endphp
                        <div
                            style="width: 24px; height: 24px; background-color: {{ $color }};   border-radius: 3px;">
                        </div>
                        <span class="work-againss ml-2">{{ $statusText }}</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Continue similar blocks for other criteria -->
        <div class="row">
            <div class="col-xl-6 col-md-12 col-12">
                <div class="d-flex align-items-center justify-content-between">
                    <p class="user-rating-title">How dependable is this peer in their work habits?</p>
                    <div class="star-rating d-flex align-items-center manage-spacing">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="star user-star-rating {{ $rating->dependableWork >= $i ? 'filled' : '' }}"
                                title="{{ $i }} Stars">&#9733;</span>
                        @endfor
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-12 col-12">
                <div class="d-flex align-items-center justify-content-between">
                    <p class="user-rating-title"> How well does this peer communicate when under pressure?</p>
                    <div class="star-rating d-flex align-items-center manage-spacing">
                        @for ($i = 1; $i <= 5; $i++)
                            <span
                                class="star user-star-rating {{ $rating->communicateUnderPressure >= $i ? 'filled' : '' }}"
                                title="{{ $i }} Stars">&#9733;</span>
                        @endfor
                    </div>
                </div>
            </div>

        </div>
        <!-- Continue similar blocks for other criteria -->
        <div class="row">
            <div class="col-xl-6 col-md-12 col-12">
                <div class="d-flex align-items-center justify-content-between">
                    <p class="user-rating-title">How often does this peer meet deadlines?</p>
                    <div class="star-rating d-flex align-items-center manage-spacing">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="star user-star-rating {{ $rating->meetDeadline >= $i ? 'filled' : '' }}"
                                title="{{ $i }} Stars">&#9733;</span>
                        @endfor
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-12 col-12">
                <div class="d-flex align-items-center justify-content-between">
                    <p class="user-rating-title">How open is this peer to receiving feedback?</p>
                    <div class="star-rating d-flex align-items-center manage-spacing">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="star user-star-rating {{ $rating->receivingFeedback >= $i ? 'filled' : '' }}"
                                title="{{ $i }} Stars">&#9733;</span>
                        @endfor
                    </div>
                </div>
            </div>

        </div>
        <!-- Continue similar blocks for other criteria -->
        <div class="row">
            <div class="col-xl-6 col-md-12 col-12">
                <div class="d-flex align-items-center justify-content-between">
                    <p class="user-rating-title">How respectful is this peer towards others?</p>
                    <div class="star-rating d-flex align-items-center manage-spacing">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="star user-star-rating {{ $rating->respectfullOther >= $i ? 'filled' : '' }}"
                                title="{{ $i }} Stars">&#9733;</span>
                        @endfor
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-12 col-12">
                <div class="d-flex align-items-center justify-content-between">
                    <p class="user-rating-title">How often does this peer assist others when needed?</p>
                    <div class="star-rating d-flex align-items-center manage-spacing">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="star user-star-rating {{ $rating->assistOther >= $i ? 'filled' : '' }}"
                                title="{{ $i }} Stars">&#9733;</span>
                        @endfor
                    </div>
                </div>
            </div>

        </div>
        <!-- Continue similar blocks for other criteria -->
        <div class="row">
            <div class="col-xl-6 col-md-12 col-12">
                <div class="d-flex align-items-center justify-content-between">
                    <p class="user-rating-title">How well does this peer collaborate with the team?</p>
                    <div class="star-rating d-flex align-items-center manage-spacing">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="star user-star-rating {{ $rating->collaborateTeam >= $i ? 'filled' : '' }}"
                                title="{{ $i }} Stars">&#9733;</span>
                        @endfor
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-12 col-12">
                <div class="d-flex align-items-center justify-content-between">

                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-12 d-flex justify-content-between">
                <div class="d-flex align-items-center">
                    <span style="font-weight: 500; font-size: 16px; color: #58585D; margin-right: 20px;">Helpful</span>
                    <form action="{{ route('user.peer.helpful.saveHelpfulPeer') }}" class="helpful" method="POST"
                        id="helpfulForm_{{ $rating->id }}">
                        @csrf
                        <input type="hidden" name="visitorId" id="visitorId" data-id="{{ $rating->id }}" />
                        <input type="hidden" name="helpfulPeerRatingId" id="helpfulPeerRatingId_{{ $rating->id }}"
                            value="{{ $rating->id }}" readonly>

                        <div class="d-flex align-items-center">
                            <!-- Thumbs Up Section -->
                            <a href="#" class="thumbs-up d-flex align-items-center"
                                data-id="{{ $rating->id }}" style="text-decoration: none;"
                                onclick="return false;">
                                @if (is_null($rating->helpfulStatus) || $rating->helpfulStatus == 0)
                                    <!-- Default Thumbs Up -->
                                    <img src="{{ asset('img/overallRatingIcons/thumpsup.png') }}" alt="thumbs-up"
                                        class="me-2" id="thumbsUp_{{ $rating->id }}">
                                @elseif ($rating->helpfulStatus == 1)
                                    <!-- Green Thumbs Up -->
                                    <img src="{{ asset('img/overallRatingIcons/thumpsupGreen.png') }}"
                                        alt="green-thumbs-up" class="me-2" id="thumbsUp_{{ $rating->id }}">
                                @endif
                            </a>
                            <span id="thumbsUpCount_{{ $rating->id }}" class="ms-1"
                                style="margin-top: 4px; font-size: 18px; color: #58585D; margin-left: 7px; margin-right: 15px;">
                                {{ $rating->helpfulCount ?? 0 }}
                            </span>

                            <!-- Thumbs Down Section -->
                            <a href="#" class="thumbs-down d-flex align-items-center"
                                data-id="{{ $rating->id }}" style="text-decoration: none;"
                                onclick="return false;">
                                @if (is_null($rating->helpfulStatus) || $rating->helpfulStatus == 1)
                                    <!-- Default Thumbs Down -->
                                    <img src="{{ asset('img/overallRatingIcons/thumbsdown.png') }}" alt="thumbs-down"
                                        class="me-2" id="thumbsDown_{{ $rating->id }}">
                                @elseif ($rating->helpfulStatus == 0)
                                    <!-- Red Thumbs Down -->
                                    <img src="{{ asset('img/overallRatingIcons/thumbsdownRed.png') }}"
                                        alt="red-thumbs-down" class="me-2" id="thumbsDown_{{ $rating->id }}">
                                @endif
                            </a>
                            <span id="thumbsDownCount_{{ $rating->id }}" class="ms-1"
                                style="margin-top: 5px; font-size: 18px; color: #58585D; margin-left: 7px;">
                                {{ $rating->notHelpfulCount ?? 0 }}
                            </span>
                        </div>
                    </form>

                </div>
                <div class="d-flex align-items-center">
                    <a href="{{ route('user.peer.peerReportRatingForm', ['organization_peerRatingId' => $rating->id]) }}"
                        class="btnAddFeedback">
                        @if ($rating->report == true)
                            <img src="{{ asset('img/overallRatingIcons/feedbackOrange.png') }}" alt="feedback"
                                height="24" width="24">
                        @else
                            <img src="{{ asset('img/overallRatingIcons/feedback.png') }}" alt="feedback"
                                height="24" width="24">
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <hr>
    </div>
@endforeach
<!-- Pagination Links -->
<div class="col-12 d-flex justify-content-end">
    @if ($peerRating && $peerRating->count())
        {{ $peerRating->links('user.pagination.customPagination') }}
    @endif
</div>
<!-- /............. Pagination Links -->
