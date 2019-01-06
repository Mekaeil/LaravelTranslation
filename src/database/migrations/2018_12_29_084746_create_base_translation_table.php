<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaseTranslationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table      = config('laravel-translation.translation_base_table');
        $tableFlag  = config('laravel-translation.translation_flags_table');

        Schema::create($table, function (Blueprint $table) use($tableFlag){
            $table->increments('id');
            $table->string('key')->index();
            $table->text('value');
            $table->string('locale');
            $table->unsignedInteger('lang');
            $table->timestamps();

            /// CREATE RELATION FOREIGN KEY
            /////////////////////////////////////////////////////
            $table->foreign('lang')->references('id')
                ->on($tableFlag)->onDelete('CASCADE');

            $table->unique(['key','locale']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table = config('laravel-translation.translation_base_table');

        Schema::dropIfExists($table);
    }
}
