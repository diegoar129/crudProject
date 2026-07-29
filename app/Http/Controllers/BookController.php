<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::orderBy('id', 'desc')->paginate(10);
        return view('books.index', compact('books'));
    }

    public function create()
    {
        $authors = Author::orderBy('name')->get();
        $genres = Genre::orderBy('name')->get();
        return view('books.create', compact('authors', 'genres'));
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

        // Resolve or create author
        $authorId = $data['author_id'] ?? null;
        if (empty($authorId) && !empty($data['author_name'])) {
            $author = Author::firstOrCreate(['name' => $data['author_name']]);
            $authorId = $author->id;
        }

        // Resolve or create genre
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

        return redirect()->route('books.index')->with('success', 'Libro creado correctamente.');
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $authors = Author::orderBy('name')->get();
        $genres = Genre::orderBy('name')->get();
        return view('books.edit', compact('book', 'authors', 'genres'));
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

        // Resolve or create author
        $authorId = $data['author_id'] ?? null;
        if (empty($authorId) && !empty($data['author_name'])) {
            $author = Author::firstOrCreate(['name' => $data['author_name']]);
            $authorId = $author->id;
        }

        // Resolve or create genre
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

        return redirect()->route('books.index')->with('success', 'Libro actualizado correctamente.');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Libro eliminado.');
    }
}
