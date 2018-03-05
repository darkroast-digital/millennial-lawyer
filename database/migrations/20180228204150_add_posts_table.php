<?php

use App\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddPostsTable extends Migration
{
    public function up()
    {
        $this->schema->create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->unique();
            $table->string('slug');
            $table->text('body');
            $table->string('author');
            $table->string('featured');
            $table->boolean('draft');
            $table->text('keywords');
            $table->string('ogtitle');
            $table->string('ogdesc');
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->schema->drop('posts');
    }
}
