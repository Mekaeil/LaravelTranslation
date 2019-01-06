<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlagTranslationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = config('laravel-translation.translation_flags_table');

        Schema::create($table, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique()->index();
            $table->string('display_name');
            $table->boolean('status')->default(false);
            $table->boolean('default')->default(false);
            $table->timestamps();
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

        Schema::dropIfExists($table);
    }
}
