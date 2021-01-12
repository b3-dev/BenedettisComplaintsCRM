<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelManagerSupervisor extends Model
{
    //
    protected $table = 'rel_manager_supervisor';


    public static function getManagerBySupervisor($data)
    {
        $arrayManager = RelManagerSupervisor::join('users', 'rel_manager_supervisor.manager_id', '=', 'users.manager_id')
            ->where('rel_manager_supervisor.supervisor_id', $data['supervisor_id'])
            ->get(); //vigente..

        return $arrayManager;
    }

    public static function getSupervisorsByManager($data)
    {
        $arrayManager = RelManagerSupervisor::join('users', 'rel_manager_supervisor.supervisor_id', '=', 'users.supervisor_id')
             ->join('auth', 'users.auth_id', '=', 'auth.auth_id')
            ->where('rel_manager_supervisor.manager_id', $data['manager_id'])
            ->get(); //vigente..

        return $arrayManager;
    }
}
