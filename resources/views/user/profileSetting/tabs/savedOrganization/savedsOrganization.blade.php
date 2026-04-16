<div class="row">
    @if ($userSavedsOrganizations['count'] == 'Saved Organization')
        <div class="col mb-2">
            <div class="card" style="height: 320px; align-items: center;">
                <div class="card-body" style="align-content: center;">
                    <span style="font-size:16px; color: #00000080;">No Organization Found!</span>
                </div>
            </div>
        </div>
    @endif


    @foreach ($userSavedsOrganizations['organizationRatings'] as $organizationId => $orgRating)
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
            <a class="text-decoration-none"
                href="{{ route('user.organization.show', ['id' => $orgRating['organization']->id]) }}">
                <!-- Create the Organization Card Using loop -->
                <div class="card" style="border-radius: 8px;">
                    <div class="card-body pl-3 pr-3">
                        <!-- 1st Row -->
                        <div class="row" style="margin-bottom:28px;">
                            <div class="col d-flex">
                                <table>
                                    <tr>
                                        <td style="vertical-align: top;">
                                            <div style="margin-right: 14px;">
                                                <img src="{{ $orgRating['organization']->getImageFullUrlAttribute() }}"
                                                    alt="Logo" class="organizationLogo"
                                                    onerror="this.onerror=null;this.src='{{ asset('img/organizationDefaultAvatar.png') }}';">
                                            </div>
                                        </td>
                                        <td style="vertical-align: top;">
                                            <div style="align-content: center">
                                                <div class="organizationNameSaved"
                                                    title="{{ $orgRating['organization']->name }}">
                                                    {{ $orgRating['organization']->name }}
                                                </div>
                                                <div class="organizationAddressSaved"
                                                    title="{{ $orgRating['organization']->address }}">
                                                    {{ $orgRating['organization']->address }}
                                                </div>
                                            </div>
                                        </td>
                                        <td style="vertical-align: baseline;">

                                            <div style="position: absolute; right: 10px">
                                                <form action="{{ route('user.profileSetting.unSaveOrganization') }}"
                                                    method="POST" id="savedOrganizationForm_{{ $organizationId }}">
                                                    @csrf
                                                    <input type="hidden" name="savedOrganizationId"
                                                        id="organizationIdSaved_{{ $organizationId }}"
                                                        value="{{ $organizationId }}"
                                                        placeholder="Enter Organization id to save." readonly>
                                                    <!-- Organization is saved -->
                                                    <a href="#" class="unSavedOrganization"
                                                        data-organization-id="{{ $organizationId }}"
                                                        id="unSavedOrganization_{{ $organizationId }}">
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


                        <!-- 2nd Row ==> Overall Rating -->
                        <div class="row align-items-center" style="margin-bottom:12px">
                            <!-- Left: Overall Rating label -->
                            <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                <span style="font-size: 14px; font-weight:500; color: #58585D;">Overall Rating:</span>
                            </div>

                            <!-- Right: Rating value and stars -->
                            <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                <div class="star-rating disabled" style="display: flex; align-items: center;">
                                    <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                    <input type="radio" name="overAllRating{{ $orgRating['organization']->id }}"
                                        id="overAllRatingStar5_{{ $orgRating['organization']->id }}" disabled
                                        value="5" @if ($orgRating['overAllRating'] > '4.9') checked @endif>
                                    <label for="overAllRatingStar5_{{ $orgRating['organization']->id }}"
                                        title="5 Stars Rating">&#9733;</label>

                                    <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                    <input type="radio" name="overAllRating{{ $orgRating['organization']->id }}"
                                        disabled id="overAllRatingStar4_{{ $orgRating['organization']->id }}"
                                        value="4" @if ($orgRating['overAllRating'] > 3.9 && $orgRating['overAllRating'] < 5.0) checked @endif>
                                    <label for="overAllRatingStar4_{{ $orgRating['organization']->id }}"
                                        title="4 Stars Rating">&#9733;</label>

                                    <!-- 3 Star ✬ ✬ ✬ -->
                                    <input type="radio" name="overAllRating{{ $orgRating['organization']->id }}"
                                        disabled id="overAllRatingStar3_{{ $orgRating['organization']->id }}"
                                        value="3" @if ($orgRating['overAllRating'] > 2.9 && $orgRating['overAllRating'] < 4.0) checked @endif>
                                    <label for="overAllRatingStar3_{{ $orgRating['organization']->id }}"
                                        title="3 Stars Rating">&#9733;</label>

                                    <!-- 2 Star ✬ ✬ -->
                                    <input type="radio" name="overAllRating{{ $orgRating['organization']->id }}"
                                        disabled id="overAllRatingStar2_{{ $orgRating['organization']->id }}"
                                        value="2" @if ($orgRating['overAllRating'] > 1.9 && $orgRating['overAllRating'] < 3.0) checked @endif>
                                    <label for="overAllRatingStar2_{{ $orgRating['organization']->id }}"
                                        title="2 Stars Rating">&#9733;</label>

                                    <!-- 1 Star ✬ -->
                                    <input type="radio" name="overAllRating{{ $orgRating['organization']->id }}"
                                        disabled id="overAllRatingStar1_{{ $orgRating['organization']->id }}"
                                        value="1" @if ($orgRating['overAllRating'] >= 1.0 && $orgRating['overAllRating'] < 2.0) checked @endif>
                                    <label for="overAllRatingStar1_{{ $orgRating['organization']->id }}"
                                        title="1 Star Rating">&#9733;</label>

                                    <!-- Overall Rating -->
                                    <span
                                        style="font-size: 24px;font-weight:500;color:#000000; padding-right:5px;">{{ $orgRating['overAllRating'] }}</span>
                                </div>
                            </div>
                        </div>


                        <!-- 3rd Row  ===> Employee Happiness -->
                        <div class="row align-items-center" style="margin-bottom:12px">
                            <!-- Left: Employee Happiness Rating label -->
                            <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                <span style="font-size: 14px; font-weight:500;color: #58585D;">Employee
                                    Happiness:</span>
                            </div>

                            <!-- Right: Rating value and stars -->
                            <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                <div class="star-rating disabled" style="display: flex; align-items: center;">

                                    <!-- 5 Star ✬ ✬ ✬ ✬ ✬ -->
                                    <input type="radio"
                                        name="overAllEmployeeHappinessRating{{ $orgRating['organization']->id }}"
                                        id="overAllEmployeeHappinessRatingStar5_{{ $orgRating['organization']->id }}"
                                        value="5" disabled @if ($orgRating['employeeHappynessRating'] > '4.9') checked @endif>
                                    <label
                                        for="overAllEmployeeHappinessRatingStar5_{{ $orgRating['organization']->id }}"
                                        title="5 Stars Rating">&#9733;</label>

                                    <!-- 4 Star ✬ ✬ ✬ ✬ -->
                                    <input type="radio"
                                        name="overAllEmployeeHappinessRating{{ $orgRating['organization']->id }}"
                                        id="overAllEmployeeHappinessRatingStar4_{{ $orgRating['organization']->id }}"
                                        value="4" disabled @if ($orgRating['employeeHappynessRating'] > 3.9 && $orgRating['employeeHappynessRating'] < 5.0) checked @endif>
                                    <label
                                        for="overAllEmployeeHappinessRatingStar4_{{ $orgRating['organization']->id }}"
                                        title="4 Stars Rating">&#9733;</label>

                                    <!-- 3 Star ✬ ✬ ✬ -->
                                    <input type="radio"
                                        name="overAllEmployeeHappinessRating{{ $orgRating['organization']->id }}"
                                        id="overAllEmployeeHappinessRatingStar3_{{ $orgRating['organization']->id }}"
                                        value="3" disabled @if ($orgRating['employeeHappynessRating'] > 2.9 && $orgRating['employeeHappynessRating'] < 4.0) checked @endif>
                                    <label
                                        for="overAllEmployeeHappinessRatingStar3_{{ $orgRating['organization']->id }}"
                                        title="3 Stars Rating">&#9733;</label>

                                    <!-- 2 Star ✬ ✬ -->
                                    <input type="radio"
                                        name="overAllEmployeeHappinessRating{{ $orgRating['organization']->id }}"
                                        id="overAllEmployeeHappinessRatingStar2_{{ $orgRating['organization']->id }}"
                                        value="2" disabled @if ($orgRating['employeeHappynessRating'] > 1.9 && $orgRating['employeeHappynessRating'] < 3.0) checked @endif>
                                    <label
                                        for="overAllEmployeeHappinessRatingStar2_{{ $orgRating['organization']->id }}"
                                        title="2 Stars Rating">&#9733;</label>

                                    <!-- 1 Star ✬ -->
                                    <input type="radio"
                                        name="overAllEmployeeHappinessRating{{ $orgRating['organization']->id }}"
                                        id="overAllEmployeeHappinessRatingStar1_{{ $orgRating['organization']->id }}"
                                        value="1" disabled @if ($orgRating['employeeHappynessRating'] >= 1.0 && $orgRating['employeeHappynessRating'] < 2.0) checked @endif>
                                    <label
                                        for="overAllEmployeeHappinessRatingStar1_{{ $orgRating['organization']->id }}"
                                        title="1 Star Rating">&#9733;</label>

                                    <!-- Employee Rating Happiness -->
                                    <span
                                        style="font-size: 24px; font-weight:500; color: #000000;  padding-right:5px;">{{ $orgRating['employeeHappynessRating'] }}</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /.............. Ends Organization Card Using loop  -->
            </a>
        </div>
    @endforeach
</div>
<div class="row">
    <div class="col-12 d-flex justify-content-end" id="savedsOrganizationPagination">
        @if ($userSavedsOrganizations['paginatedRatings'] && $userSavedsOrganizations['paginatedRatings']->count())
            {{ $userSavedsOrganizations['paginatedRatings']->appends(['searchOrganization' => request('searchOrganization')])->links('user.pagination.customPagination') }}
        @endif
    </div>
</div>

<!-- /.......... Saved Organization content goes here -->
