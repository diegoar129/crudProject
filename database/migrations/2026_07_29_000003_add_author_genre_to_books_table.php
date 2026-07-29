<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuthorGenreToBooksTable extends Migration
{
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->unsignedBigInteger('author_id')->nullable()->after('author');
            $table->unsignedBigInteger('genre_id')->nullable()->after('author_id');

            $table->foreign('author_id')->references('id')->on('authors')->onDelete('set null');
            $table->foreign('genre_id')->references('id')->on('genres')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropForeign(['author_id']);
            $table->dropForeign(['genre_id']);
            $table->dropColumn(['author_id', 'genre_id']);
        });
    }
}
