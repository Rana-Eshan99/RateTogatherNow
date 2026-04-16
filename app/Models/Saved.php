<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Saved extends Model
{
    use HasFactory;

    protected $dateFormat = 'U';
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
    const DELETED_AT = 'deletedAt';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'userId', 'organizationId', 'peerId'
    ];

    public function getDateFormat()
    {
        return 'U';
    }

    /**
     * Get the peer related to the saved entry.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function peer(): BelongsTo
    {
        return $this->belongsTo(Peer::class, 'peerId', 'id');
    }

    /**
     * Get the organization related to the saved entry.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organizationId', 'id');
    }
}
