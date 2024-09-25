<?php

namespace Tests\Unit;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\QueryException;

class BookTest extends \Tests\TestCase
{
    /** @test */
    public function it_can_create_the_book()
    {
        $author = Author::factory()->create();
        $data = [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'publish_date' => $this->faker->date(),
            'author_id' => $author->id,
        ];

        $book = Book::create($data);

        $this->assertEquals($data['title'], $book->title);
        $this->assertEquals($data['description'], $book->description);
        $this->assertEquals($author->id, $book->author_id);
        //        $this->assertEquals($data['publish_date'], $book->getOriginal('publish_date'));
    }

    /** @test */
    public function it_can_delete_a_book()
    {
        $author = Author::factory()->create();
        $book = Book::factory()->create([
            'author_id' => $author->id,
        ]);

        $deleted = $book->delete();

        $this->assertTrue($deleted);
        $this->assertDatabaseMissing('books', ['title' => $book->title]);
    }

    /** @test */
    public function it_errors_when_updating_the_book()
    {
        $author = Author::factory()->create();
        $book = Book::factory()->create([
            'author_id' => $author->id,
        ]);
        $this->expectException(QueryException::class);

        $book->update(['title' => null]);
    }

    /** @test */
    public function it_can_update_the_book()
    {
        $author = Author::factory()->create();
        $book = Book::factory()->create([
            'author_id' => $author->id,
        ]);

        $update = ['title' => 'This title book'];
        $book->update($update);

        $this->assertEquals('This title book', $book->title);
    }

    /** @test */
    public function it_can_find_the_book()
    {
        $author = Author::factory()->create();
        $book = Book::factory()->create([
            'author_id' => $author->id,
        ]);

        $found = Book::find($book->id);

        $this->assertEquals($book->title, $found->title);
    }

    /** @test */
    public function it_can_list_all_books()
    {
        $author = Author::factory()->create();
        $book = Book::factory(2)->create([
            'author_id' => $author->id,
        ]);

        $this->assertCount(2, $book->all());
    }
}
