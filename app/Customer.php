<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    protected $table = 'customers';
    public $timestamps = false;

    public static function getCustomers($data)
    {
        $arrayComplaints = Customer::limit($data['limit'])
        ->orderBy($data['sort'], $data['order'])
        ->offset($data['offset'])
        ->get(); //vigente..

        return $arrayComplaints;
    }
}
