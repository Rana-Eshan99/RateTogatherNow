<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Helpful extends Model
{
    use HasFactory;
    protected $table = 'helpful';

    protected $dateFormat = 'U';
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'userId',
        'organizationId',
        'peerId',
        'organizationRatingId',
        'peerRatingId',
        'isFoundHelpful',
        'deviceIdentifier',
    ];

    public function getDateFormat()
    {
        return 'U';
    }

    /**
     * Get the user who provided the helpful feedback.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    /**
     * Get the peer related to the helpful entry, if any.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function peer(): BelongsTo
    {
        return $this->belongsTo(Peer::class, 'peerId', 'id');
    }

    /**
     * Get the organization related to the helpful entry, if any.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organizationId', 'id');
    }

    /**
     * Get the peer rating that this helpful feedback is associated with.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function peerRating(): BelongsTo
    {
        return $this->belongsTo(PeerRating::class, 'peerRatingId', 'id');
    }

    /**
     * Get the organization rating that this helpful feedback is associated with.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organizationRating(): BelongsTo
    {
        return $this->belongsTo(OrganizationRating::class, 'organizationRatingId', 'id');
    }

}
