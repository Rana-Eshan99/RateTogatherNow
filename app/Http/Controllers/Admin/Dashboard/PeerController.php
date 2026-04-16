<?php

namespace App\Http\Controllers\Admin\Dashboard;

use Exception;
use App\Models\PeerRating;
use Illuminate\Http\Request;
use App\Enums\PeerRatingStatusEnum;
use App\Http\Controllers\Controller;
use App\DataTables\PeerRatingDataTable;
use App\Traits\OrganizationOverallRating;
use App\Repositories\Interfaces\Admin\PeerRating\PeerRatingInterface;

class PeerController extends Controller
{

    use OrganizationOverallRating;

    public function __construct(private PeerRatingInterface $peerRatingRepository) {}
    public function index(PeerRatingDataTable $dataTable)
    {
        return $dataTable->render('dashboard.peerRating.index', get_defined_vars());
    }
    public function show($id)
    {
        try {
            $peerRating = $this->peerRatingRepository->show($id);
            return response([
                'success' => true,
                'rating' => $peerRating['rating'],
                'ratingCount' => $peerRating['ratingCount']
            ]);
        } catch (Exception $e) {
            return response(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    public function approve($id)
    {
        try {
            $rating = $this->peerRatingRepository->approve($id);
            if ($rating) {
                return response([
                    'success' => true,
                    'message' => "Peer rating has been approved successfully.",
                ]);
            }
        } catch (Exception $e) {
            return response(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    public function reject($id)
    {
        try {
            $rating = $this->peerRatingRepository->reject($id);
            if ($rating) {
                return response([
                    'success' => true,
                    'message' => "Peer rating has been rejected successfully.",
                ]);
            }
        } catch (Exception $e) {
            dd($e->getMessage());
            return response(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}