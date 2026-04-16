<?php

namespace App\Repositories\Repositories\Admin\User;

use App\Models\User;
use App\Models\Department;
use App\Models\Organization;
use App\Enums\UserStatusEnum;
use App\Models\ApplicationFeedback;
use App\Models\Helpful;
use App\Models\OrganizationRating;
use App\Models\Peer;
use App\Models\PeerRating;
use App\Models\ReportRating;
use App\Models\Saved;
use Spatie\Permission\Models\Role;
use App\Repositories\Interfaces\Admin\User\AdminUserInterface;

class UserRepository implements AdminUserInterface
{
    /**
     * Get Users
     *
     * @param [type] $request
     * @return void
     */
    public function getUsers($request)
    {
        try {
            $adminRole = Role::where('name', 'Admin')->first();
            $data = User::where('status', UserStatusEnum::ACTIVE)
                ->whereHas('roles', function ($query) use ($adminRole) {
                    $query->where('id', '!=', $adminRole->id);
                })
                ->orderBy('createdAt', 'DESC')
                ->get();

            $data->map(function ($item) {
                $item->organization = Organization::where('id', $item->organizationId)->first()->name ?? $item->organizationName;
                $item->department = Department::where('id', $item->departmentId)->first()->name ?? $item->departmentName;
                $item->name = $item->firstName . ' ' . $item->lastName;
                return $item;
            });
            return $data;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }

    /**
     * Get Blocked Users
     *
     * @param [type] $request
     * @return void
     */
    public function getBlockedUsers($request)
    {
        try {
            $data = User::where('status', UserStatusEnum::BLOCK)
                ->orderBy('updatedAt', 'DESC')
                ->get();
            $data->map(function ($item) {
                $item->organization = Organization::where('id', $item->organizationId)->first()->name ?? $item->organizationName;
                $item->department = Department::where('id', $item->departmentId)->first()->name ?? $item->departmentName;
                $item->name = $item->firstName . ' ' . $item->lastName;
                return $item;
            });
            return $data;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }

    /**
     * Block User
     *
     * @param [type] $request
     * @return void
     */
    public function blockUser($request)
    {
        try {
            $user = User::find($request->id);
            if (!$user) {
                throw new \ErrorException(__('messages.error.invalidUser'));
            }

            $user->status = UserStatusEnum::BLOCK;
            $user->save();

            return true;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }

    public function unblockUser($request)
    {
        try {
            $user = User::find($request->id);
            if (!$user) {
                throw new \ErrorException(__('messages.error.invalidUser'));
            }

            $user->status = UserStatusEnum::ACTIVE;
            $user->save();

            return true;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }

    /**
     * Delete User
     *
     * @param [type] $request
     * @return void
     */
    public function deleteUser($request)
    {
        try {
            $user = User::find($request->id);

            if (!$user) {
                throw new \ErrorException(__('messages.error.invalidUser'));
            }

            Saved::whereIn('peerId', function ($query) use ($request) {
                $query->select('id')->from('peers')->where('userId', $request->id);
            })->delete();

            Saved::whereIn('organizationId', function ($query) use ($request) {
                $query->select('id')->from('organizations')->where('userId', $request->id);
            })->delete();

            // Delete dependent records
            ApplicationFeedback::where('userId', $request->id)->delete();
            Helpful::where('userId', $request->id)->delete();
            OrganizationRating::where('userId', $request->id)->delete();
            Organization::where('userId', $request->id)->delete();
            PeerRating::where('userId', $request->id)->delete();
            Peer::where('userId', $request->id)->delete();
            ReportRating::where('userId', $request->id)->delete();

            User::where('id', $request->id)->delete();

            return true;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }
}
