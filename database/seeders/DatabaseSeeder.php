<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Author::factory(10)->create()->each(function ($author) {
            $author->books()->saveMany(Book::factory(3)->make());
        });
    }
}
