<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameTableSupervisores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

     ///  php artisan migrate --path=/database/migrations/2020_09_14_125330_rename_table_supervisores.php
    public function up()
    {

        Schema::rename('supervisores', 'rel_manager_supervisor');

        Schema::table('rel_manager_supervisor', function (Blueprint $table) {
            //
            $table->renameColumn('id_supervisor', 'supervisor_id');
            $table->renameColumn('id_gerente', 'manager_id');
            $table->renameColumn('vigencia_supervisor', 'rel_manager_active');
            $table->dropColumn('email_supervisor');
            $table->dropColumn('nomsupervisor');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('rel_manager_supervisor', 'supervisores');

        Schema::table('supervisores', function (Blueprint $table) {
            //
            $table->renameColumn('supervisor_id', 'id_supervisor');
            $table->renameColumn('manager_id', 'id_gerente');
            $table->renameColumn('rel_manager_active', 'vigencia_supervisor');
        });
    }
}
