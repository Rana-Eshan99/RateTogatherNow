<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Organization extends Model
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
        'country',
        'state',
        'name',
        'image',
        'city',
        'address',
        'status',
        'latitude',
        'longitude',
    ];

    public function getDateFormat()
    {
        return 'U';
    }

    /**
     * Get the user that owns the organization.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    /**
     * Get the peers associated with the organization.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function peers(): HasMany
    {
        return $this->hasMany(Peer::class, 'organizationId', 'id');
    }

    /**
     * Get the ratings associated with the organization.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ratings(): HasMany
    {
        return $this->hasMany(OrganizationRating::class, 'organizationId', 'id');
    }

    public function employeeHappiness()
    {
        return $this->hasMany(OrganizationRating::class, 'organizationId', 'id');
    }
    /**
     * Get the departments associated with the organization.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function departments(): HasMany
    {
        return $this->hasMany(Department::class, 'organizationId', 'id');
    }

    /**
     * Get the country that the organization is located in.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'countryId', 'id');
    }

    /**
     * Get the state that the organization is located in.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'stateId', 'id');
    }

    /**
     * Get the helpful entries related to the organization.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function helpful(): HasMany
    {
        return $this->hasMany(Helpful::class, 'organizationId', 'id');
    }

    /**
     * Get the report entries related to the organization.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function report(): HasMany
    {
        return $this->hasMany(ReportRating::class, 'organizationId', 'id');
    }

    /*
     * Get the image Url of the organization
     *
     * @return void
     */
    public function getImageFullUrlAttribute()
    {
        return is_null($this->attributes['image']) ? asset('img/organizationDefaultAvatar.png')
            : Storage::disk('s3')->url($this->attributes['image']);
    }

}
