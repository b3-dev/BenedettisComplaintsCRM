<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnsFelicitationes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // php artisan migrate --path=/database/migrations/2020_09_19_114159_rename_columns_felicitationes.php


    public function up()
    {
        Schema::rename('felicitaciones', 'congratulations');

        Schema::table('congratulations', function (Blueprint $table) {
            //
            $table->renameColumn('id_felicitacion', 'congratulation_id');
            $table->renameColumn('felicitacion', 'congratulation_description');
            $table->renameColumn('id_cliente', 'customer_id');
            $table->renameColumn('fecha_felicitacion', 'register_date');
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
        Schema::rename('congratulations', 'felicitaciones');

        Schema::table('felicitaciones', function (Blueprint $table) {
            //
            $table->renameColumn('congratulation_id', 'id_felicitacion');
            $table->renameColumn('congratulation_description', 'felicitacion');
            $table->renameColumn('customer_id' , 'id_cliente');
            $table->renameColumn('register_date', 'fecha_felicitacion');
            $table->renameColumn('operativeday_id', 'id_diaoperativo');
            $table->renameColumn('user_id', 'id_usuario');
            $table->renameColumn('period', 'periodo');
        });
    }
}
