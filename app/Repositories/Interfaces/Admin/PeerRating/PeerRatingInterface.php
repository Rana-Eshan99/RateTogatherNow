<?php

namespace App\Repositories\Interfaces\Admin\PeerRating;

interface PeerRatingInterface
{
    public function show($id);
    public function approve($id);
    public function reject($id);
}