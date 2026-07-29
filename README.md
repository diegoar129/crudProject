# CRUD Biblioteca

Resumen rápido
- Se agregó un CRUD básico para el registro de libros en la aplicación Laravel y se extendió para soportar entidades separadas de `Author` y `Genre` para consultas más sencillas.

Qué contiene
- Migraciones:
	- `database/migrations/2026_07_29_000000_create_books_table.php` — tabla `books` original.
	- `database/migrations/2026_07_29_000001_create_authors_table.php` — tabla `authors`.
	- `database/migrations/2026_07_29_000002_create_genres_table.php` — tabla `genres`.
	- `database/migrations/2026_07_29_000003_add_author_genre_to_books_table.php` — añade `author_id` y `genre_id` a `books` y claves foráneas.
- Modelos: `app/Models/Book.php`, `app/Models/Author.php`, `app/Models/Genre.php` (relaciones Eloquent: `Book->writer()` y `Book->genre()`).
- Controlador: `app/Http/Controllers/BookController.php` — ahora acepta `author_id`/`author_name` y `genre_id`/`genre_name`, y crea Author/Genre si se envía un nombre.
- Rutas: `Route::resource('books', BookController::class);` en `routes/web.php`.
- Vistas Blade: `resources/views/books/` contiene `index.blade.php`, `create.blade.php`, `edit.blade.php`, `show.blade.php` (formularios actualizados para seleccionar o crear autor/género).

Cómo probarlo (local)
1. Configura la base de datos en `.env`.
2. Ejecuta las migraciones:

```bash
php artisan migrate
```

3. Inicia el servidor de desarrollo:

```bash
php artisan serve
```

4. Abre en el navegador: `http://127.0.0.1:8000/books`.

Crear/editar libros
- En el formulario podrás seleccionar un `Autor` y un `Género` existentes o escribir un nombre para crear uno nuevo (campos `author_name` y `genre_name`).

Ejemplos de consultas útiles
- Obtener libros por autor (por id):

```php
use App\Models\Book;
$books = Book::where('author_id', $authorId)->get();
```

- Obtener libros por género (por id):

```php
$books = Book::where('genre_id', $genreId)->get();
```

- Usar la relación Eloquent para acceder al autor/genre:

```php
$book = Book::with('writer','genre')->find(1);
echo optional($book->writer)->name;
echo optional($book->genre)->name;
```

- Buscar libros por nombre del autor (Eloquent join):

```php
use App\Models\Book;
use App\Models\Author;

$books = Book::whereHas('writer', function($q) use ($name) {
		$q->where('name', 'like', "%$name%");
})->get();
```

Notas y limitaciones
- Se conserva el campo `author` (string) como fallback, pero la fuente canonical para consultas es `author_id` (relación `writer`).
- Las vistas son minimalistas; puedes añadir estilos (Bootstrap/Tailwind) si lo deseas.
- Validaciones básicas en el controlador; no hay autenticación/autorización por defecto.

Pistas para poblar datos de prueba

```bash
php artisan tinker
>>> \App\Models\Author::firstOrCreate(['name'=>'Gabriel García Márquez']);
>>> \App\Models\Genre::firstOrCreate(['name'=>'Ficción']);
>>> \App\Models\Book::create(['title'=>'Libro de prueba','author'=>'Gabriel García Márquez','author_id'=>1,'genre_id'=>1,'isbn'=>'123','published_year'=>2026,'description'=>'Descripción']);
```

Próximos pasos recomendados (opcional)
- Añadir filtros en la vista `index` para filtrar por `author_id` y `genre_id`.
- Migrar datos existentes del campo `author` hacia `authors` (script o migration que mappee nombres a `authors` y actualice `author_id`).
- Añadir autenticación y políticas para proteger acciones de modificación.
- Añadir tests funcionales (Feature) para las rutas CRUD.

Si quieres, implemento alguno de estos (por ejemplo: añadir filtros en `index` o un seeder para autores/géneros).

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.
