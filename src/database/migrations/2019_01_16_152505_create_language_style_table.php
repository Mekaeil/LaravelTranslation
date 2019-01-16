<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguageStyleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table      = config('laravel-translation.translation_style_table');
        $tableFlag  = config('laravel-translation.translation_flags_table');

        Schema::create($table, function (Blueprint $table) use($tableFlag){
            $table->increments('id');
            $table->unsignedInteger('lang_id')->index();
            $table->enum('type',[
                'css_link',
                'custom_css',
                'script_link',
                'custom_script',
            ]);
            $table->text('source');
            $table->enum('where',[
                'front-end',
                'back-end',
            ]);
            $table->boolean('status')->default(true);
            $table->timestamps();

            /// CREATE RELATION FOREIGN KEY
            /////////////////////////////////////////////////////
            $table->foreign('lang_id')
                ->references('id')
                ->on($tableFlag)
                ->onDelete('CASCADE');

        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table = config('laravel-translation.translation_style_table');

        Schema::dropIfExists($table);
    }
}
