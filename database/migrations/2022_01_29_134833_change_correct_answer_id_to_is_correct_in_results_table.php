<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCorrectAnswerIdToIsCorrectInResultsTable extends Migration
{
    public function up()
    {
        Schema::table('results', function (Blueprint $table) {
            $table->dropForeign(['correct_answer_id']);
            $table->renameColumn('correct_answer_id','is_correct');
        });
    }

    public function down()
    {
        Schema::table('results', function (Blueprint $table) {
            $table->renameColumn('is_correct','correct_answer_id');
        });
    }
}
