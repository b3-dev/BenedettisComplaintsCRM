<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnsComplaints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    //php artisan migrate --path=/database/migrations/2020_09_06_220548_rename_columns_complaints.php
   //php artisan migrate:rollback --path=/database/migrations/2020_09_06_220548_rename_columns_complaints.php

    public function up()
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->renameColumn('id_queja', 'complaint_id');
            $table->renameColumn('queja', 'complaint_description');
            $table->renameColumn('id_unidad', 'store_id');
            $table->renameColumn('id_supervisor', 'supervisor_id');
            $table->renameColumn('id_cliente', 'customer_id');
            $table->renameColumn('fechaqueja', 'register_date');
            $table->renameColumn('id_status', 'status_id');
            $table->renameColumn('id_importancia', 'priority_id');
            $table->renameColumn('id_zona', 'zone_id');
            $table->renameColumn('fechasolucion', 'solved_date');
            $table->renameColumn('comentario_queja', 'complaint_solution');
            $table->renameColumn('id_usuario', 'user_id');
            $table->renameColumn('id_diaoperativo', 'operativeday_id');
            $table->renameColumn('periodo', 'period');
            $table->renameColumn('id_tipoqueja', 'category_id');
            //add columns
            //$table->integer('subcategory_id')->length(2)->unsigned()->nullable()->default('1');
           // $table->integer('department_id')->length(2)->unsigned()->nullable()->default('2'); //operaciones
            $table->integer('group_id')->length(2)->unsigned()->nullable()->default('1'); //cliente--
            $table->integer('partner_id')->length(5)->unsigned()->nullable()->default('0'); //cliente--
            $table->tinyInteger('category_request_id')->length(2)->unsigned()->nullable()->default('1'); //cliente--
            $table->tinyInteger('department_id')->length(2)->nullable()->default('2'); //operaciones--


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('complaints', function (Blueprint $table) {
            //
            $table->renameColumn('complaint_id', 'id_queja');
            $table->renameColumn('complaint_description', 'queja');
            $table->renameColumn('store_id', 'id_unidad');
            $table->renameColumn('supervisor_id', 'id_supervisor');
            $table->renameColumn('customer_id', 'id_cliente');
            $table->renameColumn('register_date', 'fechaqueja');
            $table->renameColumn('status_id', 'id_status');
            $table->renameColumn('priority_id', 'id_importancia');
            $table->renameColumn('zone_id', 'id_zona');
            $table->renameColumn('solved_date', 'fechasolucion');
            $table->renameColumn('complaint_solution', 'comentario_queja');
            $table->renameColumn('user_id', 'id_usuario');
            $table->renameColumn('operativeday_id', 'id_diaoperativo');
            $table->renameColumn('period', 'periodo');
            $table->renameColumn('category_id', 'id_tipoqueja');

        });
    }
}
