<?php

use App\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddPageViewColumn extends Migration
{
    public function up()
    {
        $this->schema->table('posts', function (Blueprint $table) {
            $table->integer('post_views');
        });
    }

    public function down()
    {
        $this->schema->table('posts', function (Blueprint $table) {
            $table->dropColumn('post_views');
        });
    }
}
