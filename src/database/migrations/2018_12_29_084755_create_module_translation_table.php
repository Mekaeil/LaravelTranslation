<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModuleTranslationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = config('laravel-translation.translation_module_table');
        $tableFlag  = config('laravel-translation.translation_flags_table');

        Schema::create($table, function (Blueprint $table) use($tableFlag){
            $table->increments('id');
            $table->string('locale');
            $table->unsignedInteger('lang');
            $table->unsignedInteger('module');
            $table->json('data')->nullable();
            $table->unsignedInteger('translable_id');
            $table->string('translable_type')->index();
            $table->timestamps();

            /// CREATE RELATION FOREIGN KEY
            /////////////////////////////////////////////////////
            $table->foreign('lang')->references('id')
                ->on($tableFlag)->onDelete('CASCADE');

            $table->unique(['module','lang','translable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table = config('laravel-translation.translation_module_table');

        Schema::dropIfExists($table);
    }
}
