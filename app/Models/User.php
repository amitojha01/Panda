<?php
namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'mobile',
        'role_id',
        'gender',
        'year',
        'month',
        'day',
        'graduation_year',
        'profile_type',
        'contact_email',
        'completed_step'
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

    /**
     * return user address
    */
    public function address()
    {
        return $this->hasMany(UserAddress::class);
    }
    /**
     * return user address
    */
    public function physicalInfo()
    {
        return $this->hasMany(UserPhysicalInformation::class);
    }
    public function colleges()
    {
        return $this->hasMany(UserCollege::class);
    }
    public function subscription()
    {
        return $this->hasMany(UserSubscription::class);
    }

    public function guardian()
    {
        return $this->hasMany(GuardianInformation::class);
    }

    /*public function recommendation()
    {
        return $this->hasMany(Recommendation::class);
    }*/
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
