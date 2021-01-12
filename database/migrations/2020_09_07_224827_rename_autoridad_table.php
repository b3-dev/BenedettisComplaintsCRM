<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameAutoridadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('autoridad', 'auth');


        Schema::table('auth', function (Blueprint $table) {
            //
            $table->renameColumn('id_autoridad', 'auth_id');
            $table->renameColumn('descripcion', 'auth_description')->length(100);

            $table->tinyInteger('auth_active')->length(1)->unsigned()->nullable()->default('1'); //cliente--

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('auth', 'autoridad');

        Schema::table('autoridad', function (Blueprint $table) {
            //
            $table->renameColumn('auth_id', 'id_autoridad');
            $table->renameColumn('auth_description', 'descripcion');
        });

    }
}
