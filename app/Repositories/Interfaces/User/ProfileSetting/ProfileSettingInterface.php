<?php

namespace App\Repositories\Interfaces\User\ProfileSetting;

interface ProfileSettingInterface{
    /**
     * Update User Profile
     */
    public function updateProfile(array $data);

}
