<?php

return [

    /*
    |--------------------------------------------------------------------------
    | YOUR PROJECT INFORMATION
    |--------------------------------------------------------------------------
    |
    |
    */
        // this data used for add relation between language setting and user

        'users_table'       => 'users',


    /*
    |--------------------------------------------------------------------------
    | ROUTES
    |--------------------------------------------------------------------------
    |
    |
    */
        'base_word_index'   => 'admin.trans.base.index',
        'languages_index'   => 'admin.trans.lang.index',
        'modules_index'     => 'admin.trans.module.index',


    /*
    |--------------------------------------------------------------------------
    | TABLE NAMES
    |--------------------------------------------------------------------------
    |   -1. FLAG TRANSLATION
    |   -2. BASE TRANSLATION
    |   -3. MODULE TRANSLATION
    |
    */

        'translation_flags_table'       => 'trans_langs',
        'translation_base_table'        => 'trans_translation',
        'translation_module_table'      => 'trans_module_translation',


    /*
    |--------------------------------------------------------------------------
    | GENERAL INFORMATION
    |--------------------------------------------------------------------------
    |
    |
    */



];

