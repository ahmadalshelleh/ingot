<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;

class TransactionController extends Controller
{
    public $category;
    public $wallet;
    public $redis;
    public function __construct()
    {
        $this->category = new Category();
        $this->wallet = new Wallet();
        $this->redis = Redis::connection();
    }

    public function create(Request $request)
    {
        if($request->cat_type == "create")
            $cat_id = $this->category->createOrGetID($request->cat);
        else
            $cat_id = $request->cat_option;

        if(!$this->wallet->walletCalculator($request->transaction, $request->total))
            return Redirect::back()->withErrors("Outcome larger than balance");

         Transaction::create([
           'user_id' => Auth::user()->id,
            'category_id' => $cat_id,
            'type' => $request->transaction,
            'total' => $request->total
        ]);

         $this->redis->del("transactions_user_" . Auth::user()->id);

         return redirect('/dashboard');

    }
}
