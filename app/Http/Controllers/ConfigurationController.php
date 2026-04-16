<?php

namespace App\Http\Controllers;

use App\Enums\ConfigurationEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Configuration;
use Exception;
use Illuminate\Support\Facades\DB;

class ConfigurationController extends Controller
{
    /**
     * Display a listing of the conguaration values.
     *
     * @return View view()
     */
    public function view()
    {
        $configs = Configuration::orderBy('type')->get();
        return view('admin.partialPages.sidebar.configuration.view', compact('configs'));
    }

     /**
     * Edit conguaration values.
     *
     * @return View view()
     */
    public function index()
    {
        $configs = Configuration::orderBy('type')->get();
        return view('admin.partialPages.sidebar.configuration.create', compact('configs'));
    }

    /**
     * Update conguaration values.
     *
     * @param Request $request
     * @return Redirect redirect()
     */
    public function update(Request $request)
    {
        try{
            DB::beginTransaction();

            $configs = Configuration::orderBy('type')->get();
            foreach($configs as $config){
                $name = "name".$config->id;
                $comment = "comment".$config->id;

                $saveName = $request->$name;
                if($config->type == ConfigurationEnum::ConfigBoolean){
                    if($request->$name == "on")
                    {
                        $saveName = true;
                    }else{
                        $saveName = false;
                    }
                }
                $config->update(['value' => $saveName , 'comment' => $request->$comment ]);
            }

            DB::commit();
            toastr()->success('Successfully updated configuration variables value.');
            return redirect('configuration-variable');
        } catch(Exception $e){
            DB::rollBack();
            toastr()->error($e->getMessage(),'Something Went Wrong!');
            return redirect()->back()->withErrors($e->getMessage(),'error');
        }
    }
}
