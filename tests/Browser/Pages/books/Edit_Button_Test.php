<?php

namespace Tests\Feature;

use App\Model\Book;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class Edit_Button_Test extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        factory(Book::class, 12)->create();
        $this->visit('/admin/books')
            ->clicklink('.btn-edit-1')
            ->assertPathIs('/books/1/edit');
    }
}
