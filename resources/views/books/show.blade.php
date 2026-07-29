<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ver Libro</title>
</head>
<body>
    <h1>{{ $book->title }}</h1>

    <p><strong>Autor:</strong> {{ optional($book->writer)->name ?? $book->author }}</p>
    <p><strong>Género:</strong> {{ optional($book->genre)->name }}</p>
    <p><strong>ISBN:</strong> {{ $book->isbn }}</p>
    <p><strong>Año:</strong> {{ $book->published_year }}</p>
    <p><strong>Descripción:</strong></p>
    <p>{{ $book->description }}</p>

    <p>
        <a href="{{ route('books.edit', $book) }}">Editar</a> |
        <a href="{{ route('books.index') }}">Volver a la lista</a>
    </p>
</body>
</html>
