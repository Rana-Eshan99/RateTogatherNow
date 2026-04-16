<?php

namespace App\Repositories\Interfaces\User\Department;

Interface DepartmentInterface{

    /**
     * Get All Departments Detail (Departments Associated With Organization) of GIven Approved Organization
     *
     * @param [type] $organizationId
     * @return void
     */
    public function getDepartments($organizationId);

    /**
     * Check Given Department associated with the Organization is valid or not.
     *
     * @param [type] $organizationId
     * @param [type] $departmentId
     * @return boolean
     */
    public function isValidDepartment($organizationId, $departmentId);
}

