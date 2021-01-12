<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
Use Illuminate\Support\Facades\DB;

class AppConfigEmail extends Model
{
    //
    protected $table = 'app_config_bcc_emails';

    public static function getEmailFrom()
    {
        $arrayFrom = DB::table('app_email_from')
            ->where('email_active', 1)
            ->first(); //vigente..
        return $arrayFrom;
    }

}
