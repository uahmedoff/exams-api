<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsActiveToQuestionPlanAndCategoryIdToQuestionsTable extends Migration
{
    public function up(){
        Schema::table('question_plans', function (Blueprint $table) {
            $table->boolean('is_active')->default(true);
        });
        Schema::table('questions', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable();
        });
    }

    public function down(){
        Schema::table('question_plans', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });
    }
}
