<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnsZonas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    //php artisan migrate --path=/database/migrations/2020_09_22_102802_rename_columns_zonas.php
    public function up()
    {
        Schema::rename('zonas', 'zones');


        Schema::table('zones', function (Blueprint $table) {
            //
            $table->renameColumn('id_zona', 'zone_id');
            $table->renameColumn('nomzona', 'name_zone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('zones', 'zonas');

        Schema::table('zonas', function (Blueprint $table) {
            //
            $table->renameColumn('zone_id', 'id_zona');
            $table->renameColumn('name_zone', 'nomzona');
        });
    }
}
