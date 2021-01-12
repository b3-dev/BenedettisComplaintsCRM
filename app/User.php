<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
Use Illuminate\Support\Facades\DB;


class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $primaryKey = 'user_id';


    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public function getAuthPassword() {
        return $this->password;
    }

     public function getAuthIdentifier()
    {
        return $this->user_id;
    }

    public static function createUserAccount($data){
        $user_id = DB::table('users')->insertGetId($data);
        return $user_id;
    }

    public static function getAuthMenu($data)
    {
        $arrayOptions = DB::table('app_rel_menu_auth')
            ->join('app_menu', 'app_rel_menu_auth.id_app_menu', '=', 'app_menu.id_app_menu')
            ->where('app_rel_menu_auth.auth_id', $data['auth_id'])
            ->where('app_menu.app_menu_active', 1)
            ->where('app_rel_menu_auth.screen_menu_active', 1)
            ->orderBy('app_rel_menu_auth.rel_sort', 'ASC')
            ->get(); //vigente..

        return $arrayOptions;
    }

    public static function getAuthMainScreen($data)
    {
        $arrayOptions = DB::table('app_rel_menu_auth')
            ->join('app_menu', 'app_rel_menu_auth.id_app_menu', '=', 'app_menu.id_app_menu')
            ->where('app_rel_menu_auth.auth_id', $data['auth_id'])
            ->where('app_menu.app_menu_active', 1)
            ->where('app_rel_menu_auth.main_screen_menu', 1)
            ->get(); //vigente..

        return $arrayOptions;
    }

    public static function getAuthSubmenu($id_app_menu)
    {
        $arrayOptions = DB::table('app_submenu')
            ->where('app_submenu.id_app_menu', $id_app_menu)
            ->where('app_submenu.submenu_active', 1)
            ->orderBy('app_submenu.sort', 'ASC')
            ->get(); //vigente..

        return $arrayOptions;
    }

    public static function getUsers(){
        $arrayUsers = DB::table('users')
        ->join('auth', 'users.auth_id', '=', 'auth.auth_id')
        ->where('users.user_active', 1)
        ->orderBy('users.user_id', 'ASC')
        ->get(); //vigente..

        return $arrayUsers;
    }


}
