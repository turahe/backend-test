<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::apiResource('books', BookController::class);
Route::apiResource('authors', AuthorController::class);
Route::get('/authors/{id}/books', [AuthorController::class, 'books'])->name('authors.books');
