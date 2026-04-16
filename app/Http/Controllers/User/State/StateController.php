<?php

namespace App\Http\Controllers\User\State;

use Exception;
use Illuminate\Http\Request;
use App\Services\ErrorLogService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\User\State\StateInterface;
use App\Repositories\Repositories\User\State\StateRepository;

class StateController extends Controller
{
    /**
     * The repository instance
     *
     * @var StateRepository
     */
    private $stateRepository;

    /**
     * StateController Constructor
     *
     * @param StateRepository $stateRepository
     */
    public function __construct(StateInterface $stateRepository)
    {
        $this->stateRepository = $stateRepository;
    }

    /**
     * Get states of respective country
     *
     * @param [type] $countryId
     * @return void
     */
    public function getStates($countryId)
    {
        try {
            $states = $this->stateRepository->getStates($countryId);
            return response()->json([
                'response' => [
                    'status' => true,
                    'states' => $states,
                ],
            ], JsonResponse::HTTP_OK);
        } catch (Exception $e) {
            ErrorLogService::errorLog($e);
            return response()->json([
                'response' => [
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ],
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

}
