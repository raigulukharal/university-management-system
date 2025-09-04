<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::create('master_results', function (Blueprint $table) {
        $table->id();
        $table->string('roll_no');
        $table->string('student_name');
        $table->string('course_name');
        $table->decimal('obtained_mark', 5, 2);
        $table->decimal('credit_hour', 3, 1);
        $table->decimal('gp', 3, 2);
        $table->decimal('gpa', 4, 2);
        $table->string('session_id');
        $table->timestamps();

        $table->index('roll_no');
        $table->index('session_id');
    });
}


    /**
     * Reverse the migrations.
     */
  public function down()
{
    Schema::dropIfExists('master_results');
}
};
