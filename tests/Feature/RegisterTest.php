<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_registration_form_can_be_accessed(): void
    {
        //akses url /register
        $response = $this->get('/register');
        $response->assertOk();
    }

    public function test_new_users_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'Aditya Prayoga',
            'email' => 'aditya@brainmatics.com',
            'password' => 'strongpassword',
            'password_confirmation' => 'strongpassword'
        ]);
        //check user sudah ada di database
        $user = User::where('email', 'aditya@brainmatics.com')->first();
        $this->assertTrue($user->exists());
        //berhasil authentikasi
        $this->assertAuthenticated();  //berhasil logins

        //postcondition diarahkan ke /home
        $response->assertRedirect('/home');
    }

    //test existing email
    public function test_existed_email_cannot_register()
    {
        //check user sudah ada di database
        $user = User::create([
            'name' => 'Aditya Prayoga',
            'email' => 'aditya@brainmatics.com',
            'password' => bcrypt('strongpassword'),
        ]);
        $this->assertTrue($user->exists());

        //register lagi dengan email sama
        $response = $this->post('/register', [
            'name' => 'Aditya Prayoga',
            'email' => 'aditya@brainmatics.com',
            'password' => 'strongpassword',
            'password_confirmation' => 'strongpassword'
        ]);
        //harus ada alert email sudah digunakan
        $response->assertInvalid([
            'email' => 'The email has already been taken.'
        ]);
        //kembali lagi ke halaman awal
        $response->assertRedirect('/');
    }

    /** @test */
    public function user_invalid_register_when_only_fill_username()
    {
        $response = $this->post('/register', [
            'name' => 'Aditya Prayoga',
        ]);

        $response->assertInvalid();
    }
}
