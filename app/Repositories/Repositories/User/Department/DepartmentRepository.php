<?php

namespace App\Repositories\Repositories\User\Department;

use App\Models\Department;
use App\Models\Organization;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Enums\OrganizationStatusEnum;
use App\Repositories\Interfaces\User\Department\DepartmentInterface;

class DepartmentRepository implements DepartmentInterface
{

    /**
     * Get All Departments Detail (Departments Associated With Organization) of GIven Approved Organization
     *
     * @param [type] $organizationId
     * @return void
     */
    public function getDepartments($organizationId)
    {
        try {
            $organization = Organization::where(['id' => $organizationId, 'status' => OrganizationStatusEnum::APPROVED])->first();
            if (!($organization)) {
                if (Auth::check()) {
                    return redirect()->route('user.organization.listOrganization')->with('error', __('messages.error.invalidOrganization'));
                } else {
                    return redirect()->route('organization.listOrganization')->with('error', __('messages.error.invalidOrganization'));
                }
            } else {
                $departments = Department::where('organizationId', $organization->id)->orderBy('name', 'asc')->get();
            }
            return $departments;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }

    /**
     * Check Given Department associated with the Organization is valid or not.
     *
     * @param [type] $organizationId
     * @param [type] $departmentId
     * @return boolean
     */
    public function isValidDepartment($organizationId, $departmentId)
    {
        try {
            $organization = Organization::where(['id' => $organizationId, 'status' => OrganizationStatusEnum::APPROVED])->first();
            if (!($organization)) {
                throw new \ErrorException(__('messages.error.invalidOrganization'));
            } else {
                $departments = Department::where('id', $departmentId)->where('organizationId', $organization->id)->first();
                if (!($departments)) {
                    return false;
                } else {
                    return true;
                }
            }
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }

    /**
     * Add Department
     *
     * @param array $data
     * @return void
     */
    public function addDepartment(array $data)
    {
        try {
            DB::beginTransaction();

            Department::updateOrCreate(
                [
                    'name' => $data['department'],
                    'organizationId' => $data['organizationId']
                ],
                [
                    'organizationId' => $data['organizationId'],
                    'name' => $data['department']
                ]
            );

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \ErrorException($e->getMessage());
        }
    }
}
