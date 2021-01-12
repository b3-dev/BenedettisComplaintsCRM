<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnsUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    //php artisan migrate --path=/database/migrations/2020_09_07_171251_rename_columns_users.php

    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->renameColumn('id_usuario', 'user_id');
            $table->renameColumn('nomusuario', 'first_name');
            $table->renameColumn('apusuario', 'last_name');
            $table->renameColumn('login', 'email');
            $table->renameColumn('passwd', 'password');
            $table->renameColumn('vigencia', 'user_active');
            $table->renameColumn('id_autoridad', 'auth_id');
            //ADD COLUMNS..
           // $table->string('email',100)->change();
           // $table->string('passwd',200)->change();
            $table->string('phone')->length(15)->nullable()->default('');
            $table->integer('supervisor_id')->length(5)->unsigned()->nullable()->default('0'); //cliente--
            $table->integer('manager_id')->length(5)->unsigned()->nullable()->default('0'); //cliente--
            $table->integer('partner_id')->length(5)->unsigned()->nullable()->default('0'); //cliente--
            $table->integer('department_id')->length(5)->unsigned()->nullable()->default('0'); //cliente--

            //TIMESTAMPS
            $table->timestamp('created_at')->useCurrent = true;
            $table->timestamp('updated_at')->useCurrent = true;

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->renameColumn('user_id', 'id_usuario');
            $table->renameColumn('first_name', 'nomusuario');
            $table->renameColumn('last_name', 'apusuario');
            $table->renameColumn('email', 'login');
            $table->renameColumn('password', 'passwd');
            $table->renameColumn('user_active', 'vigencia');
            $table->renameColumn('auth_id', 'id_autoridad');
        });
    }
}
