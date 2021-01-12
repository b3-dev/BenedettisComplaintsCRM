<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    //
    protected $table = 'complaints';
    public $timestamps = false;


    public static function getComplaints($data)
    {
        //join status, area mkt
        $queryComplaints = Complaint::join('status', 'complaints.status_id', '=', 'status.status_id')
        ->join('category','complaints.category_id','=','category.category_id')
         //facebook, web, app
       // ->join('department','complaints.department_id','=','department.department_id')
        ->join('priority','complaints.priority_id','=','priority.priority_id')
        ->join('group','complaints.group_id','=','group.group_id')
        ->join('category_request','complaints.category_request_id','category_request.category_request_id');

        // ->join('users','complaints.user_id','=','users.user_id')
        // ->where('register_date','like', "%".date('Y')."%");

        if ($data['status_id'] > 0)
        $queryComplaints->where('complaints.status_id', $data['status_id']);

        if ($data['store_id'] > 0)
        $queryComplaints->where('complaints.store_id', $data['store_id']);

        if ((!empty($data['dateFrom']) && !empty($data['dateTo']) && ($data['dateFrom'] <= $data['dateTo']))) {
            $queryComplaints->whereBetween('complaints.register_date', [$data['dateFrom'], $data['dateTo']]);
        } else {
            $queryComplaints->where('register_date', 'like', "%" . date('Y') . "%");
        }

        $queryComplaints->limit($data['limit']);
        $queryComplaints->orderBy($data['sort'], $data['order']);
        $queryComplaints->offset($data['offset']);
        $arrayComplaints=$queryComplaints->get();
        return $arrayComplaints;
    }

    public static function getPendingComplaints()
    {
        //join status, area mkt
        $arrayComplaints = Complaint::join('status', 'complaints.status_id', '=', 'status.status_id')
        ->join('category','complaints.category_id','=','category.category_id')
         //facebook, web, app
       // ->join('department','complaints.department_id','=','department.department_id')
        ->join('priority','complaints.priority_id','=','priority.priority_id')
        ->join('group','complaints.group_id','=','group.group_id')
        ->join('category_request','complaints.category_request_id','category_request.category_request_id')
        ->where('register_date','like', "%".date('Y')."%") //this year..
        ->where('complaints.status_id',1) //pendiente
        ->get();
        return $arrayComplaints;
    }

    public static function getSolvedComplaints()
    {
        //join status, area mkt
        $arrayComplaints = Complaint::join('status', 'complaints.status_id', '=', 'status.status_id')
        ->join('category', 'complaints.category_id', '=', 'category.category_id')
        //facebook, web, app
        // ->join('department','complaints.department_id','=','department.department_id')
        ->join('priority', 'complaints.priority_id', '=', 'priority.priority_id')
        ->join('group', 'complaints.group_id', '=', 'group.group_id')
        ->join('category_request', 'complaints.category_request_id', 'category_request.category_request_id')
        ->where('register_date', 'like', "%" . date('Y') . "%") //this year..
        ->where('complaints.status_id', 2) //solucionado
        ->get();
        return $arrayComplaints;
    }

    public static function getRegisteredComplaints()
    {
        //join status, area mkt
        $arrayComplaints = Complaint::join('status', 'complaints.status_id', '=', 'status.status_id')
        ->join('category', 'complaints.category_id', '=', 'category.category_id')
        //facebook, web, app
        // ->join('department','complaints.department_id','=','department.department_id')
        ->join('priority', 'complaints.priority_id', '=', 'priority.priority_id')
        ->join('group', 'complaints.group_id', '=', 'group.group_id')
        ->join('category_request', 'complaints.category_request_id', 'category_request.category_request_id')
        ->where('register_date', 'like', "%" . date('Y') . "%") //this year..
        ->get();
        return $arrayComplaints;
    }


    public static function getTotalComplaints($data)
    {
        //join status, area mkt
        $queryComplaints = Complaint::join('status', 'complaints.status_id', '=', 'status.status_id')
        ->join('category','complaints.category_id','=','category.category_id') //facebook, web, app
       // ->join('department','complaints.department_id','=','department.department_id')
        ->join('priority','complaints.priority_id','=','priority.priority_id')
        ->join('group','complaints.group_id','=','group.group_id')
        ->join('category_request','complaints.category_request_id','category_request.category_request_id');

       // ->join('users','complaints.user_id','=','users.user_id')
        if($data['status_id']>0)
            $queryComplaints->where('complaints.status_id',$data['status_id']);

        if($data['store_id']>0)
            $queryComplaints->where('complaints.store_id',$data['store_id']);

        if((!empty($data['dateFrom']) && !empty($data['dateTo']) && ($data['dateFrom']<=$data['dateTo'])  )){
            $queryComplaints->whereBetween('complaints.register_date', [$data['dateFrom'], $data['dateTo']]);
        }
        else{
            $queryComplaints->where('register_date','like', "%".date('Y')."%");

        }


       // $queryComplaints->limit($data['limit']);
       // $queryComplaints->orderBy($data['sort'], $data['order']);
       // $queryComplaints->offset($data['offset']);
        $arrayComplaints=$queryComplaints->count();
        return $arrayComplaints;
    }

    public static function getComplaintsByPartner($data)
    {
        //join status, area mkt
        $arrayComplaints = Complaint::join('status', 'complaints.status_id', '=', 'status.status_id')
        ->join('category','complaints.category_id','=','category.category_id') //facebook, web, app
       // ->join('department','complaints.department_id','=','department.department_id')
        ->join('priority','complaints.priority_id','=','priority.priority_id')
        ->join('group','complaints.group_id','=','group.group_id')
        ->join('category_request','complaints.category_request_id','category_request.category_request_id')
       // ->join('users','complaints.user_id','=','users.user_id')
        ->where('partner_id',$data['partner_id'])
        ->where('register_date','like', "%".date('Y')."%")
        ->limit($data['limit'])
        ->orderBy($data['sort'], $data['order'])
        ->offset($data['offset'])
        ->get(); //vigente..

        return $arrayComplaints;
    }

    public static function getTotalComplaintsByPartner($data)
    {
        //join status, area mkt
        $arrayComplaints = Complaint::join('status', 'complaints.status_id', '=', 'status.status_id')
        ->join('category','complaints.category_id','=','category.category_id') //facebook, web, app
       // ->join('department','complaints.department_id','=','department.department_id')
        ->join('priority','complaints.priority_id','=','priority.priority_id')
        ->join('group','complaints.group_id','=','group.group_id')
        ->join('category_request','complaints.category_request_id','category_request.category_request_id')
       // ->join('users','complaints.user_id','=','users.user_id')
        ->where('partner_id',$data['partner_id'])
        ->where('register_date','like', "%".date('Y')."%")

        ->count(); //vigente..

        return $arrayComplaints;
    }

    public static function getPendingComplaintsByPartner($data)
    {
        //join status, area mkt
        $arrayComplaints = Complaint::join('status', 'complaints.status_id', '=', 'status.status_id')
        ->join('category','complaints.category_id','=','category.category_id') //facebook, web, app
       // ->join('department','complaints.department_id','=','department.department_id')
        ->join('priority','complaints.priority_id','=','priority.priority_id')
        ->join('group','complaints.group_id','=','group.group_id')
        ->join('category_request','complaints.category_request_id','category_request.category_request_id')
       // ->join('users','complaints.user_id','=','users.user_id')
        ->where('partner_id',$data['partner_id'])
        ->where('register_date','like', "%".date('Y')."%")
        ->where('complaints.status_id', 1) //pendiente
        ->get(); //vigente..

        return $arrayComplaints;
    }

    public static function getSolvedComplaintsByPartner($data)
    {
        //join status, area mkt
        $arrayComplaints = Complaint::join('status', 'complaints.status_id', '=', 'status.status_id')
        ->join('category','complaints.category_id','=','category.category_id') //facebook, web, app
       // ->join('department','complaints.department_id','=','department.department_id')
        ->join('priority','complaints.priority_id','=','priority.priority_id')
        ->join('group','complaints.group_id','=','group.group_id')
        ->join('category_request','complaints.category_request_id','category_request.category_request_id')
       // ->join('users','complaints.user_id','=','users.user_id')
        ->where('partner_id',$data['partner_id'])
        ->where('register_date','like', "%".date('Y')."%")
        ->where('complaints.status_id', 2) //solucionado
        ->get(); //vigente..

        return $arrayComplaints;
    }

    public static function getRegisteredComplaintsByPartner($data)
    {
        //join status, area mkt
        $arrayComplaints = Complaint::join('status', 'complaints.status_id', '=', 'status.status_id')
        ->join('category','complaints.category_id','=','category.category_id') //facebook, web, app
       // ->join('department','complaints.department_id','=','department.department_id')
        ->join('priority','complaints.priority_id','=','priority.priority_id')
        ->join('group','complaints.group_id','=','group.group_id')
        ->join('category_request','complaints.category_request_id','category_request.category_request_id')
       // ->join('users','complaints.user_id','=','users.user_id')
        ->where('partner_id',$data['partner_id'])
        ->where('register_date','like', "%".date('Y')."%")
        ->get(); //vigente..
        return $arrayComplaints;
    }

    public static function getComplaintsBySupervisor($data)
    {
        //join status, area mkt
        $queryComplaints = Complaint::join('status', 'complaints.status_id', '=', 'status.status_id')
        ->join('category','complaints.category_id','=','category.category_id') //facebook, web, app
       // ->join('department','complaints.department_id','=','department.department_id')
        ->join('priority','complaints.priority_id','=','priority.priority_id')
        ->join('group','complaints.group_id','=','group.group_id')
        ->join('category_request','complaints.category_request_id','category_request.category_request_id')
       // ->join('users','complaints.user_id','=','users.user_id')
        ->where('supervisor_id',$data['supervisor_id']);

        if($data['status_id']>0)
            $queryComplaints->where('complaints.status_id',$data['status_id']);

        if($data['store_id']>0)
            $queryComplaints->where('complaints.store_id',$data['store_id']);

        if((!empty($data['dateFrom']) && !empty($data['dateTo']) && ($data['dateFrom']<=$data['dateTo'])  )){
            $queryComplaints->whereBetween('complaints.register_date', [$data['dateFrom'], $data['dateTo']]);
        }
        else{
            $queryComplaints->where('register_date','like', "%".date('Y')."%");

        }

        $queryComplaints->limit($data['limit']);
        $queryComplaints->orderBy($data['sort'], $data['order']);
        $queryComplaints->offset($data['offset']);
        $arrayComplaints=$queryComplaints->get();
        return $arrayComplaints;

    }

    public static function getTotalComplaintsBySupervisor($data)
    {
      //join status, area mkt
      $queryComplaints = Complaint::join('status', 'complaints.status_id', '=', 'status.status_id')
      ->join('category','complaints.category_id','=','category.category_id') //facebook, web, app
     // ->join('department','complaints.department_id','=','department.department_id')
      ->join('priority','complaints.priority_id','=','priority.priority_id')
      ->join('group','complaints.group_id','=','group.group_id')
      ->join('category_request','complaints.category_request_id','category_request.category_request_id')
     // ->join('users','complaints.user_id','=','users.user_id')
      ->where('supervisor_id',$data['supervisor_id']);
      if($data['status_id']>0)
          $queryComplaints->where('complaints.status_id',$data['status_id']);

      if($data['store_id']>0)
          $queryComplaints->where('complaints.store_id',$data['store_id']);

      if((!empty($data['dateFrom']) && !empty($data['dateTo']) && ($data['dateFrom']<=$data['dateTo'])  )){
          $queryComplaints->whereBetween('complaints.register_date', [$data['dateFrom'], $data['dateTo']]);
      }
      else{
          $queryComplaints->where('register_date','like', "%".date('Y')."%");

      }

      $arrayComplaints=$queryComplaints->count();
      return $arrayComplaints;
    }

    public static function getPendingComplaintsBySupervisor($data)
    {
        //join status, area mkt
        $arrayComplaints = Complaint::join('status', 'complaints.status_id', '=', 'status.status_id')
        ->join('category','complaints.category_id','=','category.category_id') //facebook, web, app
       // ->join('department','complaints.department_id','=','department.department_id')
        ->join('priority','complaints.priority_id','=','priority.priority_id')
        ->join('group','complaints.group_id','=','group.group_id')
        ->join('category_request','complaints.category_request_id','category_request.category_request_id')
       // ->join('users','complaints.user_id','=','users.user_id')
        ->where('supervisor_id',$data['supervisor_id'])
        ->where('register_date','like', "%".date('Y')."%")
        ->where('complaints.status_id',1) //pendiente
        ->get(); //vigente..

       // dd($arrayComplaints);

        return $arrayComplaints;
    }

    public static function getSolvedComplaintsBySupervisor($data)
    {
        //join status, area mkt
        $arrayComplaints = Complaint::join('status', 'complaints.status_id', '=', 'status.status_id')
        ->join('category','complaints.category_id','=','category.category_id') //facebook, web, app
       // ->join('department','complaints.department_id','=','department.department_id')
        ->join('priority','complaints.priority_id','=','priority.priority_id')
        ->join('group','complaints.group_id','=','group.group_id')
        ->join('category_request','complaints.category_request_id','category_request.category_request_id')
       // ->join('users','complaints.user_id','=','users.user_id')
        ->where('supervisor_id',$data['supervisor_id'])
        ->where('register_date','like', "%".date('Y')."%")
        ->where('complaints.status_id',2) //solucionado
        ->get(); //vigente..
        return $arrayComplaints;
    }

    public static function getRegisteredComplaintsBySupervisor($data)
    {
        //join status, area mkt
        $arrayComplaints = Complaint::join('status', 'complaints.status_id', '=', 'status.status_id')
        ->join('category','complaints.category_id','=','category.category_id') //facebook, web, app
       // ->join('department','complaints.department_id','=','department.department_id')
        ->join('priority','complaints.priority_id','=','priority.priority_id')
        ->join('group','complaints.group_id','=','group.group_id')
        ->join('category_request','complaints.category_request_id','category_request.category_request_id')
       // ->join('users','complaints.user_id','=','users.user_id')
        ->where('supervisor_id',$data['supervisor_id'])
        ->where('register_date','like', "%".date('Y')."%")
        ->get(); //vigente..

       // dd($arrayComplaints);

        return $arrayComplaints;
    }

    public static function getComplaintsByManager($data)
    {
        //join status, manager
        //solamente supervisores y gerentes deben tener tiendas asignadas
        $queryComplaints = Complaint::join('status', 'complaints.status_id', '=', 'status.status_id')
        ->join('rel_user_store', 'complaints.store_id', '=', 'rel_user_store.store_id')
        ->join('category', 'complaints.category_id', '=', 'category.category_id') //facebook, web, app
        // ->join('department','complaints.department_id','=','department.department_id')
        ->join('priority', 'complaints.priority_id', '=', 'priority.priority_id')
        ->join('group', 'complaints.group_id', '=', 'group.group_id')
        ->join('category_request', 'complaints.category_request_id', 'category_request.category_request_id')
        // ->join('users','complaints.user_id','=','users.user_id')
        ->where('rel_user_store.manager_id', $data['manager_id']);
        if ($data['status_id'] > 0)
        $queryComplaints->where('complaints.status_id', $data['status_id']);

        if ($data['store_id'] > 0)
        $queryComplaints->where('complaints.store_id', $data['store_id']);

        if ((!empty($data['dateFrom']) && !empty($data['dateTo']) && ($data['dateFrom'] <= $data['dateTo']))) {
            $queryComplaints->whereBetween('complaints.register_date', [$data['dateFrom'], $data['dateTo']]);
        } else {
            $queryComplaints->where('register_date', 'like', "%" . date('Y') . "%");
        }

        $queryComplaints->limit($data['limit']);
        $queryComplaints->orderBy($data['sort'], $data['order']);
        $queryComplaints->offset($data['offset']);
        $arrayComplaints = $queryComplaints->get();
        return $arrayComplaints;
    }


    public static function getTotalComplaintsByManager($data)
    {
        //join status, manager
        //solamente supervisores y gerentes deben tener tiendas asignadas
        $queryComplaints = Complaint::join('status', 'complaints.status_id', '=', 'status.status_id')
        ->join('rel_user_store','complaints.store_id','=','rel_user_store.store_id')
        ->join('category','complaints.category_id','=','category.category_id') //facebook, web, app
       // ->join('department','complaints.department_id','=','department.department_id')
        ->join('priority','complaints.priority_id','=','priority.priority_id')
        ->join('group','complaints.group_id','=','group.group_id')
        ->join('category_request','complaints.category_request_id','category_request.category_request_id')
        ->where('rel_user_store.manager_id',$data['manager_id']);
        if ($data['status_id'] > 0)
        $queryComplaints->where('complaints.status_id', $data['status_id']);

        if ($data['store_id'] > 0)
        $queryComplaints->where('complaints.store_id', $data['store_id']);

        if ((!empty($data['dateFrom']) && !empty($data['dateTo']) && ($data['dateFrom'] <= $data['dateTo']))) {
            $queryComplaints->whereBetween('complaints.register_date', [$data['dateFrom'], $data['dateTo']]);
        } else {
            $queryComplaints->where('register_date', 'like', "%" . date('Y') . "%");
        }
        $arrayComplaints = $queryComplaints->count();
        return $arrayComplaints;
    }

    public static function getPendingComplaintsByManager($data)
    {
        //join status, manager
        //solamente supervisores y gerentes deben tener tiendas asignadas
        $arrayComplaints = Complaint::join('status', 'complaints.status_id', '=', 'status.status_id')
        ->join('rel_user_store', 'complaints.store_id', '=', 'rel_user_store.store_id')
        ->join('category', 'complaints.category_id', '=', 'category.category_id') //facebook, web, app
        // ->join('department','complaints.department_id','=','department.department_id')
        ->join('priority', 'complaints.priority_id', '=', 'priority.priority_id')
        ->join('group', 'complaints.group_id', '=', 'group.group_id')
        ->join('category_request', 'complaints.category_request_id', 'category_request.category_request_id')
        // ->join('users','complaints.user_id','=','users.user_id')
        ->where('rel_user_store.manager_id', $data['manager_id'])
        ->where('complaints.register_date', 'like', "%" . date('Y') . "%")
        ->where('complaints.status_id', 1) //pendiente
        ->get(); //vigente..
        return $arrayComplaints;
    }

    public static function getSolvedComplaintsByManager($data)
    {
        //join status, manager
        //solamente supervisores y gerentes deben tener tiendas asignadas
        $arrayComplaints = Complaint::join('status', 'complaints.status_id', '=', 'status.status_id')
        ->join('rel_user_store', 'complaints.store_id', '=', 'rel_user_store.store_id')
        ->join('category', 'complaints.category_id', '=', 'category.category_id') //facebook, web, app
        // ->join('department','complaints.department_id','=','department.department_id')
        ->join('priority', 'complaints.priority_id', '=', 'priority.priority_id')
        ->join('group', 'complaints.group_id', '=', 'group.group_id')
        ->join('category_request', 'complaints.category_request_id', 'category_request.category_request_id')
        // ->join('users','complaints.user_id','=','users.user_id')
        ->where('rel_user_store.manager_id', $data['manager_id'])
        ->where('complaints.register_date', 'like', "%" . date('Y') . "%")
        ->where('complaints.status_id', 2) //solucionado
        ->get(); //vigente..
        return $arrayComplaints;
    }

    public static function getRegisteredComplaintsByManager($data)
    {
        //join status, manager
        //solamente supervisores y gerentes deben tener tiendas asignadas
        $arrayComplaints = Complaint::join('status', 'complaints.status_id', '=', 'status.status_id')
        ->join('rel_user_store', 'complaints.store_id', '=', 'rel_user_store.store_id')
        ->join('category', 'complaints.category_id', '=', 'category.category_id') //facebook, web, app
        // ->join('department','complaints.department_id','=','department.department_id')
        ->join('priority', 'complaints.priority_id', '=', 'priority.priority_id')
        ->join('group', 'complaints.group_id', '=', 'group.group_id')
        ->join('category_request', 'complaints.category_request_id', 'category_request.category_request_id')
        // ->join('users','complaints.user_id','=','users.user_id')
        ->where('rel_user_store.manager_id', $data['manager_id'])
        ->where('complaints.register_date', 'like', "%" . date('Y') . "%")
        ->get(); //vigente..
        return $arrayComplaints;
    }

    public static function getComplaintsByManagerArea($data)
    {
        //join status, manager
        //solamente supervisores y gerentes deben tener tiendas asignadas
        $queryComplaints = Complaint::join('status', 'complaints.status_id', '=', 'status.status_id')
        ->join('category','complaints.category_id','=','category.category_id') //facebook, web, app
       // ->join('department','complaints.department_id','=','department.department_id')
        ->join('priority','complaints.priority_id','=','priority.priority_id')
        ->join('group','complaints.group_id','=','group.group_id')
        ->join('category_request','complaints.category_request_id','category_request.category_request_id')
       // ->join('users','complaints.user_id','=','users.user_id')
        ->whereRaw('(complaints.department_id='.$data['department_id'].' OR complaints.group_id=1)');
//        ->orWhere('complaints.group_id',1);

        if ($data['status_id'] > 0)
            $queryComplaints->where('complaints.status_id', $data['status_id']);

        if ($data['store_id'] > 0)
            $queryComplaints->where('complaints.store_id', $data['store_id']);

        if ((!empty($data['dateFrom']) && !empty($data['dateTo']) && ($data['dateFrom'] <= $data['dateTo']))) {
            $queryComplaints->whereBetween('complaints.register_date', [$data['dateFrom'], $data['dateTo']]);
        } else {
            $queryComplaints->where('register_date', 'like', "%" . date('Y') . "%");
        }

        $queryComplaints->limit($data['limit']);
        $queryComplaints->orderBy($data['sort'], $data['order']);
        $queryComplaints->offset($data['offset']);
        $arrayComplaints = $queryComplaints->get();
        return $arrayComplaints;
    }

    public static function getTotalComplaintsByManagerArea($data)
    {
        //join status, manager
        //solamente supervisores y gerentes deben tener tiendas asignadas
        $queryComplaints = Complaint::join('status', 'complaints.status_id', '=', 'status.status_id')
        ->join('category','complaints.category_id','=','category.category_id') //facebook, web, app
       // ->join('department','complaints.department_id','=','department.department_id')
        ->join('priority','complaints.priority_id','=','priority.priority_id')
        ->join('group','complaints.group_id','=','group.group_id')
        ->join('category_request','complaints.category_request_id','category_request.category_request_id')
       // ->join('users','complaints.user_id','=','users.user_id')
        ->where('complaints.department_id',$data['department_id'])
        ->orWhere('complaints.group_id',1);
        if ($data['status_id'] > 0)
        $queryComplaints->where('complaints.status_id', $data['status_id']);

        if ($data['store_id'] > 0)
        $queryComplaints->where('complaints.store_id', $data['store_id']);

        if ((!empty($data['dateFrom']) && !empty($data['dateTo']) && ($data['dateFrom'] <= $data['dateTo']))) {
            $queryComplaints->whereBetween('complaints.register_date', [$data['dateFrom'], $data['dateTo']]);
        } else {
            $queryComplaints->where('register_date', 'like', "%" . date('Y') . "%");
        }

        $arrayComplaints = $queryComplaints->count();
        return $arrayComplaints;
    }

    //for datatable with filters
    public static function getComplaintsPendingOnTableByManagerArea($data)
    {
        //join status, manager
        //solamente supervisores y gerentes deben tener tiendas asignadas
        $arrayComplaints = Complaint::join('status', 'complaints.status_id', '=', 'status.status_id')
        ->join('category','complaints.category_id','=','category.category_id') //facebook, web, app
        // ->join('department','complaints.department_id','=','department.department_id')
         ->join('priority','complaints.priority_id','=','priority.priority_id')
         ->join('group','complaints.group_id','=','group.group_id')
         ->join('category_request','complaints.category_request_id','category_request.category_request_id')
        // ->join('users','complaints.user_id','=','users.user_id')
        ->where('complaints.department_id', $data['department_id'])
        ->where('complaints.register_date', 'like', "%" . date('Y') . "%")
        ->where('complaints.status_id', 1) //pendiente
        ->get(); //vigente..
        return $arrayComplaints;
    }

    //used for get data pending
    public static function getPendingComplaintsByManagerArea($data)
    {
        //join status, manager
        //solamente supervisores y gerentes deben tener tiendas asignadas
        $arrayComplaints = Complaint::join('status', 'complaints.status_id', '=', 'status.status_id')
        // ->join('rel_user_store','complaints.store_id','=','rel_user_store.store_id')

        ->join('priority', 'complaints.priority_id', '=', 'priority.priority_id')
        ->join('group', 'complaints.group_id', '=', 'group.group_id')
        ->join('category_request', 'complaints.category_request_id', 'category_request.category_request_id')
        // ->join('users','complaints.user_id','=','users.user_id')
        ->where('complaints.department_id', $data['department_id'])
        ->where('complaints.register_date', 'like', "%" . date('Y') . "%")
        ->where('complaints.status_id', 1) //pendiente
        ->get(); //vigente..
        return $arrayComplaints;
    }

    public static function getSolvedComplaintsByManagerArea($data)
    {
        //join status, manager
        //solamente supervisores y gerentes deben tener tiendas asignadas
        $arrayComplaints = Complaint::join('status', 'complaints.status_id', '=', 'status.status_id')
        // ->join('rel_user_store','complaints.store_id','=','rel_user_store.store_id')
        //  ->join('category','complaints.category_id','=','category.category_id') //facebook, web, app
        // ->join('department','complaints.department_id','=','department.department_id')
        ->join('priority', 'complaints.priority_id', '=', 'priority.priority_id')
        ->join('group', 'complaints.group_id', '=', 'group.group_id')
        ->join('category_request', 'complaints.category_request_id', 'category_request.category_request_id')
        // ->join('users','complaints.user_id','=','users.user_id')
        ->where('complaints.department_id', $data['department_id'])
        ->where('complaints.register_date', 'like', "%" . date('Y') . "%")
        ->where('complaints.status_id', 2) //Solucionadas
        ->get(); //vigente..
        return $arrayComplaints;
    }

    public static function getRegisteredComplaintsByManagerArea($data)
    {
        //join status, manager
        //solamente supervisores y gerentes deben tener tiendas asignadas
        $arrayComplaints = Complaint::join('status', 'complaints.status_id', '=', 'status.status_id')
        // ->join('rel_user_store','complaints.store_id','=','rel_user_store.store_id')
        ->join('category','complaints.category_id','=','category.category_id') //facebook, web, app
        // ->join('department','complaints.department_id','=','department.department_id')
        ->join('priority', 'complaints.priority_id', '=', 'priority.priority_id')
        ->join('group', 'complaints.group_id', '=', 'group.group_id')
        ->join('category_request', 'complaints.category_request_id', 'category_request.category_request_id')
        // ->join('users','complaints.user_id','=','users.user_id')
        ->where('complaints.department_id', $data['department_id'])
        ->orWhere('complaints.group_id',1)
        ->where('complaints.register_date', 'like', "%" . date('Y') . "%")
        ->get(); //vigente..
        return $arrayComplaints;
    }

    public static function getComplaintById($data){
        $arrayComplaint = Complaint::join('status', 'complaints.status_id', '=', 'status.status_id')
        ->join('category','complaints.category_id','=','category.category_id') //facebook, web, app
       // ->join('department','complaints.department_id','=','department.department_id')
        ->join('zones','complaints.zone_id','=','zones.zone_id')
        ->join('priority','complaints.priority_id','=','priority.priority_id')
        ->join('group','complaints.group_id','=','group.group_id')
        ->join('category_request','complaints.category_request_id','category_request.category_request_id')
        ->where('complaint_id',$data['complaint_id'])
        ->get();
        return $arrayComplaint;
    }

    public static function getTotalComplaintsPerCategoryId($data){
        $arrayComplaint = Complaint::join('status', 'complaints.status_id', '=', 'status.status_id')
        ->join('category','complaints.category_id','=','category.category_id') //facebook, web, app
       // ->join('department','complaints.department_id','=','department.department_id')
        ->join('zones','complaints.zone_id','=','zones.zone_id')
        ->join('priority','complaints.priority_id','=','priority.priority_id')
        ->join('group','complaints.group_id','=','group.group_id')
        ->join('category_request','complaints.category_request_id','category_request.category_request_id')
        ->where('complaints.group_id',1)//QUEJA DE CLIENTE
        ->where('complaints.category_id',$data['CATEGORY_ID'])
        ->whereRaw('(complaints.period="'.$data['PERIOD'].'" OR complaints.period="P'.$data['PERIOD'].'")')
        ->whereYear('complaints.register_date','=', $data['YEAR'])
        ->count();
        return $arrayComplaint;
    }

    public static function getTotalComplaintsPerPeriod($data){
        $arrayComplaint = Complaint::join('status', 'complaints.status_id', '=', 'status.status_id')
        ->join('category','complaints.category_id','=','category.category_id') //facebook, web, app
       // ->join('department','complaints.department_id','=','department.department_id')
        ->join('zones','complaints.zone_id','=','zones.zone_id')
        ->join('priority','complaints.priority_id','=','priority.priority_id')
        ->join('group','complaints.group_id','=','group.group_id')
        ->join('category_request','complaints.category_request_id','category_request.category_request_id')
        ->where('complaints.group_id',1)//QUEJA DE CLIENTE
        ->whereRaw('(complaints.period="'.$data['PERIOD'].'" OR complaints.period="P'.$data['PERIOD'].'")')
        ->whereYear('complaints.register_date','=', $data['YEAR'])
        ->count();
        return $arrayComplaint;
    }
}
