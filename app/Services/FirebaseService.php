<?php

namespace App\Services;

use App\Models\FcmToken;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use stdClass;

class FirebaseService
{
    public $factory, $auth;

    /**
     * Library :  composer require kreait/firebase-php
     * initiating Factory() class and also creatingAuth;
     *
     * @return null
     */
    public function __construct()
    {
        $this->factory = (new Factory())->withServiceAccount(config('firebase.credentials.file'));
        $this->auth = $this->factory->createAuth();
    }

    /**
     * Validating user registeration tokens
     *
     * @param array $tokens
     * @return array $result
     */
    public function validateRegistrationTokens($tokens)
    {
        $messaging = $this->factory->createMessaging();
        $result = $messaging->validateRegistrationTokens($tokens);
        if(count($result['unknown']) > 0){
            FcmToken::whereIn('token',$result['unknown'])->delete();
            Log::error('Unknown FCM tokens', ['tokens' => $result['unknown']]);
        }
        if(count($result['invalid']) > 0){
            FcmToken::whereIn('token',$result['invalid'])->delete();
            Log::error('Invalid FCM tokens', ['tokens' => $result['invalid']]);
        }
        return $result['valid'];
    }

    /**
     * Get the remote configuaration value
     *
     * @param string $name
     * @return void $config
     */
    public function getRemoteConfigValue($name)
    {
        $remoteConfig = $this->factory->createRemoteConfig()->get();
        $config = json_decode(json_encode($remoteConfig->jsonSerialize()['parameters'][$name], true));

        return $config->defaultValue->value;
    }

    /**
     * Create a user account in firebase
     *
     * @param array $data
     * @return void $createUser
     */
    public function createUserAccount(array $data)
    {
        try {
            $createdUser = $this->auth->createUser([
                'email' => $data['email'],
                'password' => $data['password']
            ]);

            $createdUser['data'] = $createdUser;
            $createdUser['status'] = true;
        } catch (Firebase\Exception\FirebaseException $e) {
            $createdUser = new stdClass();
            $createdUser->message = $e->getMessage();
            $createdUser->status = false;
        }

        return $createdUser;
    }

    /**
     * @param $uid
     * @param $password
     *
     * @throws Firebase\Exception\AuthException
     * @throws Firebase\Exception\FirebaseException
     */
    public function updateUserPassword($uid, $password)
    {
        $this->auth->changeUserPassword($uid, $password);
    }

    /**
     * Get authenticate user token
     *
     * @param Uid|string $uid
     * @return token
     */
    public function getToken(string $uid): string
    {
        return (string)$this->auth->createCustomToken($uid);
    }

    /**
     * Delete firebase authenticated user
     *
     * @return boolean True,False
     */
    public function deleteFirebaseUser()
    {

        try {
            $users = $this->auth->listUsers();

            foreach ($users as $user) {
                /** @var \Kreait\Firebase\Auth\UserRecord $user */
                $this->auth->deleteUser($user->uid);
            }
        } catch (Firebase\Exception\FirebaseException $e) {
            return  false;
        }
    }

    /**
     * Delete multiple firebase authenticated users
     *
     * @param Uid|string $uid
     * @return boolean True,False
     */
    public function deleteMultiFirebaseUser(string $uid)
    {

        try {
            return (string) $this->auth->deleteUser($uid);
        } catch (Firebase\Exception\FirebaseException $e) {
            return  false;
        }
    }

    /**
     * Send push or cloud messages to multiple devices
     *
     * @param array $data
     * @return boolean True,False
     */
    public function cloudMessageToMultipleDevice($data)
    {
        try {

            $messaging = $this->factory->createMessaging();
            $title = $data['title'] ?? null;
            $body = $data['body'] ?? null;
            $imageUrl = $data['imageUrl'] ?? null;

            $notification = Notification::create($title, $body, $imageUrl);

            $message = CloudMessage::new();
            $message->withNotification($notification)->withData($data['data']);
            $messaging->sendMulticast($message, $data['FCMRegistrationTokens']);

        } catch (Firebase\Exception\FirebaseException $e) {

            if (env('FIREBASE_LOGGER') == false) {
                return false;
            }

            $data = [
                'Time' => gmdate("F j, Y, g:i a"),
                'Status Code' => $e->getCode(),
                'Message' => $e->getMessage(),
            ];

            Log::error('Firebase' . $data);
            return false;
        }
    }

    /**
     * Send push or cloud messages to single devices
     *
     * @param array $data
     * @return boolean True,False
     */
    public function cloudMessageToSingleDevice($data)
    {
        try {

            $messaging = $this->factory->createMessaging();
            $title = $data['title'] ?? null;
            $body = $data['body'] ?? null;
            $imageUrl = $data['imageUrl'] ?? null;

            $notification = Notification::create($title, $body, $imageUrl);

            $message = CloudMessage::withTarget('token', $data['FCMRegistrationToken'])->withNotification($notification)->withData($data['data']);
            $message = $messaging->send($message);

            Log::info('Firebase Notification', ['messageId' => $message, 'token' => $data['FCMRegistrationToken'], 'data' => $data['data']]);
        } catch (Firebase\Exception\FirebaseException $e) {

            if (env('FIREBASE_LOGGER') == false) {
                return false;
            }

            $data = [
                'Time' => gmdate("F j, Y, g:i a"),
                'Status Code' => $e->getCode(),
                'Message' => $e->getMessage(),
            ];

            Log::error('Firebase', $data);
            return false;
        }
    }
}
