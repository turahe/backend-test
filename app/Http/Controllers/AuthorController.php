<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\BookResource;
use App\Models\Author;
use Illuminate\Support\Facades\Cache;

/**
 * @group Authors
 */
class AuthorController extends Controller
{
    /**
     * list Authors.
     *
     * @apiResourceCollection App\Http\Resources\AuthorResource
     *
     * @apiResourceModel App\Models\Author
     */
    public function index()
    {
        $authors = Cache::remember('authors', 60, function () {
            return Author::paginate(12);
        });

        return AuthorResource::collection($authors);
    }

    /**
     * Store a author.
     *
     * @apiResource App\Http\Resources\AuthorResource
     *
     * @apiResourceModel App\Models\Author
     */
    public function store(AuthorRequest $request)
    {
        return new AuthorResource(Author::create($request->all()));

    }

    /**
     * Display author.
     *
     * @apiResource App\Http\Resources\AuthorResource
     *
     * @apiResourceModel App\Models\Author
     *
     * @response status=404 scenario="author not found" {"message": "Author not found"}
     */
    public function show(int $id)
    {
        return new AuthorResource(Author::find($id));
    }

    /**
     * Update author in storage.
     *
     * @apiResource App\Http\Resources\AuthorResource
     *
     * @apiResourceModel App\Models\Author
     *
     * @response status=404 scenario="author not found" {"message": "Author not found"}
     */
    public function update(AuthorRequest $request, int $id)
    {
        $author = Author::find($id);
        $author->update($request->all());

        return new AuthorResource($author);
    }

    /**
     * Remove author from storage.
     *
     * @apiResource App\Http\Resources\AuthorResource
     *
     * @apiResourceModel App\Models\Author
     *
     * @response status=404 scenario="author not found" {"message": "Author not found"}
     */
    public function destroy(int $id)
    {
        Author::destroy($id);

        return response()->noContent();
    }

    /**
     * Authors has books
     *
     * @response status=404 scenario="author not found" {"message": "Author not found"}
     *
     * @apiResourceCollection App\Http\Resources\BookResource
     *
     * @apiResourceModel App\Models\Book
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function books(int $id)
    {
        $author = Author::findOrFail($id);

        return BookResource::collection($author->books);

    }
}
