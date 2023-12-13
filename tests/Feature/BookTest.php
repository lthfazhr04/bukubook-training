<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use Illuminate\Http\UploadedFile;

class BookTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_book_can_be_created(): void
    {
        $email = 'aditya@brainmatics.com';
        $pass  = 'secret';
        $user = User::create([
            'name'  => 'aditya',
            'email' => $email,
            'password' => bcrypt($pass),
            'roles' => 'ADMIN'
        ]);

        auth()->login($user);
        $this->assertAuthenticated();

        $response = $this->get('/book/create');
        $response->assertStatus(200);

        $response = $this->post(route('book.store'), [
            'title' => 'Software Testing',
            'description' => 'Fundamentals',
            'year' => '2023',
            'category' => ['technology'],
            'cover' => UploadedFile::fake()->image('book.jpg'),
        ]);

        $this->assertDatabaseHas('books', [
            'title' => 'Software Testing'
        ]);

        $response->assertRedirect(route('book.index'));

        $response = $this->get(route('book.index'));
        $response->assertSee('Book added succesfully');
    }
}
