<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Congratulation extends Model
{
    //
    protected $table = 'congratulations';
    public $timestamps = false;

    public static function getCongratulations($data)
    {
        //join status, area mkt
        $arrayCongratulations= Congratulation::join('group','congratulations.group_id','=','group.group_id')
       // ->join('users','complaints.user_id','=','users.user_id')
        ->where('register_date','like', "%".date('Y')."%")
        ->limit($data['limit'])
        ->orderBy($data['sort'], $data['order'])
        ->offset($data['offset'])
        ->get(); //vigente..

       // dd($arraySuggestions);
        return $arrayCongratulations;
    }

    public static function getCongratulationById($data){
        $arrayCongratulation = Congratulation::join('group', 'congratulations.group_id', '=', 'group.group_id')
        ->where('congratulation_id',$data['congratulation_id'])
        ->get();
        return $arrayCongratulation;
    }

}
