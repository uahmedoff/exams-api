<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThemesTable extends Migration
{
    public function up(){
        Schema::create('folders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->unsignedBigInteger('level_id');
            $table->unsignedBigInteger('question_type_id');
            $table->boolean('is_active')->default(true);
        });
        Schema::table('question_plans', function (Blueprint $table) {
            $table->unsignedBigInteger('folder_id')->default(1);
        });
    }

    public function down(){
        Schema::dropIfExists('folders');
        Schema::table('question_plans', function (Blueprint $table) {
            $table->dropColumn('folder_id');
        });
    }
}
