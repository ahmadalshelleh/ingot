<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class Category extends Model
{
    use HasFactory;

    public $redis;

    protected $fillable = [
        'name'
    ];

    public function __construct()
    {
        $this->redis = Redis::connection();
    }

    public function createOrGetID(String $name)
    {
        $category = self::where('name', $name)->first();
        if(!$category) {
            $this->redis->del("categories");
            $category = self::create([
                'name' => $name
            ]);
        }

        return $category->id;
    }
}
