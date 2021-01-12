<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameTipoquejaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('tipoqueja', 'category');

        Schema::table('category', function (Blueprint $table) {
            //
            $table->renameColumn('id_tipoqueja', 'category_id');
            $table->renameColumn('descripcion_tipoqueja', 'auth_description');

            $table->integer('category_active')->length(1)->unsigned()->nullable()->default('1'); //cliente--

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('category', 'tipoqueja');

        Schema::table('tipoqueja', function (Blueprint $table) {
            //
            $table->renameColumn('category_id', 'id_tipoqueja');
            $table->renameColumn('auth_description', 'descripcion_tipoqueja');
        });
    }
}
