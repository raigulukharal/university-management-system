<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('results', 'session_id')) {
            Schema::table('results', function (Blueprint $table) {
                $table->string('session_id')->after('course_name');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('results', 'session_id')) {
            Schema::table('results', function (Blueprint $table) {
                $table->dropColumn('session_id');
            });
        }
    }
};
