<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    //php artisan migrate --path=/database/migrations/2020_09_08_135914_create_surveys_table.php -v
    public function up()
    {
        Schema::create('surveys', function (Blueprint $table) {
            //
            $table->increments('survey_id'); //cliente--
            $table->integer('user_id')->length(5)->unsigned()->nullable()->default('0'); //cliente--
            $table->integer('partner_id')->length(5)->unsigned()->nullable()->default('0'); //cliente--
            $table->integer('complaint_id')->length(5)->unsigned()->nullable()->default('0'); //cliente--
            $table->text('comment_survey')->nullable();
            //TIMESTAMPS
            $table->dateTime('register_survey_date')->useCurrent = true;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surveys');
    }
}
