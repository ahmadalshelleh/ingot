<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * A basic feature test create category.
     *
     * @return void
     */
    public function test_create_category()
    {
        Category::create([
            'name' => 'test'
        ]);

        $this->assertTrue(true);
    }

    /**
     * A basic feature test check if transaction exists.
     *
     * @return void
     */
    public function test_if_exists_transaction()
    {
        $this->assertDatabaseHas('categories', [
            'name' => 'test'
        ]);
    }
}
