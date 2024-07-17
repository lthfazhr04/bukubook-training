<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class CategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_page_category_can_be_access(): void
    {
        //login
        $admin = User::where('email','admin@bukubook.com')->first();

        $response = $this->actingAs($admin)->get('/category');

        $response->assertStatus(200);
    }

    public function test_page_category_return_is_valid()
    {
        //login
        $admin = User::where('email','admin@bukubook.com')->first();

        $response = $this->actingAs($admin)->get('/category');

        $response->assertSee('Category');
    }
}
