<!-- My Rating card content -->
<div class="from-group row">
    <div class="col-lg-8 col-md-6 col-sm-12 mb-1 justify-content-end">
        <!-- Default box -->

        <div class="nav d-flex flex-row" id="myRatingPeersOrganizationDiv">
            <div class="nav-link myRatings active" id="myRatingPeersTab" data-toggle="tab" href="#myRatingPeers">
                Peers
            </div>
            <div class="nav-link myRatings" id="myRatingOrganizationsTab" data-toggle="tab" href="#myRatingOrganizations">
                Organizations
            </div>
        </div>

    </div>

    <!-- Search Div for Organization -->
    <div class="col-lg-4 col-md-6 col-sm-12 mb-1 justify-content-end">
        <input type="hidden" name="routeName" id="routeName"
            value="{{ route('user.profileSetting.profileSettingForm') }}">
        <div class="input-group">
            <div class="input-group-prepend" style="position: relative; width:100%;">
                <input type="text" name="searchMyOrganizationRating" id="searchMyOrganizationRating"
                    class="form-control customBorderRadius inputFieldHeight" placeholder="Search"
                    style="padding-left: 40px;">
                <img class="img-responsive" src="{{ asset('img/icons/searchIcon.svg') }}" alt="Search"
                    style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); pointer-events: none; height:20px; width:20px; object-fit: cover;"></img>
            </div>
        </div>
    </div>
</div>

<hr class="" style="margin-top: 12px">

<!-- My Rating Peers & Organization Tab content -->
<div class="tab-content">
    <!-- My Rating-Peers content goes here -->
    <div id="myRatingPeers" class="tab-pane active">
        <!-- My Rating-Peers content goes here -->
        <div id="myRatingPeersContentDiv">
            @include('user.profileSetting.tabs.ratings.peerRating')
        </div>

    </div>
    <!-- /........ My Rating-Peers content goes here -->

    <!-- My Rating-Organizations content goes here -->
    <div id="myRatingOrganizations" class="tab-pane fade">
        <!-- My Rating-Organizations content goes here -->
        <div id="myRatingOrganizationsContentDiv">
            @include('user.profileSetting.tabs.ratings.organizationRating')
        </div>
    </div>
    <!-- /.......... My Rating-Organizations content goes here -->


</div>

<!-- /.......... My Rating content goes here -->
