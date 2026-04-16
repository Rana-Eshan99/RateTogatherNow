<?php

namespace App\Http\Controllers\User\AppFeedback;

use Illuminate\Http\Request;
use App\Services\ErrorLogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\ApplicationFeedback;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\AppRating\AppRatingRequest;
use App\Repositories\Interfaces\User\AppFeedback\AppFeedbackInterface;

class AppFeedbackController extends Controller
{
    /**
     * The repository instance
     *
     * @var AppFeedbackInterface
     */
    public function __construct(private AppFeedbackInterface $appFeedbackRepository)
    {
    }

    /**
     * Function to Show add app feedback blade file
     *
     * @return void
     */
    public function addAppFeedbackForm()
    {
        try {
            return view('appFeedback.appFeedbackCreate');
        } catch (\Exception $e) {
            ErrorLogService::errorLog($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Function to save app feedback
     *
     * @param AppRatingRequest $request
     * @return JsonResponse
     */
    public function saveAppFeedback(AppRatingRequest $request)
    {
       try {
          $created =  $this->appFeedbackRepository->rateApp($request);
            if ($created) {
                return response()->json([
                    'response' => [
                        'status' => true,
                    ],
                ], JsonResponse::HTTP_OK);
            }
        } catch (\Exception $e) {
            ErrorLogService::errorLog($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
