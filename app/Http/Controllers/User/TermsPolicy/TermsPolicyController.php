<?php

namespace App\Http\Controllers\User\TermsPolicy;

use Exception;
use App\Models\PrivacyPolicy;
use App\Models\TermsCondition;
use App\Services\ErrorLogService;
use App\Http\Controllers\Controller;

class TermsPolicyController extends Controller
{
    /**
     * Show the Terms & Condition Page
     *
     * @return void
     */
    public function termsAndCondition()
    {
        try {
            $termAndCondition = TermsCondition::first();
            if (isset($termAndCondition)) {
                $description= $termAndCondition->description;
            } else {
                $description= 'We are currently working on adding the terms And Conditions content. Please check back later.';
            }
            return view('user.termsCondition.termsAndCondition', compact('description'));
        } catch (Exception $e) {
            ErrorLogService::errorLog($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the Privacy Policy Page
     *
     * @return void
     */
    public function privacyPolicy()
    {
        try {
            $privacyPolicy = PrivacyPolicy::first();
            if (isset($privacyPolicy)) {
                $description= $privacyPolicy->description;
            }else{
                $description= 'We are currently working on adding the privacy policy content. Please check back later.';
            }
            return view('user.termsCondition.privacyPolicy', compact('description'));
        } catch (Exception $e) {
            ErrorLogService::errorLog($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
