<?php

namespace App\Repositories\Repositories\Admin\Feedback;

use App\Models\ApplicationFeedback;
use App\Repositories\Interfaces\Admin\Feedback\FeedbackInterface;

class FeedbackRepository implements FeedbackInterface
{


    public function show($id)
    {
        return ApplicationFeedback::find($id);
    }
}