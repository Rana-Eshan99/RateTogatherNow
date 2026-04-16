<?php

namespace App\Http\Controllers\Admin\Dashboard\User;

use App\Models\Organization;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Services\ErrorLogService;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use App\Repositories\Interfaces\Admin\User\AdminUserInterface;
use App\Repositories\Interfaces\Admin\Organization\AdminOrganizationInterface;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(private AdminUserInterface $userRepository) {}

    /**
     * Get Users
     *
     * @param Request $request
     * @return void
     */
    public function getUsers(Request $request)
    {
        if ($request->ajax()) {
            try {
                $data = $this->userRepository->getUsers($request);
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="block btn" style="background-color:#26323829; color: #333333; border: none; border-radius: 5px; display: inline-flex; align-items: center; padding: 8px 16px; width: 89px; height: 32px;">
                        <img src="' . asset('img/icons/block.svg') . '" style="width: 11px; height: 12px; margin-right: 5px; margin-bottom: 0px">
                        <span style="font-size: 16px; margin-top: 2px; font-weight: 600; font-family: \'Source Sans 3\', sans-serif;">Block</span>
                    </a>

                    <a href="javascript:void(0)" data-id="' . $row->id . '" class="delete btn btn-danger" style="background-color:#FFE4E4; color: #DC143C; border: none; border-radius: 5px; display: inline-flex; align-items: center; padding: 8px 16px; width: 89px; height: 32px;">
                        <img src="' . asset('img/icons/deleteutton.svg') . '" style="width: 11px; height: 12px; margin-right: 5px; margin-bottom: 0px">
                        <span style="font-size: 16px; margin-top: 2px; font-weight: 600; font-family: \'Source Sans 3\', sans-serif;">Delete</span>
                    </a>';
                        return $btn;
                    })
                    ->editColumn('name', function ($row) {
                        $Name = $row->firstName . ' ' . $row->lastName;
                        $formattedName = strlen($Name) > 30 ? substr($Name, 0, 30) . '...' : $Name;
                        $staticImage = asset('img/SignUpDefaultAvatar.png');
                        $realImage = $row->image ? env('AWS_URL') . $row->image : $staticImage;
                        return '<img src="' . $realImage . '" onerror="this.src=\'' . $staticImage . '\'" class="rounded-circle object-fit-cover mr-1" width="32px" height="32px" /> ' . $formattedName;
                    })
                    ->rawColumns(['action','name'])
                    ->make(true);
            } catch (\Exception $e) {
                ErrorLogService::errorLog($e);
                return response()->json(['error' => $e->getMessage() . ' Line: ' . $e->getLine() . ' File: ' . $e->getFile()]);
            }
        }

        return view('dashboard.user.user');
    }

    /**
     * Get Blocked Users
     *
     * @param Request $request
     * @return void
     */
    public function getBlockedUsers(Request $request)
    {
        if ($request->ajax()) {
            try {
                $data = $this->userRepository->getBlockedUsers($request);
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="unblock btn" style="background-color:#26323829; color: #333333; border: none; border-radius: 5px; display: inline-flex; align-items: center; padding: 8px 16px; width: 110px; height: 32px;">
                        <img src="' . asset('img/icons/block.svg') . '" style="width: 11px; height: 12px; margin-right: 5px; margin-bottom: 0px">
                        <span style="font-size: 16px; margin-top: 2px; font-weight: 600; font-family: \'Source Sans 3\', sans-serif;">Unblock</span>
                    </a>

                    <a href="javascript:void(0)" data-id="' . $row->id . '" class="delete btn btn-danger" style="background-color:#FFE4E4; color: #DC143C; border: none; border-radius: 5px; display: inline-flex; align-items: center; padding: 8px 16px; width: 89px; height: 32px;">
                        <img src="' . asset('img/icons/deleteutton.svg') . '" style="width: 11px; height: 12px; margin-right: 5px; margin-bottom: 0px">
                        <span style="font-size: 16px; margin-top: 2px; font-weight: 600; font-family: \'Source Sans 3\', sans-serif;">Delete</span>
                    </a>';
                        return $btn;
                    })
                    ->editColumn('name', function ($row) {
                        $Name = $row->firstName . ' ' . $row->lastName;
                        $formattedName = strlen($Name) > 30 ? substr($Name, 0, 30) . '...' : $Name;
                        $staticImage = asset('img/SignUpDefaultAvatar.png');
                        $realImage = $row->image ? env('AWS_URL') . $row->image : $staticImage;
                        return '<img src="' . $realImage . '" onerror="this.src=\'' . $staticImage . '\'" class="rounded-circle object-fit-cover mr-1" width="32px" height="32px" /> ' . $formattedName;
                    })
                    ->rawColumns(['action','name'])
                    ->make(true);
            } catch (\Exception $e) {
                ErrorLogService::errorLog($e);
                return response()->json(['error' => $e->getMessage() . ' Line: ' . $e->getLine() . ' File: ' . $e->getFile()]);
            }
        }
    }
    /**
     * Block User
     *
     * @param Request $request
     * @return void
     */
    public function blockUser(Request $request)
    {
        try {
            $this->userRepository->blockUser($request);
            return response()->json(['success' => 'User blocked successfully']);
        } catch (\Exception $e) {
            ErrorLogService::errorLog($e);
            return response()->json(['error' => $e->getMessage() . ' Line: ' . $e->getLine() . ' File: ' . $e->getFile()]);
        }
    }

    /**
     * Unblock User
     *
     * @param Request $request
     * @return void
     */
    public function unblockUser(Request $request)
    {
        try {
            $this->userRepository->unblockUser($request);
            return response()->json(['success' => 'User unblocked successfully']);
        } catch (\Exception $e) {
            ErrorLogService::errorLog($e);
            return response()->json(['error' => $e->getMessage() . ' Line: ' . $e->getLine() . ' File: ' . $e->getFile()]);
        }
    }

    /**
     * Delete User
     *
     * @param Request $request
     * @return void
     */
    public function deleteUser(Request $request)
    {
        try {

            $this->userRepository->deleteUser($request);

            return response()->json(['success' => 'User deleted successfully']);
        } catch (\Exception $e) {
            ErrorLogService::errorLog($e);
            return response()->json(['error' => $e->getMessage() . ' Line: ' . $e->getLine() . ' File: ' . $e->getFile()]);
        }
    }

}
