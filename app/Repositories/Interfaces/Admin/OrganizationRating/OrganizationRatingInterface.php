<?php

namespace App\Repositories\Interfaces\Admin\OrganizationRating;

interface OrganizationRatingInterface
{
    public function show($id);
    public function approve($id);
    public function reject($id);
}