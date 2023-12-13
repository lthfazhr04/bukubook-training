<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_registered_user_can_login(): void
    {
        $response = $this->get('/login');
        $response->assertOk();

        //buat user baru ke database
        $user = User::create([
            'name' => 'Aditya Prayoga',
            'email' => 'aditya@brainmatics.com',
            'password' => bcrypt('strongpassword'),
            'roles'  => 'ADMIN'
        ]);
        $this->assertTrue($user->exists());

        //hit ke url /login dengan method post
        $response = $this->post('/login', [
            'email' => 'aditya@brainmatics.com',
            'password' => 'strongpassword'
        ]);
        //assertAuthenticated
        $this->assertAuthenticated();

        //assertRedirect('/home')
        $response->assertRedirect('/home');

        //assertSeeText('Welcome')
        $response = $this->get('/home');

        $response->assertSeeText('User');
    }
}
