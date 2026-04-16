<?php

namespace App\Http\Controllers\User\Home;

use Exception;
use App\Models\Peer;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Services\ErrorLogService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\CurrentUserLocation;
use App\Repositories\Interfaces\User\Home\HomeInterface;

class HomeController extends Controller
{

    /**
     * The repository instance
     *
     * @var HomeRepository
     */
    private $homeRepository;

    /**
     * HomeController Constructor
     *
     * @param HomeInterface $homeRepository
     */
    public function __construct(HomeInterface $homeRepository)
    {
        $this->homeRepository = $homeRepository;
    }

    /**
     * Get Organization / Peer Details Associated with query
     *
     * @param Request $request
     * @return void
     */
    public function getData(Request $request)
    {
        try {
            $data = $this->homeRepository->getData($request);
            return response()->json([
                'response' => [
                    'status' => true,
                    'organizations' => $data['organizations'],
                    'peers' => $data['peers'],
                ],
            ], JsonResponse::HTTP_OK);
        } catch (Exception $e) {
            ErrorLogService::errorLog($e);
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Show Home Page
     *
     * @return void
     */
    public function index(Request $request)
    {
        try {

            return view('home.home');
        } catch (Exception $e) {
            ErrorLogService::errorLog($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function saveLocation(Request $request)
    {
        try {
            $data = [
                'deviceIdentifier' => $request->visitorId,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ];
            $curentUser = CurrentUserLocation::where('deviceIdentifier', $request->visitorId)->first();
            if ($curentUser){
                $curentUser->update($data);
            }else{
                CurrentUserLocation::create($data);
            }
        } catch (Exception $e) {
            ErrorLogService::errorLog($e);
            return response()->json([
                'response' => [
                    'status' => 'error',
                    'message' => $e->getMessage()
                ],
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}
