<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamgroupTable extends Migration
{
    public function up(){
        Schema::create('examgroup', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('level_id');
            $table->datetime('deadline');
            $table->unsignedBigInteger('number_of_students')->default(0);
            $table->unsignedBigInteger('invigilator_id')->nullable();
            $table->unsignedInteger('status')->default(1);
        });

        Schema::table('exams',function(Blueprint $table){
            $table->unsignedBigInteger('examgroup_id')->nullable();
        });

        Schema::table('results',function(Blueprint $table){
            $table->text('comment')->nullable();
            $table->string('invigilator_file')->nullable();
        });

        Schema::table('students',function(Blueprint $table){
            $table->unsignedBigInteger('group_id')->nullable();
        });
    }

    public function down(){
        Schema::dropIfExists('examgroup');

        Schema::table('exams',function(Blueprint $table){
            $table->dropColumn('examgroup_id');
        });

        Schema::table('results',function(Blueprint $table){
            $table->dropColumn('question_type_id');
            $table->dropColumn('comment');
            $table->dropColumn('invigilator_file');
        });

        Schema::table('students',function(Blueprint $table){
            $table->dropColumn('group_id');
        });
    }
}
