<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameUserUsuarios extends Migration
{

    //php artisan migrate --path=/database/migrations/2020_09_07_170858_rename_user_usuarios.php

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('usuarios', 'users');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('users', 'usuarios');

    }
}
