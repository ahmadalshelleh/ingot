<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    /**
     * A basic feature test create transaction.
     *
     * @return void
     */
    public function test_create_transaction()
    {
         Transaction::create([
            'user_id' => 0,
            'category_id' => 1,
            'type' => "income",
            'total' => 100
        ]);

        $this->assertTrue(true);
    }

    /**
     * A basic feature test check user transaction exists.
     *
     * @return void
     */
    public function test_check_user_transaction_exists()
    {
        $this->assertDatabaseHas('transactions', [
            'user_id' => 0
        ]);
    }
}
