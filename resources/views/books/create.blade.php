<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Crear Libro</title>
</head>
<body>
    <h1>Crear Libro</h1>

    @if($errors->any())
        <ul style="color:red">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('books.store') }}" method="POST">
        @csrf
        <p>
            <label>Título<br>
                <input type="text" name="title" value="{{ old('title') }}">
            </label>
        </p>
        <p>
            <label>Autor<br>
                <select name="author_id">
                    <option value="">-- seleccionar --</option>
                    @foreach($authors as $author)
                        <option value="{{ $author->id }}" {{ old('author_id') == $author->id ? 'selected' : '' }}>{{ $author->name }}</option>
                    @endforeach
                </select>
                <br>
                <small>O crear nuevo: <input type="text" name="author_name" value="{{ old('author_name') }}"></small>
            </label>
        </p>
        <p>
            <label>Género<br>
                <select name="genre_id">
                    <option value="">-- seleccionar --</option>
                    @foreach($genres as $genre)
                        <option value="{{ $genre->id }}" {{ old('genre_id') == $genre->id ? 'selected' : '' }}>{{ $genre->name }}</option>
                    @endforeach
                </select>
                <br>
                <small>O crear nuevo: <input type="text" name="genre_name" value="{{ old('genre_name') }}"></small>
            </label>
        </p>
        <p>
            <label>ISBN<br>
                <input type="text" name="isbn" value="{{ old('isbn') }}">
            </label>
        </p>
        <p>
            <label>Año publicado<br>
                <input type="number" name="published_year" value="{{ old('published_year') }}">
            </label>
        </p>
        <p>
            <label>Descripción<br>
                <textarea name="description">{{ old('description') }}</textarea>
            </label>
        </p>

        <p>
            <button type="submit">Guardar</button>
            <a href="{{ route('books.index') }}">Cancelar</a>
        </p>
    </form>
</body>
</html>
