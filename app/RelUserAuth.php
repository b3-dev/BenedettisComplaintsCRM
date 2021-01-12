<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
Use Illuminate\Support\Facades\DB;


class RelUserAuth extends Model
{
    //
    protected $table = 'rel_user_auth';

    public static function getRelUserAuth($data)
    {
        $arrayAuth = DB::table('rel_user_auth')
            ->join('auth', 'auth.auth_id', '=', 'rel_user_auth.auth_id')
            ->where('rel_user_auth.user_id', $data['user_id'])
            ->where('rel_user_auth.rel_auth_active', 1)
            ->get(); //vigente..

        return $arrayAuth;
    }

}
