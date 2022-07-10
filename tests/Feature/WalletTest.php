<?php

namespace Tests\Feature;

use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class WalletTest extends TestCase
{
    /**
     * A basic feature test create wallet.
     *
     * @return void
     */
    public function test_create_wallet()
    {
        Wallet::create([
            'user_id' => 0,
            'balance' => 100
        ]);

        $this->assertTrue(true);
    }

    /**
     * A basic feature test check outcome with balance.
     *
     * @return void
     */
    public function test_check_outcome_with_balance()
    {
        $wallet = Wallet::where('user_id', 0)->first();

        if(($wallet->balance - 100) >= 0)
            $this->assertTrue(true);
        else
            $this->assertTrue(false);
    }
}
