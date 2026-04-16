<?php

namespace App\Http\Controllers\User\Home;

use Exception;
use App\Models\ErrorLog;
use Illuminate\Http\Request;
use App\Services\ErrorLogService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\User\Helpful\HelpfulInterface;
use App\Repositories\Repositories\User\Helpful\HelpfulRepository;

class HelpfulController extends Controller
{
    /**
     * The repository instance
     *
     * @var HelpfulRepository
     */
    private $helpfulRepository;

    /**
     * Home => HelpfulController Constructor
     *
     * @param HelpfulInterface $helpfulRepository
     */
    public function __construct(HelpfulInterface $helpfulRepository)
    {
        $this->helpfulRepository = $helpfulRepository;
    }

    /**
     * Save or Update or Delete the Helpful record against the given organization rating id.
     *
     * @param Request $request
     * @return void
     */
    public function saveHelpfulOrganization(Request $request)
    {
        try {
        $countData = $this->helpfulRepository->saveHelpful_Organization($request->all());
        // Return a JSON response with the counts
        return response()->json([
            'response' => [
                'status' => true,
                'count' => $countData['count'], // helpful count
                'notHelpfulCount' => $countData['notHelpfulCount'], // not helpful count
            ]
        ], JsonResponse::HTTP_OK);
        } catch (Exception $e) {
            ErrorLogService::errorLog($e);
            return response()->json([
                'response' => [
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ]
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Save or Update or Delete the Helpful record against the given peer rating id.
     *
     * @param Request $request
     * @return void
     */
    public function saveHelpfulPeer(Request $request)
    {
        try {
            $countData = $this->helpfulRepository->saveHelpful_Peer($request->all());
            // Return a JSON response with the counts
            return response()->json([
                'response' => [
                    'status' => true,
                    'count' => $countData['count'], // helpful count
                    'notHelpfulCount' => $countData['notHelpfulCount'], // not helpful count
                ]
            ], JsonResponse::HTTP_OK);
        } catch (Exception $e) {
            ErrorLogService::errorLog($e);
            return response()->json([
                'response' => [
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ]
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}
