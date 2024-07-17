<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_page_category_can_be_access(): void
    {
        $response = $this->get('/category');

        $response->assertStatus(200);
    }

    public function test_page_category_return_is_valid()
    {
        $response = $this->get('/category');

        $response->assertSee('kategori');
    }
}
