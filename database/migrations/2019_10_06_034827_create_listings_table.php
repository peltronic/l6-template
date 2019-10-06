<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingsTable extends Migration 
{
	public function up()
	{
		Schema::create('listings', function(Blueprint $table) {
            $table->increments('id');
            $table->string('guid')->unique();
            $table->string('slug')->unique();
            $table->integer('account_id')->unsigned()->nullable();
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->string('ltitle')->nullable();
            $table->longtext('ldesc')->nullable();
            $table->longtext('jsonattrs')->nullable();
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('listings');
	}
}

/* REF
class CreateBooksTable extends Migration
{
    public function up()
    {
        Schema::create('authors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('surname');
        });

        Schema::create('books', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('isbn')->unique();
            $table->string('title');
            $table->text('description');
        });

        Schema::create('book_author', function (Blueprint $table) {
            $table->bigInteger('book_id');
            $table->bigInteger('author_id');

            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade');
        });

        Schema::create('book_reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('book_id');
            $table->bigInteger('user_id');
            $table->tinyInteger('review')->unsigned();
            $table->text('comment');

            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {

        Schema::dropIfExists('book_reviews');
        Schema::dropIfExists('book_author');
        Schema::dropIfExists('books');
        Schema::dropIfExists('authors');
    }
}
 */
