<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const USER_ROLE = "user";
    public const ADMIN_ROLE = "admin";

    public $redis;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'image',
        'ref',
        'password',
        'birthday',
        'num_ref_reg_visitors',
        'num_ref_reg_users'
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

    public function __construct(array $attributes = [])
    {
        $this->redis = Redis::connection();
        parent::__construct($attributes);
    }

    public function checkRefAndStore($user_id, $ref)
    {
        if($user = self::where('ref', $ref)->first()) {
            $user->num_ref_reg_users += 1;
            $user->save();

            UserReferrer::create([
                'user_id' => $user_id,
                'referrer' => $ref
            ]);
        }
    }

    public function removeUserCache($ref)
    {
        if(isset($ref)){
            $user = self::select('id')->where('ref', $ref)->first();
            if(!$user)
                return ;
        }

        $user_id = $user ? $user->id : Auth::user()->id;

        $this->redis->del("user_". $user_id);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'user_id', 'id');
    }

}
