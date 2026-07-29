<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Libros</title>
</head>
<body>
    <h1>Libros</h1>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <p><a href="{{ route('books.create') }}">Crear libro</a></p>

    @if($books->count())
        <table border="1" cellpadding="6" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Año</th>
                    <th>Género</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            @foreach($books as $book)
                <tr>
                    <td>{{ $book->id }}</td>
                    <td>{{ $book->title }}</td>
                    <td>{{ optional($book->writer)->name ?? $book->author }}</td>
                    <td>{{ $book->published_year }}</td>
                    <td>{{ optional($book->genre)->name }}</td>
                    <td>
                        <a href="{{ route('books.show', $book) }}">Ver</a> |
                        <a href="{{ route('books.edit', $book) }}">Editar</a> |
                        <form action="{{ route('books.destroy', $book) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Eliminar libro?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $books->links() }}
    @else
        <p>No hay libros registrados.</p>
    @endif

    <p><a href="/">Volver al inicio</a></p>
</body>
</html>
