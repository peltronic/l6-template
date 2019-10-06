<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration 
{
	public function up()
	{
		Schema::create('accounts', function(Blueprint $table) {
            $table->increments('id');
            $table->string(' guid')->unique();
            $table->string('slug')->unique();
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('aname')->nullable();
            $table->longtext('adesc')->nullable();
            $table->longtext('jsonattrs')->nullable();
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('accounts');
	}
}
