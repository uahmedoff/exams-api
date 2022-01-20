<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('src')->nullable();
            $table->unsignedInteger('type')->comment('1 - Video, 2 - Audio, 3 - Image');
            $table->text('text')->nullable();
            $table->unsignedBigInteger('level_id');
            $table->foreign('level_id')
                ->references('id')
                ->on('levels')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->longText('question')->nullable();
            $table->unsignedBigInteger('level_id');
            $table->unsignedBigInteger('resource_id')->nullable();
            $table->unsignedInteger('type')->comment('1 - Listening, 2 - Reading, 3 - Grammar, 4 - Vocabulary, 5 - Speaking, 6 - Writing');
            $table->foreign('level_id')
                ->references('id')
                ->on('levels')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('resource_id')
                ->references('id')
                ->on('resources')
                ->onUpdate('cascade')
                ->onDelete('cascade');    
        });
    }

    public function down()
    {
        Schema::dropIfExists('questions');
        Schema::dropIfExists('resources');
    }
}