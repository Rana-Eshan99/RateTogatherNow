<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Custom Message Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    /**
     *  Return the Success Responses from Repository or Controllers
     *
     */

    'success' => [
        'profileUpdated' => 'Profile has been updated successfully.',
        'departmentAdded' => 'Department has been added successfully.',
        'savedOrganization' => 'Organization has been saved successfully.',
        'unSavedOrganization' => 'Organization has been un-saved successfully.',
        'savedPeer' => 'Peer has been saved successfully.',
        'unSavedPeer' => 'Peer has been un-saved successfully.',
    ],

    /**
     *  Return the Information Related Messages from Repository or Controllers
     *
     */
    'info' => [
        //
    ],

    /**
     *  Return the Error Responses from Repository or Controllers
     *
     */
    'error' => [
        'emailNotRegistered' => 'This email address is not currently registered, kindly sign up now.',
        'emailRegistered' => 'An account with the provided email already exists, please sign in.',
        'emailRequired' => 'Email Required.',
        'invalidAdminLogin' => 'Email not registered. Please try again.',
        'serviceProverError' => 'Invalid service provider.',
        'invalidOtpCode' => 'Verification code is invalid.',
        'expiredOtpCode' => 'Verification code expired.',
        'invalidOtpType' => 'Otp Type is invalid.',
        'roleNotDefined' => 'Role not defined.',
        'blockedUser' => 'Your account has been blocked. Please contact your administrator.',
        'inactiveUser' => 'Your account is in-active now. Please Contact your administrator.',
        'invalidCredentials' => 'Invalid User Credentials.',
        'invalidUserStatus' => 'Invalid User Status',
        'invalidUserRole' => 'You don\'t have permission.',
        'invalidOrganization' => 'Organization not found.',
        'organizationHasPeers' => 'Cannot delete: Remove associated peers first.',
        'invalidDepartment' => 'Department not found.',
        'invalidOtpType' => 'Otp Type is invalid.',
        'emailRequired' => 'Email Required.',
        'invalidAdminLogin' => 'Email not registered. Please try again.',
        'departmentNotUnique' => 'Provided department name already registered, please enter a different one.',
        'countryNotFound' => 'Country not found.',
        'invalidState' => 'State not found.',
        'invalidPeer' => 'Peer not found.',
        'invalidRequest' => 'Invalid Request.',
        'organizationExists' => 'Organization already exists.',
    ],
];