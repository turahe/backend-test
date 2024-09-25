<?php

namespace Tests\Feature;

use App\Models\Author;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    /** @test */
    public function it_can_delete_the_author()
    {
        $author = Author::factory()->create();

        $this->delete(route('authors.destroy', $author->id), [])
            ->assertStatus(204);
    }

    /** @test */
    public function it_can_update_the_author()
    {
        $author = Author::factory()->create();

        $data = [
            'name' => 'Nur Wachid',
            'bio' => 'this bio',
            'birth_date' => '1990-01-01',
        ];

        $this->put(route('authors.update', $author->id), $data)
            ->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) => $json->has('data')
                    ->where('data.name', $data['name'])
                    ->where('data.bio', $data['bio'])
                    ->where('data.birth_date', $data['birth_date'])
            );
    }

    /** @test */
    public function it_can_list_all_the_authors()
    {
        Author::factory(3)->create();

        $this->get(route('authors.index'))
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->hasAll(['links', 'meta', 'data'])
                ->missingAll(['message', 'code'])
            );
    }

    /** @test */
    public function it_can_find_the_author()
    {
        $author = Author::factory()->create();
        $this->get(route('authors.show', $author->id))
            ->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) => $json->has('data')
                    ->where('data.name', $author->name)
                    ->where('data.bio', $author->bio)
                    ->where('data.birth_date', $author->birth_date->format('Y-m-d'))
            );
    }

    /** @test */
    public function it_can_create_the_author()
    {
        $data = [
            'name' => 'Nur Wachid',
            'bio' => 'this bio',
            'birth_date' => '1990-01-01',
        ];
        $this->post(route('authors.store'), $data)
            ->assertStatus(201)
            ->assertJson(
                fn (AssertableJson $json) => $json->has('data')
                    ->where('data.name', $data['name'])
                    ->where('data.bio', $data['bio'])
                    ->where('data.birth_date', $data['birth_date'])
            );
    }
}
