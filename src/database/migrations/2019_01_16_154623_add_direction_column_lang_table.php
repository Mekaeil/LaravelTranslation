<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDirectionColumnLangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = config('laravel-translation.translation_flags_table');

        Schema::table($table, function (Blueprint $table) {
            $table->string('direction')->default('ltr');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table = config('laravel-translation.translation_flags_table');

        Schema::table($table, function (Blueprint $table) {
            $table->dropColumn('direction');
        });
    }
}
