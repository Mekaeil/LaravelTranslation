<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLangIdColUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table          = config('laravel-translation.users_table');
        $userID         = config('laravel-translation.users_id_table');
        $language_table = config('laravel-translation.translation_flags_table');

        if ($table){
            Schema::table($table, function (Blueprint $table) use ($language_table,$userID){
                $table->unsignedInteger('lang_id')->nullable();

                /// CREATE RELATION FOREIGN KEY
                /////////////////////////////////////////////////////
                $table->foreign('lang_id')
                    ->references($userID)
                    ->on($language_table)
                    ->onDelete('SET NULL')
                    ->onUpdate('CASCADE');

            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table          = config('laravel-translation.users_table');
        $foreign        = $table . '_' .'lang_id' . "_foreign";

        if ($table){
            Schema::table($table, function (Blueprint $table) use ($foreign){
                $table->dropForeign($foreign);
            });

            Schema::table($table, function (Blueprint $table){
                $table->dropColumn('lang_id');
            });
        }
    }
}
