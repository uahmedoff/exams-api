<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('exam_id');
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('answer_id')->nullable();
            $table->unsignedBigInteger('correct_answer_id')->nullable();
            $table->string('file')->nullable();
            $table->longText('answer')->nullable();
            $table->float('score',8,2)->nullable();
            $table->foreign('exam_id')
                ->references('id')
                ->on('exams')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('question_id')
                ->references('id')
                ->on('questions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('answer_id')
                ->references('id')
                ->on('answers')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('correct_answer_id')
                ->references('id')
                ->on('answers')
                ->onUpdate('cascade')
                ->onDelete('cascade');     
        });
    }

    public function down()
    {
        Schema::dropIfExists('results');
    }
}
