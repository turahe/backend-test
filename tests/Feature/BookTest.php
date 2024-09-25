<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class BookTest extends TestCase
{
    /** @test */
    public function it_can_delete_the_book()
    {
        $author = Author::factory()->create();
        $book = Book::factory()->create([
            'author_id' => $author->id,
        ]);

        $this->delete(route('books.destroy', $book->id), [])
            ->assertStatus(204);
    }

    /** @test */
    public function it_can_update_the_book()
    {
        $author = Author::factory()->create();
        $book = Book::factory()->create([
            'author_id' => $author->id,
        ]);

        $data = [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'publish_date' => now()->format('Y-m-d'),
            'author_id' => $author->id,
        ];

        $this->put(route('books.update', $book->id), $data)
            ->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) => $json->has('data')
                    ->where('data.title', $data['title'])
                    ->where('data.description', $data['description'])
                    ->where('data.publish_date', $data['publish_date'])
                    ->where('data.author_id', $author->id)
            );

    }

    /** @test */
    public function it_can_find_the_author()
    {
        $author = Author::factory()->create();
        $book = Book::factory()->create([
            'author_id' => $author->id,
        ]);
        $this->get(route('books.show', $book->id))
            ->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) => $json->has('data')
                    ->where('data.title', $book->title)
                    ->where('data.description', $book->description)
                    ->where('data.publish_date', $book->publish_date->format('Y-m-d'))
                    ->where('data.author_id', $author->id)
            );
    }

    /** @test */
    public function it_can_create_the_book()
    {

        $author = Author::factory()->create();
        $data = [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'publish_date' => now()->format('Y-m-d'),
            'author_id' => $author->id,
        ];

        $this->post(route('books.store'), $data)
            ->assertStatus(201)
            ->assertJson(
                fn (AssertableJson $json) => $json->has('data')
                    ->where('data.title', $data['title'])
                    ->where('data.description', $data['description'])
                    ->where('data.publish_date', $data['publish_date'])
                    ->where('data.author_id', $author->id)
            );

    }

    /** @test */
    public function it_can_list_all_the_books()
    {
        $author = Author::factory()->create();
        Book::factory(3)->create([
            'author_id' => $author->id,
        ]);

        $response = $this->get(route('books.index'));
        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->hasAll(['links', 'meta', 'data'])
                ->missingAll(['message', 'code'])
            );
    }
}
