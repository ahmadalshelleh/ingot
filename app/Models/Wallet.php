<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'balance'
    ];

    public function walletCalculator($transaction, $total)
    {
        $wallet = self::where('user_id', Auth::user()->id)->first();
        if($transaction === Transaction::INCOME){
            $wallet->balance+=$total;
            return $wallet->save();
        } else if($transaction === Transaction::OUTCOME && (($wallet->balance - $total) >= 0)){
            $wallet->balance-=$total;
            return $wallet->save();
        }
        return false;
    }

    public function getBalance()
    {
        return self::select('balance')->where('user_id', Auth::user()->id)->first();
    }
}
