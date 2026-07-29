<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Author;
use App\Models\Genre;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'author_id',
        'isbn',
        'published_year',
        'description',
        'genre_id',
    ];

    public function writer()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
}
