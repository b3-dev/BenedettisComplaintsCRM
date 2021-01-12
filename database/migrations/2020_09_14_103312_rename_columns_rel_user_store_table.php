<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnsRelUserStoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    /// php artisan migrate --path=/database/migrations/2020_09_14_103312_rename_columns_rel_user_store_table.php
    public function up()
    {
        Schema::table('rel_user_store', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->index('rel_id');
           // $table->index('rel_id'); //cliente--
            $table->integer('manager_id')->length(5)->unsigned()->nullable()->default('0'); //cliente--
            $table->integer('partner_id')->length(5)->unsigned()->nullable()->default('0'); //cliente--
            $table->integer('partner_id')->length(5)->unsigned()->nullable()->default('0'); //cliente--
            $table->tinyInteger('rel_user_active')->length(1)->unsigned()->nullable()->default('1'); //cliente--

            $table->primary('rel_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rel_unidad_supervisor', function (Blueprint $table) {
            //
            $table->renameColumn('store_id', 'id_unidad');
            $table->renameColumn('supervisor_id', 'id_supervisor');
            $table->renameColumn('zone_id', 'id_zona');
        });
    }
}
