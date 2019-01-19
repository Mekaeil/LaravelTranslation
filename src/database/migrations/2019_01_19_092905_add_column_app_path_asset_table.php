<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnAppPathAssetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table      = config('laravel-translation.translation_style_table');

        Schema::table($table, function (Blueprint $table){
            $table->enum('path_type',[
                'app_path',
                'resource_path',
                'asset',
                'url',
            ])->default('asset');

            $table->unique(['lang_id','type','where']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table      = config('laravel-translation.translation_style_table');

        Schema::table($table, function (Blueprint $table){
            $table->dropColumn('path_type');
        });
    }
}
