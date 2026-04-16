<!-- Organizations Card -->
<div class="row">

    @if ($organizationCount === 'Organization')
        <div class="col mb-2">
            <div class="card" style="height: 320px; align-items: center;">
                <div class="card-body" style="align-content: center;">
                    <span style="font-size:16px; color: #00000080;">No Organization Found!</span>
                </div>
            </div>
        </div>
    @endif

    @foreach ($organizationRatings as $orgRating)
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-2">
            <a class="text-decoration-none refresh-page"
                href="{{ auth()->check()
                    ? route('user.organization.show', ['id' => $orgRating['organization']->id])
                    : route('organization.show', ['id' => $orgRating['organization']->id]) }}">
                <div class="card" style="border-radius: 8px">
                    <div class="card-body">
                        <!-- 1st Row -->
                        <div class="row" style="margin-bottom:16px;">
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
                                                <div class="organizationName"
                                                    title="{{ $orgRating['organization']->name }}">
                                                    {{ $orgRating['organization']->name }}
                                                </div>
                                                <div class="organizationAddress"
                                                    title="{{ $orgRating['organization']->address }}">
                                                    {{ $orgRating['organization']->address }}
                                                </div>
                                            </div>
                                        </td>
                                        <td style="vertical-align: baseline;">

                                            <div style="position: absolute; right: 10px">

                                                <form method="POST"
                                                    action="{{ route('user.organization.savedOrganization') }}"
                                                    id="savedOrganizationForm_{{ $orgRating['organization']->id }}">
                                                    @csrf
                                                    <input type="hidden" name="savedOrganizationId" readonly
                                                        id="organizationIdSaved_{{ $orgRating['organization']->id }}"
                                                        value="{{ $orgRating['organization']->id }}"
                                                        placeholder="Enter Organization id to save.">
                                                    <!-- Organization is already saved -->
                                                    <a href="#" class="unSavedOrganization"
                                                        data-organization-id="{{ $orgRating['organization']->id }}"
                                                        id="unSavedOrganization_{{ $orgRating['organization']->id }}"
                                                        style="display: {{ $orgRating['saved'] == true ? 'block' : 'none' }};">
                                                        <img src="{{ asset('img/icons/blueSavedIcon.png') }}"
                                                            alt="Save Organization" style="height: 24px; width:24px;">
                                                    </a>

                                                    <!-- Organization is not saved -->
                                                    <a href="#" class="savedOrganization"
                                                        data-organization-id="{{ $orgRating['organization']->id }}"
                                                        id="savedOrganization_{{ $orgRating['organization']->id }}"
                                                        style="display: {{ $orgRating['saved'] == false ? 'block' : 'none' }};">
                                                        <img src="{{ asset('img/icons/saveIcon.png') }}"
                                                            alt="Un-Save Organization"
                                                            style="height: 24px; width:24px;">
                                                    </a>
                                                </form>
                                            </div>

                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>


                        <!-- 2nd Row ==> Overall Rating -->
                        <div class="row align-items-center justify-content-between pt-0 pl-2 pr-2 pb-0">
                            <!-- Left: Overall Rating label -->
                            <span class="labelOverAllRating">Overall Rating:</span>

                            <!-- Right: Rating value and stars -->
                            <div class="d-flex align-items-center">
                                  <!-- Overall Rating Value -->
                                  <span class="labelOverAllRatingValue" style="margin-left: 0px;">
                                    {{ $orgRating['overAllRating'] }}
                                </span>
                                <div class="star-rating disabled" style="display: flex; align-items: center;">
                                    <!-- 5 Star -->
                                    <input type="radio" disabled value="5"
                                        name="overAllRating{{ $orgRating['organization']->id }}"
                                        id="overAllRatingStar5_{{ $orgRating['organization']->id }}"
                                        @if ($orgRating['overAllRating'] > 4.9) checked @endif>
                                    <label for="overAllRatingStar5_{{ $orgRating['organization']->id }}" title="5 Stars Rating">&#9733;</label>

                                    <!-- 4 Star -->
                                    <input type="radio" disabled value="4"
                                        name="overAllRating{{ $orgRating['organization']->id }}"
                                        id="overAllRatingStar4_{{ $orgRating['organization']->id }}"
                                        @if ($orgRating['overAllRating'] > 3.9 && $orgRating['overAllRating'] < 5.0) checked @endif>
                                    <label for="overAllRatingStar4_{{ $orgRating['organization']->id }}" title="4 Stars Rating">&#9733;</label>

                                    <!-- 3 Star -->
                                    <input type="radio" disabled value="3"
                                        name="overAllRating{{ $orgRating['organization']->id }}"
                                        id="overAllRatingStar3_{{ $orgRating['organization']->id }}"
                                        @if ($orgRating['overAllRating'] > 2.9 && $orgRating['overAllRating'] < 4.0) checked @endif>
                                    <label for="overAllRatingStar3_{{ $orgRating['organization']->id }}" title="3 Stars Rating">&#9733;</label>

                                    <!-- 2 Star -->
                                    <input type="radio" disabled value="2"
                                        name="overAllRating{{ $orgRating['organization']->id }}"
                                        id="overAllRatingStar2_{{ $orgRating['organization']->id }}"
                                        @if ($orgRating['overAllRating'] > 1.9 && $orgRating['overAllRating'] < 3.0) checked @endif>
                                    <label for="overAllRatingStar2_{{ $orgRating['organization']->id }}" title="2 Stars Rating">&#9733;</label>

                                    <!-- 1 Star -->
                                    <input type="radio" disabled value="1"
                                        name="overAllRating{{ $orgRating['organization']->id }}"
                                        id="overAllRatingStar1_{{ $orgRating['organization']->id }}"
                                        @if ($orgRating['overAllRating'] >= 1.0 && $orgRating['overAllRating'] < 2.0) checked @endif>
                                    <label for="overAllRatingStar1_{{ $orgRating['organization']->id }}" title="1 Star Rating">&#9733;</label>
                                </div>
                            </div>
                        </div>

                        <!-- 3rd Row  ===> Employee Happiness -->
                        <div class="row align-items-center justify-content-between pt-0 pl-2 pr-2 pb-0">
                            <!-- Left: Employee Happiness Rating label -->

                            <span class="labelOverAllEmpHappiness">Employee<span class="d-md-none d-block"></span> Happiness:</span>

                            <!-- Right: Rating value and stars -->
                            <div class="d-flex align-items-center">
                                 <!-- Employee Happiness Rating Value -->
                                 <span class="labelOverAllEmpHappinessValue" style="margin-left: 0px;">
                                    {{ $orgRating['employeeHappynessRating'] }}
                                </span>
                                <div class="star-rating disabled" style="display: flex; align-items: center;">
                                    <!-- 5 Star -->
                                    <input type="radio" value="5" disabled
                                        name="overAllEmployeeHappinessRating{{ $orgRating['organization']->id }}"
                                        id="overAllEmployeeHappinessRatingStar5_{{ $orgRating['organization']->id }}"
                                        @if ($orgRating['employeeHappynessRating'] > 4.9) checked @endif>
                                    <label for="overAllEmployeeHappinessRatingStar5_{{ $orgRating['organization']->id }}"
                                        title="5 Stars Rating">&#9733;</label>

                                    <!-- 4 Star -->
                                    <input type="radio" value="4" disabled
                                        name="overAllEmployeeHappinessRating{{ $orgRating['organization']->id }}"
                                        id="overAllEmployeeHappinessRatingStar4_{{ $orgRating['organization']->id }}"
                                        @if ($orgRating['employeeHappynessRating'] > 3.9 && $orgRating['employeeHappynessRating'] < 5.0) checked @endif>
                                    <label for="overAllEmployeeHappinessRatingStar4_{{ $orgRating['organization']->id }}"
                                        title="4 Stars Rating">&#9733;</label>

                                    <!-- 3 Star -->
                                    <input type="radio" value="3" disabled
                                        name="overAllEmployeeHappinessRating{{ $orgRating['organization']->id }}"
                                        id="overAllEmployeeHappinessRatingStar3_{{ $orgRating['organization']->id }}"
                                        @if ($orgRating['employeeHappynessRating'] > 2.9 && $orgRating['employeeHappynessRating'] < 4.0) checked @endif>
                                    <label for="overAllEmployeeHappinessRatingStar3_{{ $orgRating['organization']->id }}"
                                        title="3 Stars Rating">&#9733;</label>

                                    <!-- 2 Star -->
                                    <input type="radio" value="2" disabled
                                        name="overAllEmployeeHappinessRating{{ $orgRating['organization']->id }}"
                                        id="overAllEmployeeHappinessRatingStar2_{{ $orgRating['organization']->id }}"
                                        @if ($orgRating['employeeHappynessRating'] > 1.9 && $orgRating['employeeHappynessRating'] < 3.0) checked @endif>
                                    <label for="overAllEmployeeHappinessRatingStar2_{{ $orgRating['organization']->id }}"
                                        title="2 Stars Rating">&#9733;</label>

                                    <!-- 1 Star -->
                                    <input type="radio" value="1" disabled
                                        name="overAllEmployeeHappinessRating{{ $orgRating['organization']->id }}"
                                        id="overAllEmployeeHappinessRatingStar1_{{ $orgRating['organization']->id }}"
                                        @if ($orgRating['employeeHappynessRating'] >= 1.0 && $orgRating['employeeHappynessRating'] < 2.0) checked @endif>
                                    <label for="overAllEmployeeHappinessRatingStar1_{{ $orgRating['organization']->id }}"
                                        title="1 Star Rating">&#9733;</label>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>
<!-- /......... Organizations Card -->

<!-- Pagination Links -->
<div class="row">
    <div class="col-12 d-flex justify-content-end">
        @if ($paginatedRatings && $paginatedRatings->count())
            {{ $paginatedRatings->appends(['searchOrganization' => request('searchOrganization')])->links('user.pagination.customPagination') }}
        @endif
    </div>
</div>
<!-- /............. Pagination Links -->
@if(!empty($organizationRatings) && isset($organizationRatings[0]['organization']))
    <script>
        var ENDPOINT = "{{ auth()->check() ? route('user.organization.show', ['id' => $organizationRatings[0]['organization']->id]) : route('organization.show', ['id' => $organizationRatings[0]['organization']->id]) }}";
    </script>
@endif
