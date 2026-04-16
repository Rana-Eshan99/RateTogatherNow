<?php

namespace App\Repositories\Interfaces\Admin\User;

interface AdminUserInterface
{

    /**
     * Get Users
     *
     * @param [type] $request
     * @return void
     */
    public function getUsers($request);

    /**
     * Block User
     *
     * @param [type] $request
     * @return void
     */
    public function blockUser($request);

    /**
     * Delete User
     *
     * @param [type] $request
     * @return void
     */
    public function deleteUser($request);

    /**
     * Unblock User
     *
     * @param [type] $request
     * @return void
     */
    public function unblockUser($request);

    /**
     * Get Blocked Users
     *
     * @param [type] $request
     * @return void
     */
    public function getBlockedUsers($request);

}
