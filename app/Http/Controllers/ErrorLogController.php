<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ErrorLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Exception;

class ErrorLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            ## Read value
            $draw = $request->get('draw');
            $start = $request->get("start");
            $rowperpage = $request->get("length"); // Rows display per page

            $columnIndex_arr = $request->get('order');


            $order_arr = $request->get('order');
            $search_arr = $request->get('search');
            $columnName_arr = $request->get('columns');
            $columnIndex = $columnIndex_arr[0]['column']; // Column index


            if ($columnName_arr[$columnIndex]['data'] == 'id') {
                $columnName_arr[$columnIndex]['data'] = 'id';
            } else if ($columnName_arr[$columnIndex]['data'] == 'errorMessage') {
                $columnName_arr[$columnIndex]['data'] = 'errorMessage';
            } else if ($columnName_arr[$columnIndex]['data'] == 'ticketStatus') {
                $columnName_arr[$columnIndex]['data'] = 'ticketStatus';
            }

            $columnName = $columnName_arr[$columnIndex]['data']; // Column name
            $columnSortOrder = $order_arr[0]['dir']; // asc or desc
            $searchValue = $search_arr['value']; // Search value

            // Total records
            $totalRecords = ErrorLog::select('count(*) as allcount')->count();
            $totalRecordswithFilter = ErrorLog::select('count(*) as allcount')
                ->where('errorMessage', 'like', '%' . $searchValue . '%')
                ->orWhere('id', 'like', '%' . $searchValue . '%')->count();

            if($request->get('ticketStatus') != null && $searchValue != null){
                $totalRecordswithFilter = ErrorLog::select('count(*) as allcount')
                ->where('errorMessage', 'like', '%' . $searchValue . '%')
                ->orWhere('id', 'like', '%' . $searchValue . '%')
                ->where('ticketStatus', $request->get('ticketStatus'))
                ->count();
            }else if($request->get('ticketStatus') != null){
                $totalRecordswithFilter = ErrorLog::select('count(*) as allcount')
                ->where('ticketStatus', $request->get('ticketStatus'))
                ->count();
            }else{
                $totalRecordswithFilter = ErrorLog::select('count(*) as allcount')
                ->where('errorMessage', 'like', '%' . $searchValue . '%')
                ->orWhere('id', 'like', '%' . $searchValue . '%')
                ->count();
            }


            $errorLogs = ErrorLog::query();

            if($searchValue != null){
                $errorLogs = $errorLogs->where('id', $searchValue)
                        ->orWhere('errorMessage', 'like', '%' . $searchValue . '%');
            }

            if($request->get('ticketStatus') != null){
                $errorLogs = $errorLogs->where('ticketStatus', $request->get('ticketStatus'));
            }

            if($rowperpage != null){
                $errorLogs = $errorLogs->orderBy('id', 'desc')->skip($start)->take($rowperpage)->get();
            }else{
                $errorLogs = $errorLogs->orderBy('id', 'desc')->get();
            }
            $data_arr = [];

            foreach ($errorLogs as $i => $log) {
                $status = '';
                if($log->ticketStatus == 'Pending'):
                    $status = '<span class="badge badge-pill badge-warning px-3 py-1">'.$log->ticketStatus.'</span>';
                elseif ($log->ticketStatus == 'Resolved'):
                    $status = '<span class="badge badge-pill badge-success px-3 py-1">'.$log->ticketStatus.'</span>';
                elseif ($log->ticketStatus == 'Other'):
                    $status = '<span class="badge badge-pill badge-dark px-3 py-1">'.$log->ticketStatus.'</span>';
                endif;

                $actions = '';
                if ($log->ticketStatus == 'Pending') {
                    $actions .= '<button class="btn btn-primary btn-sm" onclick="actionOnTicket('.$log->id.','."'Resolved'".')"><i class="nav-icon fa fa-check-circle"></i> Resolve</button>
                                <button class="btn btn-secondary btn-sm" onclick="actionOnTicket('.$log->id.','."'Other'".')"><i class="nav-icon fa fa-check-th-large"></i> Other</button>';
                }
                $actions .= '<a class="btn btn-light btn-sm" href="/error-log/detail/'.$log->id.'"> <i class="nav-icon fa fa-eye"></i> View</a>';

                $data_arr[] = array(
                    "id" => $log->id,
                    "errorMessage" => Str::limit($log->errorMessage,65,' ....'),
                    "ticketStatus" => $status ?? '',
                    "action" => $actions,

                );
            }

            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordswithFilter,
                "aaData" => $data_arr
            );

            return response($response);
        }

        return view('admin.partialPages.sidebar.errorLog.index',get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            ErrorLog::where('id',$request->id)->update($request->except('_token'));
            toastr()->success('Comment Successfully Added!','', ['timeOut' => 5000]);
            return response(['status' => true, 'message' => 'Comment Successfully Added!'],JsonResponse::HTTP_OK);
        }catch(Exception $e){
            return response(['status' => false, 'message' => $e->getMessage()],JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $errorLog = ErrorLog::find($id);
        return view('admin.partialPages.sidebar.errorLog.show',compact('errorLog'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
