<?php

use App\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddUsersTable extends Migration
{
    public function up()
    {
        $this->schema->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->schema->drop('users');
    }
}
