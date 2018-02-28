<?php

use App\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddArticlesTable extends Migration
{
    public function up()
    {
        $this->schema->create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug');
            $table->string('title');
            $table->longText('body');
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->schema->drop('articles');
    }
}
