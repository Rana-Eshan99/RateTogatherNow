<?php

namespace App\Models;

use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peer extends Model
{
    use HasFactory, SoftDeletes;
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
        'userId',
        'organizationId',
        'departmentId',
        'firstName',
        'lastName',
        'gender',
        'ethnicity',
        'jobTitle',
        'image',
        'status'
    ];

    public function getDateFormat()
    {
        return 'U';
    }

    /**
     * Get the user that the peer belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    /**
     * Get the organization that the peer is associated with.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organizationId', 'id');
    }

    /**
     * Get the helpful entries related to the peer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function helpful(): HasMany
    {
        return $this->hasMany(Helpful::class, 'peerId', 'id');
    }

    /**
     * Get the report entries related to the peer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function report(): HasMany
    {
        return $this->hasMany(ReportRating::class, 'peerId', 'id');
    }


    /**
     * Get the ratings associated with the peer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ratings(): HasMany
    {
        return $this->hasMany(PeerRating::class, 'peerId', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'departmentId', 'id');
    }


    /**
     * Get the full name of the peer.
     *
     * @return string
     */
    public function getPeerFullNameAttribute()
    {
        return trim("{$this->firstName} {$this->lastName}");
    }

    /**
     * Get the initials of the peer.
     *
     * @return string
     */
    public function getPeerInitialsAttribute()
    {
        $firstInitial = isset($this->firstName) ? strtoupper(substr($this->firstName, 0, 1)) : '';
        $lastInitial = isset($this->lastName) ? strtoupper(substr($this->lastName, 0, 1)) : '';
        return $firstInitial . $lastInitial;
    }
}
