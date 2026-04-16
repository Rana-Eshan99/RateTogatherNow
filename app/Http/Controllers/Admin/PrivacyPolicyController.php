<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Models\PrivacyPolicy;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\PrivacyPolicyInterface;
use App\Http\Requests\Admin\PrivacyPolicy\PrivacyPolicyRequest;

class PrivacyPolicyController extends Controller
{
    private $privacyPolicyRepo;

    public function __construct(PrivacyPolicyInterface $privacyPolicyRepo)
    {
        $this->privacyPolicyRepo = $privacyPolicyRepo;
    }

    /**
     * Show the Privacy Policy index.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $privacyPolicy = PrivacyPolicy::find($request->query('id'));
        return view('dashboard.privacyPolicy.index', ['privacyPolicy' => $privacyPolicy]);
    }


    /**
     * Store the Privacy Policy.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(PrivacyPolicyRequest $request)
    {
        try {
            $this->privacyPolicyRepo->createprivacyPolicy($request->all());

            $redirectUrl = route('privacy-policy.view');

            return response()->json(['success' => true, 'message' => 'Privacy policy has been created successfully!', 'redirectUrl' => $redirectUrl]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Show the Privacy Policy view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function view()
    {
        $privacyPolicy = PrivacyPolicy::first();
        return view('dashboard.privacyPolicy.view', compact('privacyPolicy'));
    }
}
