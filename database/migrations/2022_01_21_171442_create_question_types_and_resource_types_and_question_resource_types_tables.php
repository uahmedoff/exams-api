<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionTypesAndResourceTypesAndQuestionResourceTypesTables extends Migration
{
    public function up()
    {
        Schema::create('question_types', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
        });
        Schema::create('resource_types', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
        });
        Schema::create('question_resource_types', function (Blueprint $table) {
            $table->unsignedBigInteger('question_type_id');
            $table->unsignedBigInteger('resource_type_id');
            $table->timestamps();
            $table->index(['question_type_id','resource_type_id']);
            $table->primary(['question_type_id','resource_type_id']);
            $table->foreign('question_type_id')
                ->references('id')
                ->on('question_types')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('resource_type_id')
                ->references('id')
                ->on('resource_types')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
        Schema::table('resources', function (Blueprint $table) {
            $table->unsignedBigInteger('type')->change();
        });
        Schema::table('resources', function (Blueprint $table) {
            $table->renameColumn('type', 'type_id');
        });
        Schema::table('questions', function (Blueprint $table) {
            $table->unsignedBigInteger('type')->change();
        });
        Schema::table('questions', function (Blueprint $table) {
            $table->renameColumn('type', 'type_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('question_resource_types');
        Schema::dropIfExists('question_types');
        Schema::dropIfExists('resource_types');
        Schema::table('resources', function (Blueprint $table) {
            $table->integer('type_id')->change();
        });
        Schema::table('resources', function (Blueprint $table) {
            $table->renameColumn('type_id', 'type');
        });
        Schema::table('questions', function (Blueprint $table) {
            $table->integer('type_id')->change();
        });
        Schema::table('questions', function (Blueprint $table) {
            $table->renameColumn('type_id', 'type');
        });
    }
}
