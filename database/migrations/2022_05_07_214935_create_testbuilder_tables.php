<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestbuilderTables extends Migration
{
    public function up()
    {
        Schema::table('users',function(Blueprint $table){
            $table->unsignedBigInteger('staff_id')->nullable();
        });

        Schema::create('supervisor_groups', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at');
            $table->unsignedBigInteger('created_by')->nulable();
            $table->json('group');
            $table->string('level');
            $table->date('exam_date');
        });

        Schema::create('group_students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supervisor_group_id');
            $table->string('student');
            $table->foreign('supervisor_group_id')
                ->references('id')
                ->on('supervisor_groups')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    
        Schema::create('generated_questions',function(Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('group_student_id');
            $table->foreign('question_id')
                ->references('id')
                ->on('questions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('group_student_id')
                ->references('id')
                ->on('group_students')
                ->onUpdate('cascade')
                ->onDelete('cascade');    
        });
    }

    public function down()
    {
        Schema::table('users',function(Blueprint $table){
            $table->dropColumn('staff_id');
        });

        Schema::dropIfExists('generated_questions');
        
        Schema::dropIfExists('group_students');
        
        Schema::dropIfExists('supervisor_groups');
    }
}
