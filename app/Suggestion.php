<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    //
    protected $table = 'suggestions';
    public $timestamps = false;

    public static function getSuggestions($data)
    {
        //join status, area mkt
        $arraySuggestions= Suggestion::join('group','suggestions.group_id','=','group.group_id')
       // ->join('users','complaints.user_id','=','users.user_id')
        ->where('register_date','like', "%".date('Y')."%")
        ->limit($data['limit'])
        ->orderBy($data['sort'], $data['order'])
        ->offset($data['offset'])
        ->get(); //vigente..

       // dd($arraySuggestions);
        return $arraySuggestions;
    }

    public static function getSuggestionById($data){
        $arraySuggestion = Suggestion::join('group', 'suggestions.group_id', '=', 'group.group_id')
        ->where('suggestion_id',$data['suggestion_id'])
        ->get();
        return $arraySuggestion;
    }

}
