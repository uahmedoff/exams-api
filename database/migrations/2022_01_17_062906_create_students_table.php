<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('surname');
            $table->string('phone')->unique();
            $table->string('date_of_birth')->nullable();
            $table->string('group');
            $table->string('current_level');
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
}
