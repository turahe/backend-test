<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * @group Books
 */
class BookController extends Controller
{
    /**
     * Display a  books.
     *
     * @apiResourceCollection App\Http\Resources\BookResource
     *
     * @apiResourceModel App\Models\Book
     */
    public function index()
    {
        $books = Cache::remember('books', 60, function () {
            return Book::paginate(12);
        });

        return BookResource::collection($books);
    }

    /**
     * Store a newly created book.
     *
     * @apiResource App\Http\Resources\BookResource
     *
     * @apiResourceModel App\Models\Book
     */
    public function store(Request $request)
    {
        return new BookResource(Book::create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\BookResource
     *
     * @apiResourceModel App\Models\Book
     *
     * @response status=404 scenario="book not found" {"message": "Book not found"}
     */
    public function show(int $id)
    {
        return new BookResource(Book::findOrFail($id));
    }

    /**
     * Update the specified book.
     *
     * @apiResource App\Http\Resources\BookResource
     *
     * @apiResourceModel App\Models\Book
     *
     * @response status=404 scenario="book not found" {"message": "Book not found"}
     */
    public function update(BookRequest $request, int $id)
    {
        $book = Book::find($id);
        $book->update($request->all());

        return new BookResource($book);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @response status=404 scenario="book not found" {"message": "Book not found"}
     */
    public function destroy(int $id)
    {
        Book::destroy($id);

        return response()->noContent();
    }
}
