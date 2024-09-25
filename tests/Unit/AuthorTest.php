<?php

namespace Tests\Unit;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;

class AuthorTest extends \Tests\TestCase
{
    /** @test */
    public function it_can_list_books()
    {
        $author = Author::factory()->create();

        $aBook = Book::factory()->create([
            'author_id' => $author->id,
        ]);

        $books = $author->books;

        $this->assertInstanceOf(Collection::class, $books);

        $books->each(function ($book) use ($aBook) {
            $this->assertEquals($book->author, $aBook->author);
        });

    }

    /** @test */
    public function it_can_create_the_authors()
    {
        $data = [
            'name' => $this->faker->name(),
            'bio' => $this->faker->text(),
            'birth_date' => '1990-01-01',
        ];

        $author = Author::create($data);

        $this->assertEquals($data['name'], $author->name);
        $this->assertEquals($data['bio'], $author->bio);
        $this->assertEquals($data['birth_date'], $author->birth_date->format('Y-m-d'));
    }

    /** @test */
    public function it_can_delete_a_author()
    {
        $author = Author::factory()->create();

        $deleted = $author->delete();

        $this->assertTrue($deleted);
        $this->assertDatabaseMissing('authors', ['name' => $author->name]);
    }

    /** @test */
    public function it_errors_when_updating_the_author()
    {
        $author = Author::factory()->create();
        $this->expectException(QueryException::class);

        $author->update(['name' => null]);
    }

    /** @test */
    public function it_can_update_the_author()
    {
        $author = Author::factory()->create();

        $update = ['name' => 'Nur Wachid'];
        $author->update($update);

        $this->assertEquals('Nur Wachid', $author->name);
    }

    /** @test */
    public function it_can_find_the_author()
    {
        $author = Author::factory()->create();

        $found = Author::find($author->id);

        $this->assertEquals($author->name, $found->name);
    }

    /** @test */
    public function it_can_list_all_authors()
    {
        $author = Author::factory(2)->create();

        $this->assertCount(2, $author->all());
    }
}
