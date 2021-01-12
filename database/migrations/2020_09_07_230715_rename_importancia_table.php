<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameImportanciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('importancia', 'priority');

        Schema::table('priority', function (Blueprint $table) {
            //
            $table->renameColumn('id_importancia', 'priority_id');
            $table->renameColumn('descripcion_importancia', 'priority_description');

            $table->integer('priority_active')->length(1)->unsigned()->nullable()->default('1'); //cliente--

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('priority', 'importancia');

        Schema::table('importancia', function (Blueprint $table) {
            //
            $table->renameColumn('priority_id', 'id_importancia');
            $table->renameColumn('priority_description', 'descripcion_importancia');
        });
    }
}
