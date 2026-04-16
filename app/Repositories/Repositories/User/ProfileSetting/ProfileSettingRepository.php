<?php

namespace App\Repositories\Repositories\User\ProfileSetting;

use App\Models\User;
use App\Models\Department;
use App\Models\Organization;
use App\Traits\FileUploadTrait;
use App\Enums\OrganizationStatusEnum;
use App\Repositories\Interfaces\User\ProfileSetting\ProfileSettingInterface;
use Illuminate\Support\Facades\Auth;

class ProfileSettingRepository implements ProfileSettingInterface
{

    use FileUploadTrait;

    /**
     * Update User Profile
     */
    public function updateProfile(array $data)
    {
        try {
            $updateData = [
                'firstName' => trim($data['firstName']),
                'lastName' => trim($data['lastName']),
                'jobTitle' => $data['jobTitle'],
                'organizationId' => $data['organizationId'],
                'organizationName' => $data['organization'],
                'departmentId' => $data['departmentId'],
                'departmentName' => $data['department'],
            ];
 
            // Check if file is uploaded
            if (isset($data['fileUpload'])) {
                // Upload the file and get the file name
                $fileName = $this->uploadFile($data['fileUpload'], '/upload/profile');
                $updateData['image'] = $fileName;   // Update with new file name
            }

            // Update user profile
            User::where('id', Auth::user()->id)->update($updateData);

            return true;
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }
}
