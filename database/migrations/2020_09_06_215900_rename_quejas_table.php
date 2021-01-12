<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameQuejasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    //php artisan migrate --path=/database/migrations/2020_09_06_215900_rename_quejas_table.php
   //php artisan migrate:rollback --path=/database/migrations/2020_09_06_215900_rename_quejas_table.php
    public function up()
    {
        Schema::rename('quejas', 'complaints');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('complaints', 'quejas');

    }
}
