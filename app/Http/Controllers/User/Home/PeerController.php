<?php

namespace App\Http\Controllers\User\Home;

use Exception;
use Illuminate\Http\Request;
use App\Services\ErrorLogService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\User\Peer\PeerInterface;

class PeerController extends Controller
{
    /**
     * The repository instance
     *
     * @var PeerRepository
     */
    private $peerRepository;

    /**
     * PeerController Constructor
     *
     * @param PeerInterface $peerRepository
     */
    public function __construct(PeerInterface $peerRepository)
    {
        $this->peerRepository = $peerRepository;
    }

    /**
     * Show Peer Details
     *
     * @param [type] $id
     * @param Request $request
     * @return void
     */
    public function show($id, Request $request)
    {
        try {
            if ($request->ajax()) {
                $visitorId = $request->visitorId;
                session(['visitorId' => $visitorId]);
            }
            // Get Peer details
            $data = $this->peerRepository->getPeerByIdDetail($id, $request);

            // Get Status tha Peer is saved or not
            $isSavedPeer = $this->peerRepository->isSavedPeer($id);

            // Get the peer Rating with the status of helpful and report_ratings
            $peerRating = $this->peerRepository->getPeerRating_Report_Helpful($id);
            if ($request->ajax()) {
                $view = view('peer.rating', compact('peerRating'))->render();
                return response()->json(['html' => $view]);
            }
            return view('peer.detailPage', [
                'peer' => $data['peer'],
                'formattedOverAllRating' => $data['formattedOverAllRating'],
                'yesPercentage' => $data['yesPercentage'],
                'noPercentage' => $data['noPercentage'],
                'color' => $data['color'],
                'peerRating' => $peerRating,
                'totalResponses' => $data['totalResponses'],
                'isSavedPeer' => $isSavedPeer,
            ]);
        } catch (Exception $e) {
            ErrorLogService::errorLog($e);
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ], JsonResponse::HTTP_BAD_REQUEST);
            } else {
                return redirect()->back()->with('error', $e->getMessage());
            }
        }
    }
}
