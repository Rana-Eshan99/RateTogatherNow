<?php

namespace App\Models;

use App\Models\Peer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
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
        'organizationId', 'name'
    ];

    public function getDateFormat()
    {
        return 'U';
    }

    /**
     * Get the organization that the department belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organizationId', 'id');
    }

    /**
     * Get the peers associated with the department.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function peers(): HasMany
    {
        return $this->hasMany(Peer::class, 'departmentId', 'id');
    }
}
