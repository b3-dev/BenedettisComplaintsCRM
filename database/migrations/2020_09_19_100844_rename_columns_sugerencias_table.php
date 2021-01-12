<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnsSugerenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    //php artisan migrate --path=/database/migrations/2020_09_19_100844_rename_columns_sugerencias_table.php
    public function up()
    {

        Schema::rename('sugerencias', 'suggestions');

        Schema::table('suggestions', function (Blueprint $table) {
            //
            $table->renameColumn('id_sugerencia', 'suggestion_id');
            $table->renameColumn('sugerencia', 'suggestion_description');
            $table->renameColumn('id_cliente', 'customer_id');
            $table->renameColumn('fecha_sugerencia', 'register_date');
            $table->renameColumn('id_diaoperativo', 'operativeday_id');
            $table->renameColumn('id_usuario', 'user_id');
            $table->renameColumn('periodo', 'period');

            $table->tinyInteger('group_id')->length(2)->unsigned()->nullable()->default('1'); //cliente--
            $table->integer('partner_id')->length(5)->unsigned()->nullable()->default('0'); //cliente--

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('suggestions', 'sugerencias');

        Schema::table('sugerencias', function (Blueprint $table) {
            //
            $table->renameColumn('suggestion_id', 'id_sugerencia');
            $table->renameColumn('suggestion_description', 'sugerencia');
            $table->renameColumn('customer_id' , 'id_cliente');
            $table->renameColumn('register_date', 'fecha_sugerencia');
            $table->renameColumn('operativeday_id', 'id_diaoperativo');
            $table->renameColumn('user_id', 'id_usuario');
            $table->renameColumn('period', 'periodo');
        });
    }
}
