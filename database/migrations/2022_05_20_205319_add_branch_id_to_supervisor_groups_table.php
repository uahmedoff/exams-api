<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBranchIdToSupervisorGroupsTable extends Migration
{
    public function up(){
        Schema::table('supervisor_groups', function (Blueprint $table) {
            $table->unsignedBigInteger('supervisor_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
        });
    }

    public function down(){
        Schema::table('supervisor_groups', function (Blueprint $table) {
            $table->dropColumn('supervisor_id');
            $table->dropColumn('branch_id');
        });
    }
}
