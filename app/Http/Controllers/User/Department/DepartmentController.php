<?php

namespace App\Http\Controllers\User\Department;

use Exception;
use Illuminate\Http\Request;
use App\Services\ErrorLogService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Department\AddDepartmentRequest;
use App\Repositories\Interfaces\User\Department\DepartmentInterface;
use App\Repositories\Repositories\User\Department\DepartmentRepository;
use App\Repositories\Interfaces\User\Organization\OrganizationInterface;
use App\Repositories\Repositories\User\Organization\OrganizationRepository;

class DepartmentController extends Controller
{
    /**
     * The repository instance
     *
     * @var DepartmentRepository
     */
    private $departmentRepository;

     /**
     * The repository instance
     *
     * @var OrganizationRepository
     */
    private $organizationRepository;

    /**
     * DepartmentController Constructor
     *
     * @param DepartmentRepository $departmentRepository
     * @param OrganizationRepository $organizationRepository
     */
    public function __construct(DepartmentInterface $departmentRepository, OrganizationInterface $organizationRepository)
    {
        $this->departmentRepository = $departmentRepository;
        $this->organizationRepository = $organizationRepository;
    }

    /**
     * Get department details using Organization Id
     *
     * @param [type] $organizationId
     * @return void
     */
    public function getDepartments($organizationId)
    {
        try {
            $departments = $this->departmentRepository->getDepartments($organizationId);
            return response()->json([
                'response' => [
                    'status' => true,
                    'departments' => $departments,
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

    /**
     * Add new department to the select organization
     *
     * @param AddDepartmentRequest $request
     * @return void
     */
    public function add(Request $request){
        try {

            // Checks that Given Selected organization should be Approved and Valid Organization
            $this->organizationRepository->getOrganization($request['organizationId']);

            // Create new department against the selected organization
            $this->departmentRepository->addDepartment($request->all());

            // Return the Updated departments against the selected organizations
            $departments = $this->departmentRepository->getDepartments($request['organizationId']);

            // Return the response
            return response()->json([
                'response' => [
                    'status' => true,
                    'message' => (__('messages.success.departmentAdded')),
                    'departments' => $departments
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
