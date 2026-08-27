<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookApiController extends Controller
{
    public function index()
    {
        return Book::with(['writer', 'genre'])->orderBy('id', 'desc')->paginate(10);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'nullable|exists:authors,id',
            'author_name' => 'nullable|string|max:255',
            'genre_id' => 'nullable|exists:genres,id',
            'genre_name' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:50',
            'published_year' => 'nullable|integer',
            'description' => 'nullable|string',
        ]);

        $authorId = $data['author_id'] ?? null;
        if (empty($authorId) && !empty($data['author_name'])) {
            $author = Author::firstOrCreate(['name' => $data['author_name']]);
            $authorId = $author->id;
        }

        $genreId = $data['genre_id'] ?? null;
        if (empty($genreId) && !empty($data['genre_name'])) {
            $genre = Genre::firstOrCreate(['name' => $data['genre_name']]);
            $genreId = $genre->id;
        }

        $book = Book::create([
            'title' => $data['title'],
            'author' => $data['author_name'] ?? null,
            'author_id' => $authorId,
            'genre_id' => $genreId,
            'isbn' => $data['isbn'] ?? null,
            'published_year' => $data['published_year'] ?? null,
            'description' => $data['description'] ?? null,
        ]);

        return response()->json($book->load(['writer', 'genre']), 201);
    }

    public function show(Book $book)
    {
        return response()->json($book->load(['writer', 'genre']));
    }

    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'nullable|exists:authors,id',
            'author_name' => 'nullable|string|max:255',
            'genre_id' => 'nullable|exists:genres,id',
            'genre_name' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:50',
            'published_year' => 'nullable|integer',
            'description' => 'nullable|string',
        ]);

        $authorId = $data['author_id'] ?? null;
        if (empty($authorId) && !empty($data['author_name'])) {
            $author = Author::firstOrCreate(['name' => $data['author_name']]);
            $authorId = $author->id;
        }

        $genreId = $data['genre_id'] ?? null;
        if (empty($genreId) && !empty($data['genre_name'])) {
            $genre = Genre::firstOrCreate(['name' => $data['genre_name']]);
            $genreId = $genre->id;
        }

        $book->update([
            'title' => $data['title'],
            'author' => $data['author_name'] ?? $book->author,
            'author_id' => $authorId,
            'genre_id' => $genreId,
            'isbn' => $data['isbn'] ?? null,
            'published_year' => $data['published_year'] ?? null,
            'description' => $data['description'] ?? null,
        ]);

        return response()->json($book->load(['writer', 'genre']));
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json(['message' => 'Libro eliminado correctamente.']);
    }
}
