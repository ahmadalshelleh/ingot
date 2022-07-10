<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class UserReferrer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'referrer'
    ];

    public $redis;

    public function __construct(array $attributes = [])
    {
        $this->redis = Redis::connection();
        parent::__construct($attributes);
    }

    public function getLastFourteenDaysRef($ref)
    {
        $days = [];
        if(!$this->redis->exists("referrers_" . $ref)) {
            $referrers = self::where('referrer', $ref)->get();
            $this->redis->set("referrers_" . $ref, json_encode($referrers, true), 'EX', 3600);
        }else{
            $referrers = json_decode($this->redis->get("referrers_" . $ref));
        }

        for($i = 13; $i >= 0; $i--)
            $days[] = ['day' => Carbon::now()->subDays($i)->toDateString(),'counter' => 0];


        foreach ($referrers as $referrer){
            if($key = array_search((new Carbon($referrer->created_at))->toDateString(), array_column($days, 'day')))
                $days[$key]['counter']++;
        }

        return $days;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
