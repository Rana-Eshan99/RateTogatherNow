<?php

namespace App\Http\Controllers\Admin\Dashboard;

use Exception;
use Illuminate\Http\Request;
use App\Models\ApplicationFeedback;
use App\Http\Controllers\Controller;
use App\DataTables\FeedbackDataTable;
use App\Repositories\Interfaces\Admin\Feedback\FeedbackInterface;

class FeedbackController extends Controller
{

    public function __construct(private FeedbackInterface $feedbackRepository) {}
    public function index(FeedbackDataTable $dataTable)
    {
        return $dataTable->render('dashboard.feedback.index', get_defined_vars());
    }
    public function show($id)
    {
        try {
            $feedback = $this->feedbackRepository->show($id);
            return response(['success' => true, 'data' => $feedback]);
        } catch (Exception $e) {
            return response(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}