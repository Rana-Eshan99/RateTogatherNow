<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrganizationRating extends Model
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
        'userId', 'organizationId',
        'employeeHappyness', 'companyCulture', 'careerDevelopment', 'workLifeBalance', 'compensationBenefit',
        'jobStability', 'workplaceDEI', 'companyReputation', 'workplaceSS', 'growthFuturePlan',
        'experience','status', 'deviceIdentifier'
    ];

    public function getDateFormat()
    {
        return 'U';
    }

    /**
     * Get the user that the organization rating belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    public function employeeHappyness()
    {
        return $this->belongsTo(OrganizationRating::class, 'organizationId', 'id');
    }
    /**
     * Get the organization that the rating is associated with.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organizationId', 'id');
    }

    /**
     * Get the helpful feedbacks associated with the organization rating.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function helpful(): HasMany
    {
        return $this->hasMany(Helpful::class, 'organizationRatingId', 'id');
    }

    /**
     * Get the reports associated with the organization rating.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reports(): HasMany
    {
        return $this->hasMany(ReportRating::class, 'organizationRatingId', 'id');
    }
}
