<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameRelUnidadSupervisorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    // php artisan migrate --path=/database/migrations/2020_09_07_175223_rename_rel_unidad_supervisor_table.php
    public function up()
    {
        Schema::rename('rel_unidad_supervisor', 'rel_user_store');

        Schema::table('rel_user_store', function (Blueprint $table) {
            //
            $table->renameColumn('id_unidad', 'store_id');
            $table->renameColumn('id_supervisor', 'supervisor_id');
            $table->renameColumn('id_zona', 'zone_id');


            //TIMESTAMPS
        });

     }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('rel_user_store', 'rel_unidad_supervisor');


    }
}
