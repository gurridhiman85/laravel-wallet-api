<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'wallet'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

     /**
     * UpdateUser function use for updating  data according to where condition
     * @param array $updateData
     * @param array $where
     * @return boolean
     * @since 
     * @author 
     */
    public static function UpdateUser($userField, array $where)
    {
        try {
            $result = User::where($where)->update($userField);
            return $result;
        } catch (\Exception $e) {
            return $e->errorInfo;
        }
    }

      /**
     * @param array $Id
     * @return boolean
     * @since 
     * @author 
     */
    public static function getUserById($userId)
    {
        $result = User::where("id", $userId)->first();
        return $result;
    }

}
