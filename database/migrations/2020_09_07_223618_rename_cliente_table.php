<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameClienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    /// php artisan migrate --path=/database/migrations/2020_09_07_223618_rename_cliente_table.php
    public function up()
    {
        Schema::rename('clientes', 'customers');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('customers', 'clientes');
    }
}
