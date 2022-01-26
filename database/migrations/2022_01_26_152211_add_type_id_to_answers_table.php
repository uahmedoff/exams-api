<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeIdToAnswersTable extends Migration
{
    public function up()
    {
        Schema::table('answers', function (Blueprint $table) {
            $table->unsignedBigInteger('type_id')->default(2);
        });
    }

    public function down()
    {
        Schema::table('answers', function (Blueprint $table) {
            $table->dropColumn('type_id');
        });
    }
}
