<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
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
        'name'
    ];
    public function getDateFormat()
    {
        return 'U';
    }

    /**
     * Get the organizations located in the country.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class, 'countryId', 'id');
    }

    /**
     * Get the States located in the country.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function states(): HasMany
    {
        return $this->hasMany(State::class, 'countryId', 'id');
    }
}
