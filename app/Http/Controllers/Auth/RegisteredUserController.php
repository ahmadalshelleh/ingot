<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wallet;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    public $helpers;
    public $user;
    public $redis;
    function __construct() {
        $this->helpers = new Helpers();
        $this->user = new User();
        $this->redis = Redis::connection();
    }

    /**
     * Display the registration view.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        if(isset($request->query()['ref'])) {
            User::where('ref', $request->query()['ref'])->increment('num_ref_reg_visitors', 1);
            $this->user->removeUserCache($request->query()['ref']);
        }

        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'unique:users' ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5000'
        ]);

        $user_arr = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'image' => $this->helpers->uploadImage($request->image, 'users'),
            'ref' => $this->helpers->unique_id()
        ];

        if(isset($request->birthday))
            $user_arr['birthday'] = new Carbon($request->birthday);

        $user = User::create($user_arr);

        Wallet::create(['user_id' => $user->id]);

        if(isset($request->ref)) {
            $user->checkRefAndStore($user->id, $request->ref);
            $this->user->removeUserCache($request->ref);
            $this->redis->del('referrers_' . $request->ref);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
