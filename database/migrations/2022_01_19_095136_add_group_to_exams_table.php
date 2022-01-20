<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGroupToExamsTable extends Migration
{
    public function up()
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->string('group');
        });
    }

    public function down()
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->dropColumn('group');
        });
    }
}
