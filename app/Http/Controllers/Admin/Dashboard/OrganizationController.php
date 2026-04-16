<?php

namespace App\Http\Controllers\Admin\Dashboard;

use Exception;
use Illuminate\Http\Request;
use App\Models\OrganizationRating;
use App\Http\Controllers\Controller;
use App\Traits\OrganizationOverallRating;
use App\Enums\OrganizationRatingStatusEnum;
use App\DataTables\OrganizationRatingDataTable;
use App\Repositories\Interfaces\Admin\OrganizationRating\OrganizationRatingInterface;

class OrganizationController extends Controller
{

    public function __construct(private OrganizationRatingInterface $organizationRatingRepository) {}

    public function index(OrganizationRatingDataTable $dataTable)
    {
        return $dataTable->render('dashboard.organizationRating.index', get_defined_vars());
    }
    public function show($id)
    {
        try {

            $organizationRating = $this->organizationRatingRepository->show($id); 
            return response([
                'success' => true,
                'rating' => $organizationRating['rating'],
                'ratingCount' => $organizationRating['ratingCount']
            ]);
        } catch (Exception $e) {
            return response(['success' => false, 'message' => $e->getMessage()]);
        }
    }


    public function approve($id)
    {
        try {

            $rating = $this->organizationRatingRepository->approve($id);
            if ($rating) {
                return response([
                    'success' => true,
                    'message' => "Organization rating has been approved successfully.",
                ]);
            }
        } catch (Exception $e) {
            return response(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    public function reject($id)
    {
        try {

            $rating = $this->organizationRatingRepository->reject($id);

            if ($rating) {
                return response([
                    'success' => true,
                    'message' => "Organization rating has been rejected successfully.",
                ]);
            }
        } catch (Exception $e) {
            return response(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
