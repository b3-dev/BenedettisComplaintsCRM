<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswerSurveyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    //php artisan migrate --path=/database/migrations/2020_09_08_135852_create_answer_survey_table.php -v

    public function up()
    {
        Schema::create('result_answers_survey', function (Blueprint $table) {
            //
            $table->increments('result_id'); //cliente--
            $table->integer('survey_id')->length(5)->unsigned()->nullable()->default('0'); //cliente--
            $table->integer('cuestion_id')->length(5)->unsigned()->nullable()->default('0'); //cliente--
            $table->integer('answer_id')->length(5)->unsigned()->nullable()->default('0'); //cliente--
            //TIMESTAMPS
            $table->dateTime('register_answer_date')->useCurrent = true;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers_survey');
    }
}
