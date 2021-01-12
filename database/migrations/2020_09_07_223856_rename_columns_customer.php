<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnsCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    //php artisan migrate --path=/database/migrations/2020_09_07_223856_rename_columns_customer.php
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            //
            $table->renameColumn('id_cliente', 'customer_id');
            $table->renameColumn('nomcliente', 'customer_first_name');
            $table->renameColumn('apecliente', 'customer_last_name');
            $table->renameColumn('domicilio', 'customer_address');
          //  $table->renameColumn('email_cliente', 'customer_email');
            $table->renameColumn('telefono', 'customer_phone');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            //
           // $table->string('customer_email')->length(100)->nullable()->default('');

            $table->renameColumn('customer_id', 'id_cliente');
            $table->renameColumn('customer_first_name', 'nomcliente');
            $table->renameColumn('customer_last_name', 'apecliente');
            $table->renameColumn('customer_address', 'domicilio');

            $table->renameColumn('customer_phone', 'telefono');

        });
    }
}
