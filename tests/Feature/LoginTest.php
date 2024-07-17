<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_accsess_login_page(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200); 

        $response->assertSee('Login');

        $response->assertSeeText('Email Address'); //true or false result

        $response->assertSeeText('Password');
    }

    public function test_user_can_login_to_the_app()
    {

        $response = $this->post('/login', [
        "email" => 'admin@bukubook.com' ,
        "password" => '4dm1n'
        ]);

        $this->assertAuthenticated(); //check sudah dapat session login
    
        $response->assertRedirect('/home'); //check dialihkan ke halaman home

        $resAccessCategory = $this->get('/category'); //coba akses ke halaman category

        $resAccessCategory->assertSee('Category'); //cek berhasil ke halamana category
    }      
}
