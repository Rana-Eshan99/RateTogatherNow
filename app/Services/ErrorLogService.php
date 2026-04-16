<?php


namespace App\Services;

use App\Models\ErrorLog;
use Exception;

class ErrorLogService
{
     /**
     * Save Errors in log and also custom message on exception
     *
     * @param $e, $isMessageReturn, $service
     * @return Boolean True|False
     */
    static function errorLog($e,$isMessageReturn = true,$service = null)
    {
        try {
            $errorLog = ErrorLog::create([
                'filePath' => $e->getFile()?:'',
                'lineNo' => $e->getLine()?:'',
                'statusCode' => $service == 'stripe' ? $e->getStripeCode() : ($e->getCode()?:''),
                'errorMessage' => $e?:'',
            ]);

            if($isMessageReturn){
                return "There is an issue. Please contact to the support. Your support ticket no is ".$errorLog->id.".";
            }else{
                return $errorLog->id;
            }

        }catch (Exception $e){
            return $e->getMessage();
        }
    }

}
