<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
Use Illuminate\Support\Facades\DB;

class Survey extends Model
{
    //

    public static function getCuestionsSurvey()
    {

        $rowSurvey = DB::table('cuestions_survey')
            ->orderBy('cuestion_sort', 'ASC')
            ->get();

        return $rowSurvey;
    }

    public static function getAnswersByCuestion($data)
    {
        $rowAnswers = DB::table('rel_cuestion_answers')
        ->join('answers_survey', 'rel_cuestion_answers.answer_id', '=', 'answers_survey.answer_id') //facebook, web, app
        ->where('cuestion_id', $data['cuestion_id'])
        ->orderBy('answers_survey_id', 'asc')
        ->get();

        return $rowAnswers;
    }

    public static function getIfExistSurvey($data)
    {

        $surveyCount = DB::table('surveys')->where('complaint_id',$data['complaint_id'])->count();
        return $surveyCount;
    }

    public static function createSurvey($data)
    {
        $surveyId = DB::table('surveys')->insertGetId($data);
        return $surveyId;
    }

    public static function createResultSurvey($data)
    {
        $surveyId = DB::table('result_answers_survey')->insertGetId($data);
        return $surveyId;
    }

    public static function getSurveys($data){
        $arraySurveys = DB::table('surveys')
        ->limit($data['limit'])
        ->orderBy($data['sort'], $data['order'])
        ->offset($data['offset'])
        ->get(); //vigente..
        return $arraySurveys;
    }

    public static function getAllSurveys($data){
        $arraySurveys = DB::table('surveys')
        ->get(); //vigente..
        return $arraySurveys;
    }

    public static function getSurveyById($data){
        $arraySurvey = DB::table('surveys')
        ->where('survey_id',$data['survey_id'])
        ->first();
        return $arraySurvey;
    }
    public static function getDetailSurveyById($data){
        $arraySurvey = DB::table('result_answers_survey')
        ->join('cuestions_survey', 'result_answers_survey.cuestion_id', '=', 'cuestions_survey.cuestion_id')
        ->join('answers_survey', 'result_answers_survey.answer_id', '=', 'answers_survey.answer_id')
        ->where('result_answers_survey.survey_id',$data['survey_id'])->orderBy('result_answers_survey.cuestion_id','asc')
        ->get();
        return $arraySurvey;
    }
}
