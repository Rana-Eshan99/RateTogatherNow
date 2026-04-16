<?php

namespace App\Repositories\Interfaces\User\Peer;

interface PeerInterface
{
    /**
     * Get All Approved Peers
     *
     * @return void
     */
    public function getPeers();

    /**
     * Get Approved Peer by peerId
     *
     * @param [type] $peerId
     * @return void
     */
    public function getPeer($peerId);

    /**
     * Get status Peer is saved or not.
     *
     * @param [type] $peerId
     * @return boolean
     */
    public function isSavedPeer($peerId);

    /**
     * Saved the peer in User Profile
     *
     * @param [type] $peerId
     * @return void
     */
    public function savedPeer($peerId);

    /**
     * Get over all peer rating by peerId
     *
     * @param mixed $peerId
     * @param mixed|null $workAgainVariable
     * @return void
     */
    public function getOverAllPeerRating($peerId, $workAgainVariable = false);

    /**
     * Get User's All Saveds Peers
     *
     * @return void
     */
    public function getUserSavedsPeers();

    /**
     * Get User's All Saveds Peers by Name and Job Title
     *
     * @param [type] $peerName_jobTitle
     * @return void
     */
    public function getUserSavedsPeersByName($peerName_jobTitle);

    /**
     * Get Peer Rating Given by the Logged-in user
     *
     * @return void
     */
    public function getUserRatedPeers();

    /**
     * Get User's peer-Rating by using like operator from peer first name or last Name  or jobTitle
     *
     * @param [type] $peerName_jobTitle
     * @return void
     */
    public function getUserRatedPeersByName($peerName_jobTitle);

    /**
     * Create Peer
     *
     * @param array $data
     * @return void
     */
    public function createPeer(array $data);

    /**
     * Get Peer Rating  by User (Using peerId and userId)
     *
     * @param [type] $peerId
     * @return void
     */
    public function getPeerRating($peerId, $edit, $ratingId);

    /**
     * Rate the Peer (Save or Update the rating)
     *
     * @param array $data
     * @return void
     */
    public function ratePeer(array $data);

    /**
     * Get Peer data to Compare Peer with each other
     *
     * @param [type] $peerId
     * @return void
     */
    public function comparePeer($peerId);

    /**
     * Get all approved Peer List with Rating also get All Approved Peer List of the Given Organization
     *
     * @param string $organizationId
     * @return void
     */
    public function getPeerList($organizationId = null);

    /**
     * Get all approved Peer List with Rating by using the given queryToSearch
     *
     * @param [type] $queryToSearch
     * @return void
     */
    public function getPeerListByQuery($queryToSearch);

    /**
     * * Get Peer By Id (Peer Details)
     *
     * @param [type] $id
     * @param [type] $request
     * @return void
     */
    public function getPeerByIdDetail($id, $request);

    /**
     * Get the Peer Rating with Report_Rating and Helpful
     *
     * @param [type] $peerId
     * @return void
     */
    public function getPeerRating_Report_Helpful($peerId);

    /**
     * Get All Approved Peers by Id
     * @param [type] $peerId
     *
     */
    public function getPeersById($peerId);
}


