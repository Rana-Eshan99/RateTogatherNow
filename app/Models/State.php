<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class State extends Model
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
        'countryId',
        'name'
    ];

    public function getDateFormat()
    {
        return 'U';
    }

    /**
     * Get the organizations located in the state.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class, 'stateId', 'id');
    }

    /**
     * Get the Country located in the state.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'countryId', 'id');
    }
}
