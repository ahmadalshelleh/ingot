<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class Transaction extends Model
{
    use HasFactory;

    public const INCOME = "income";
    public const OUTCOME = "outcome";

    public $redis;

    protected $fillable = [
        'user_id',
        'category_id',
        'type',
        'total'
    ];

    public function __construct(array $attributes = [])
    {
        $this->redis = Redis::connection();
        parent::__construct($attributes);
    }

    public function getTotalIncomeAndOutcome($user_id)
    {
        $total_income = 0;
        $total_outcome = 0;

        if (!$this->redis->exists("transactions_user_" . $user_id)) {
            $transactions = self::where('user_id', $user_id)->get();
            $this->redis->set("transactions_user_" . $user_id, json_encode($transactions, true), 'EX', 3600);
        } else {
            $transactions = json_decode($this->redis->get("transactions_user_" . $user_id));
        }
        foreach ($transactions as $transaction) {
            switch ($transaction->type) {
                case self::INCOME:
                    $total_income += $transaction->total;
                    break;
                case self::OUTCOME:
                    $total_outcome += $transaction->total;
                    break;
            }
        }

        return ['total_income' => $total_income, 'total_outcome' => $total_outcome];
    }
}
