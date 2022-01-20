<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserstampsAndIsActiveColumnToTables extends Migration
{
    public function up()
    {
        Schema::table('levels', function (Blueprint $table) {
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
        });
        Schema::table('resources', function (Blueprint $table) {
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
        });
        Schema::table('questions', function (Blueprint $table) {
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
        });
        Schema::table('answers', function (Blueprint $table) {
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
        });
    }

    public function down()
    {
        Schema::table('levels', function (Blueprint $table) {
            $table->dropColumn('is_active');
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
        });
        Schema::table('resources', function (Blueprint $table) {
            $table->dropColumn('is_active');
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
        });
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('is_active');
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
        });
        Schema::table('answers', function (Blueprint $table) {
            $table->dropColumn('is_active');
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
        });
    }
}
