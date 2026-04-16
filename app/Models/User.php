<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable,HasApiTokens, HasRoles;
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
        'firstName', 'lastName',
        'email',
        'password',
        'organizationId', 'departmentId',
        'jobTitle', 'image',
        'status', 'gmailId', 'appleId',
        'organizationName', 'departmentName',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getDateFormat()
    {
        return 'U';
    }

    /**
     * Get the organizations that are associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function organization(): HasMany
    {
        return $this->hasMany(Organization::class, 'userId', 'id');
    }

    /**
     * Get the peers associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function peers(): HasMany
    {
        return $this->hasMany(Peer::class, 'userId', 'id');
    }

    /**
     * Get the organization ratings created by the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function organizationRatings(): HasMany
    {
        return $this->hasMany(OrganizationRating::class, 'userId', 'id');
    }

    /**
     * Get the peer ratings created by the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function peerRatings(): HasMany
    {
        return $this->hasMany(PeerRating::class, 'userId', 'id');
    }

    /**
     * Get the application feedback given by the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function applicationFeedback(): HasMany
    {
        return $this->hasMany(ApplicationFeedback::class, 'userId', 'id');
    }

    /**
     * Get the helpful feedback entries associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function helpful(): HasMany
    {
        return $this->hasMany(Helpful::class, 'userId', 'id');
    }

    /**
     * Get the reports created by the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reports(): HasMany
    {
        return $this->hasMany(ReportRating::class, 'userId', 'id');
    }

    /**
     * Get the saved peers for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function savedPeers(): HasMany
    {
        return $this->hasMany(Saved::class, 'userId', 'id')
                    ->whereNotNull('peerId');
    }

    /**
     * Get the saved organizations for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function savedOrganizations(): HasMany
    {
        return $this->hasMany(Saved::class, 'userId', 'id')
                    ->whereNotNull('organizationId');
    }

    public function getAvatarFullUrlAttribute()
    {
        return is_null($this->attributes['image']) ? asset('img/default-avatar.png')
         : Storage::disk('s3')->url($this->attributes['image']);
    }

    public function getFullNameAttribute()
    {
        return $this->attributes['firstName'] . ' ' . $this->attributes['lastName'];
    }

    //initialize the user's organization
    public function getUserInitialsAttribute(){
        return strtoupper(substr($this->attributes['firstName'], 0, 1) . substr($this->attributes['lastName'], 0, 1));
    }
}
