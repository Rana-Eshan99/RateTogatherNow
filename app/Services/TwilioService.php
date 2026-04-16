<?php


namespace App\Services;

use Illuminate\Support\Facades\Log;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;
use Exception;

class TwilioService
{
    private $twilio_number, $client;

    function __construct()
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $this->twilio_number = getenv("TWILIO_NUMBER");
        $this->client = new Client($account_sid, $auth_token);
    }

    public function sendMessage($message, $recipients)
    {
        try {
            if (preg_match('/^((?:00|\+)92)?(0?3(?:[0-46]\d|55)\d{7})$/', $recipients)) {
                return ['status' => true];
            }

            if (preg_match('/^(\+44\s?7\d{3}|\(?07\d{3}\)?)\s?\d{3}\s?\d{3}$/', $recipients)) {
                return ['status' => true];
            }

            $this->client->messages->create(
                $recipients,
                ['from' => $this->twilio_number, 'body' => $message]
            );

            return ['status' => true];

        } catch (TwilioException $e) {
            $twillioExceptionCodes = [21211, 21408];

            if (in_array($e->getCode(), $twillioExceptionCodes)) {
                return ['status' => false, 'message' => $e->getMessage()];
            } else {
                $errorMessage = ErrorLogService::errorLog($e);

                if (env('TWILIO_LOGGER') == false) {
                    return ['status' => false, 'message' => substr($errorMessage, strpos($errorMessage, ":") + 1)];
                }

                $data = [
                    'Time' => gmdate("F j, Y, g:i a"),
                    'Status Code' => $e->getCode(),
                    'Message' => $e->getMessage(),
                ];

                Log::error('Twillo', $data);
                return ['status' => false, 'message' => substr($errorMessage, strpos($errorMessage, ":") + 1)];
            }
        }
    }
}
