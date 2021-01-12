<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
Use Illuminate\Support\Facades\DB;


class Store extends Model
{
    protected $connection = 'mysql_db_unidad';

    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'unidad';

    public static function getStores($data)
    {
        $arrayStores = Store::where('vigencia_db_unidad', 1)
        ->limit($data['limit'])
        ->orderBy($data['sort'],$data['order'])
        ->offset($data['offset'])
        ->get(); //vigente..

        return $arrayStores;
    }

    public static function getStoreById($data)
    {
        $arrayStore = Store::where('id_unidad', $data['id_unidad'])
        ->get(); //vigente..

        return $arrayStore;
    }

    public static function getStoresByPartner($data){

        $arraySurveys = DB::table('rel_user_store')
        ->where('partner_id',$data['partner_id'])
        ->limit($data['limit'])
        ->orderBy($data['sort'], $data['order'])
        ->offset($data['offset'])
        ->get(); //vigente..
        return $arraySurveys;

    }

    public static function getStoresBySupervisor($data){

        $arraySurveys = DB::table('rel_user_store')
        ->where('supervisor_id',$data['supervisor_id'])
        ->where('rel_user_active',1)
        ->limit($data['limit'])
        ->orderBy($data['sort'], $data['order'])
        ->offset($data['offset'])
        ->get(); //vigente..
        return $arraySurveys;

    }

    public static function getStoresByManager($data){

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
