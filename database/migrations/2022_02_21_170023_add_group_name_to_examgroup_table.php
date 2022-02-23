<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGroupNameToExamgroupTable extends Migration
{
    public function up(){
        Schema::table('students', function (Blueprint $table) {
            $table->string('branch_name')->nullable();
        });
        Schema::table('examgroup', function (Blueprint $table) {
            $table->string('group_name')->nullable();
            $table->string('branch_name')->nullable();
        });
    }

    public function down(){
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('branch_name');
        });
        Schema::table('examgroup', function (Blueprint $table) {
            $table->dropColumn('group_name');
            $table->dropColumn('branch_name');
        });
    }
}
