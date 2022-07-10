<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserReferrer;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    public $user;
    public $user_referrer;
    public $transaction;
    public $wallet;
    public $redis;
    public function __construct()
    {
        $this->user = new User();
        $this->user_referrer = new UserReferrer();
        $this->transaction = new Transaction();
        $this->wallet = new Wallet();
        $this->redis = Redis::connection();
    }

    public function userIndex()
    {
        if(!$this->redis->exists("user_" . Auth::user()->id)) {
            $user =  User::find(Auth::user()->id);
            $this->redis->set("user_{$user->id}", json_encode($user, true), 'EX', 3600);
        }else {
            $user = json_decode($this->redis->get("user_" . Auth::user()->id));
        }

        $ref_url = env('APP_URL') . ":8000/register?ref=" .  $user->ref;

        if(!$this->redis->exists("categories")) {
            $categories = Category::all();
            $this->redis->set("categories", json_encode($categories, true), 'EX', 3600);
        }else {
            $categories = json_decode($this->redis->get("categories"));
        }

        $users_referrer = UserReferrer::select('user_id')->where('referrer', $user->ref)->with('user')->get();

        $referrer_days = $this->user_referrer->getLastFourteenDaysRef($user->ref);

        $total_transactions = $this->transaction->getTotalIncomeAndOutcome(Auth::user()->id) + ['total_balance' => $this->wallet->getBalance()->balance];

        return view('dashboard', [
            'ref_url' => $ref_url,
            'categories' => $categories,
            'users_referrer' => $users_referrer,
            'ref_visitors' => $user->num_ref_reg_visitors,
            'ref_users' => $user->num_ref_reg_users,
            'ref_days' => $referrer_days,
            'total_transactions' => $total_transactions
        ]);
    }

    public function adminIndex()
    {
        if($cached_users = json_decode($this->redis->exists("admin_users")))
            return view('admin_dashboard', ['users' => $cached_users]);


        $users = User::select('id', 'name', 'email', 'created_at', 'num_ref_reg_users')->where('role', User::USER_ROLE)->get();
        foreach ($users as $user){
            $total_transactions = $this->transaction->getTotalIncomeAndOutcome($user->id);
            $users_arr[] = (object)[
                'user_name' => $user->name,
                'user_email' => $user->email,
                'registered_date' => (new Carbon($user->created_at))->toDateString(),
                'ref_number' => $user->num_ref_reg_users,
                'total_balance' => $user->wallet->balance,
                'total_outcome' => $total_transactions['total_outcome'],
                'total_income' => $total_transactions['total_income']
            ];
        }

        $this->redis->set("admin_users", json_encode($users_arr, true), 'EX', 600);

        return view('admin_dashboard', ['users' => $users_arr]);
    }
}
