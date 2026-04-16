<?php

namespace App\Repositories\Interfaces\User\Organization;

interface OrganizationInterface
{

    /**
     * Get All Approved Organizations
     *
     * @return void
     */
    public function getOrganizations();

    /**
     * Get Organization By Id
     *
     * @param [type] $id
     * @param [type] $request
     * @return void
     */
    public function getOrganizationByIdDetail($id, $request);

    /**
     * Get Approved Organization by organizationId
     *
     * @param [type] $organizationId
     * @return void
     */
    public function getOrganization($organizationId);

    /**
     * Get status organization is saved or not.
     *
     * @param [type] $organizationId
     * @return boolean
     */
    public function isSavedOrganization($organizationId);

    /**
     * Saved the organization in User Profile
     *
     * @param [type] $organizationId
     * @return void
     */
    public function savedOrganization($organizationId);

    /**
     * Get User's All Saveds Organizations
     *
     * @return void
     */
    public function getUserSavedsOrganizations();

    /**
     * Get User's Saved Organization by using like operator from organization name or address
     *
     * @param [type] $organizationName
     * @return void
     */
    public function getUserSavedsOrganizationsByName($organizationName);

    /**
     * Get Organization Rating Given by the Logged-in user
     *
     * @return void
     */
    public function getUserRatedOrganizations();

    /**
     * Get User's Organization-Rating by using like operator from organization name or address
     *
     * @param [type] $organizationName
     * @return void
     */
    public function getUserRatedOrganizationsByName($organizationName);

    /**
     * Create organization
     *
     * @param array $data
     * @return void
     */
    public function createOrganization(array $data);

    /**
     * Get over all organization rating by organization id
     *
     * @param [type] $organizationId
     * @return void
     */
    public function getOverAllOrganizationRating($organizationId);

    /**
     * Get organization rating by user id
     *
     * @param [type] $organizationId
     * @return void
     */
    public function getOrganizationRating($organizationId, $edit, $ratingId);

    /**
     * Rate organization
     *
     * @param array $data
     * @return void
     */
    public function rateOrganization(array $data);

    /**
     * Get all approved organization list with rating
     *
     * @return void
     */
    public function getOrganizationRatingList();

    /**
     * Get all approved organization list with rating Using organization Name
     *
     * @param [type] $organizationName
     * @return void
     */
    public function getOrganizationRatingListByName($organizationName);

    /**
     * Get Organizational Data for Compare
     *
     * @param [type] $organizationId
     * @return void
     */
    public function compareOrganization($organizationId);

    /**
     * Get the Organization Rating with Reports and Helpful
     *
     * @param [type] $organizationId
     * @return void
     */
    public function getOrganizationRating_Report_Helpful($organizationId);

    /**
     * Get the Organization By Id
     *
     * @param [type] $organizationId
     * @return void
     */
    public function getOrganizationsById($organizationId);
}
