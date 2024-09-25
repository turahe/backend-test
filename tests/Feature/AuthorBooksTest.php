<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AuthorBooksTest extends TestCase
{
    #[Test]
    public function it_can_list_all_the_authors_books()
    {
        $author = Author::factory()->create();
        Book::factory(10)->create([
            'author_id' => $author->id,
        ]);

        $response = $this->get(route('authors.books', $author->id));
        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->hasAll(['data'])
                ->missingAll(['message', 'code'])
            );
    }
}
