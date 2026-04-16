<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Models\TermsCondition;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\TermsConditionInterface;
use App\Http\Requests\Admin\TermsCondion\TermsConditionRequest;

class TermsConditionController extends Controller
{
    private $termConditionRepo;

    public function __construct(TermsConditionInterface $termConditionRepo)
    {
        $this->termConditionRepo = $termConditionRepo;
    }

    /**
     * Show the terms & condition index.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $termsCondition = TermsCondition::find($request->query('id'));
        return view('dashboard.termsCondition.index', ['termsCondition' => $termsCondition]);
    }

     /**
     * Store the terms & condition.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(TermsConditionRequest $request)
    {
        try {
            $this->termConditionRepo->createTerms($request->all());

            $redirectUrl = route('term-condition.view');

            return response()->json(['success' => true, 'message' => 'Terms and condition has been created successfully!', 'redirectUrl' => $redirectUrl]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Show the terms & condition view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function view()
    {
        $termsCondition = TermsCondition::first();
        return view('dashboard.termsCondition.view', compact('termsCondition'));
    }
}
