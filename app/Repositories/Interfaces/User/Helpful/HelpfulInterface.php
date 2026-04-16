<?php

namespace App\Repositories\Interfaces\User\Helpful;

interface HelpfulInterface{
    /**
     * Save or Update or Delete the Helpful record against the given organization rating id.
     *
     * @param array $data
     * @return void
     */
    public function saveHelpful_Organization(array $data);

    /**
     * Save or Update or Delete the Helpful record against the given peer rating id.
     *
     * @param array $data
     * @return void
     */
    public function saveHelpful_Peer(array $data);
}
