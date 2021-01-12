<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    //
    public static function getPP($data){

        $arraySurveys = DB::table('rel_user_store')
        ->where('manager_id',$data['manager_id'])
        ->where('rel_user_active',1)
        ->limit($data['limit'])
        ->orderBy($data['sort'], $data['order'])
        ->offset($data['offset'])
        ->get(); //vigente..
        return $arraySurveys;

    }

}
