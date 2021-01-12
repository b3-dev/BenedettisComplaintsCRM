<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\AuthLevel;
use App\Category;
use App\Department;
use App\Group;
use App\Priority;
use App\RelUserStore;
use App\Survey;
use App\User;
use App\Complaint;
use App\Store;
use App\RelManagerSupervisor;
use Session;



class MainController extends Controller
{
    //

    public function index(){

        if (!Auth::check()) {
            return view('login.login');
        } else {

            //echo 'dashboard';
            //getMainRoute
            $data['auth_id'] = session('SES_AUTH_ID');
            $arrayMainScreen = User::getAuthMainScreen($data);
            if (!empty($arrayMainScreen) > 0 && count($arrayMainScreen) > 0) {
                return redirect($arrayMainScreen[0]->url);
            } else {
                //echo '<h2>No existe el menú de opciones para esta cuenta</h2>';
                return redirect('/logout');
            }
        }
    }

    public function dashboard(){
        //var_dump(session('SES_USER_MENU'));
        if (Auth::check()) {
            $data['auth_id'] = Auth::user()->auth_id;
            $arrayMainScreen = User::getAuthMainScreen($data);
            if($arrayMainScreen[0]->url=='dashboard'){

                $data['complaints_pending']=Complaint::getPendingComplaints();
                $data['complaints_solved']=Complaint::getSolvedComplaints();
                $data['complaints_registered']=Complaint::getRegisteredComplaints();

                return view('dashboard.dashboard',compact('data'));
            }
            else{
                return redirect($arrayMainScreen[0]->url);
            }

        }
        else{
           return redirect('/');
        }
    }

    public function dashboardBySupervisor()
    {
        //var_dump(session('SES_USER_MENU'));
        if (Auth::check()) {
            $data['auth_id'] = session('SES_AUTH_ID');
            $arrayMainScreen = User::getAuthMainScreen($data);

            if ($arrayMainScreen[0]->url == 'dashboardBySupervisor') {
                $data['supervisor_id']= Auth::user()->supervisor_id;
                $data['complaints_pending'] = Complaint::getPendingComplaintsBySupervisor($data);
                $data['complaints_solved'] = Complaint::getSolvedComplaintsBySupervisor($data);
                $data['complaints_registered'] = Complaint::getRegisteredComplaintsBySupervisor($data);
                return view('dashboard.dashboardBySupervisor', compact('data'));
            } else {
                return redirect($arrayMainScreen[0]->url);
            }
        } else {
            return redirect('/');
        }
    }

    public function dashboardByManager(){
        //GERENTE DE ZONA
        if (Auth::check()) {
            $data['auth_id'] = session('SES_AUTH_ID');
            $arrayMainScreen = User::getAuthMainScreen($data);

            if ($arrayMainScreen[0]->url == 'dashboardByManager') {
                $data['manager_id'] = Auth::user()->manager_id;
                $data['complaints_pending'] = Complaint::getPendingComplaintsByManager($data);
                $data['complaints_solved'] = Complaint::getSolvedComplaintsByManager($data);
                $data['complaints_registered'] = Complaint::getRegisteredComplaintsByManager($data);
                return view('dashboard.dashboardByManager',compact('data'));
            } else {
                return redirect($arrayMainScreen[0]->url);
            }
        } else {
            return redirect('/');
        }
    }

    public function dashboardByManagerArea()
    {
        //GERENTE DE DEPARTAMENTO
        if (Auth::check()) {
           // $data['auth_id'] = Auth::user()->auth_id;
            $data['auth_id'] = session('SES_AUTH_ID');
            $arrayMainScreen = User::getAuthMainScreen($data);
            $data['department_id'] = Auth::user()->department_id;
            $dataDepartment=Department::where('department_id',Auth::user()->department_id)->get('department_description')->first();
            $data['department_name']=(!empty($dataDepartment->department_description))?$dataDepartment->department_description:'N/A';
            $data['complaints_pending'] = Complaint::getPendingComplaintsByManagerArea($data);
            $data['complaints_solved'] = Complaint::getSolvedComplaintsByManagerArea($data);
            $data['complaints_registered'] = Complaint::getRegisteredComplaintsByManagerArea($data);

            if ($arrayMainScreen[0]->url == 'dashboardByManagerArea') {
                return view('dashboard.dashboardByManagerArea',compact('data'));
            } else {
                return redirect($arrayMainScreen[0]->url);
            }
        } else {
            return redirect('/');
        }
    }

    public function dashboardByPartner(){
        //var_dump(session('SES_USER_MENU'));
        if (Auth::check()) {
            $data['auth_id'] = session('SES_AUTH_ID');
            $arrayMainScreen = User::getAuthMainScreen($data);

            if ($arrayMainScreen[0]->url == 'dashboardByPartner') {
                $data['partner_id']=Auth::user()->partner_id;
                $data['complaints_pending'] = Complaint::getPendingComplaintsByPartner($data);
                $data['complaints_solved'] = Complaint::getSolvedComplaintsByPartner($data);
                $data['complaints_registered'] = Complaint::getRegisteredComplaintsByPartner($data);
                return view('dashboard.dashboardByPartner',compact('data'));
            } else {
                return redirect($arrayMainScreen[0]->url);
            }
        }
        else{
           return redirect('/');
        }
    }


    public function users()
    {
        if (!Auth::check()) {
            return redirect('/');
        } else {
            return view('users.usersReport');
        }
    }

    public function newUser()
    {
        if (!Auth::check()) {
            return redirect('/');
        } else {
            $data['array_auth']=AuthLevel::where('auth_active',1)
                  ->orderBy('auth_id','asc')->get();

            $data['array_departments']=Department::where('department_active',1)
                ->orderBy('department_id','asc')->get();

            return view('users.newUserForm',compact('data'));
        }
    }

    public function stores()
    {
        if (!Auth::check()) {
            return redirect('/');
        } else {
            return view('stores.storesReport');
        }
    }


    public function storesByPartner()
    {
        if (!Auth::check()) {
            return redirect('/');
        } else {
            return view('stores.storesReportByPartner');
        }
    }

    public function customers()
    {
        if (!Auth::check()) {
            return redirect('/');
        } else {
            return view('customers.customersReport');
        }
    }

    public function newComplaint()
    {
        if (!Auth::check()) {
            return redirect('/');
        } else {
            $data['array_categories'] = Category::where('category_active', 1)
            ->orderBy('category_id', 'asc')->get();

            $data['array_groups'] = Group::where('group_active', 1)
            ->orderBy('group_id', 'asc')->get();

            $data['array_departments'] = Department::where('department_active', 1)
            ->orderBy('department_id', 'asc')->get();

            $data['array_priority'] = Priority::where('priority_active', 1)
            ->orderBy('priority_id', 'asc')->get();

            return view('complaints.newComplaintForm', compact('data'));
        }
    }

    public function newComplaintByPartner()
    {
        if (!Auth::check()) {
            return redirect('/');
        } else {
            $data['array_categories'] = Category::where('category_active', 1)
            ->orderBy('category_id', 'asc')->get();

            $data['array_stores'] = RelUserStore::where('partner_id', Auth::user()->user_id)
            ->orderBy('store_id', 'asc')->get();

            $data['array_groups'] = Group::where('group_active', 1)
            ->orderBy('group_id', 'asc')->get();

            $data['array_departments'] = Department::where('department_active', 1)
            ->orderBy('department_id', 'asc')->get();

            $data['array_priority'] = Priority::where('priority_active', 1)
            ->orderBy('priority_id', 'asc')->get();

            return view('complaints.newComplaintFormByPartner', compact('data'));
        }
    }

    public function complaintReport()
    {
        if (!Auth::check()) {
            return redirect('/');
        } else {
            $data['array_stores']=Store::where('vigencia_db_unidad', 1)
                ->orderBy('id_unidad','asc')->get();
            session(['SessionHtmlView'=> 'complaintReport']);
            return view('complaints/complaintReport',compact('data'));
        }
    }

    public function complaintReportByPartner(){
        if (!Auth::check()) {
            return redirect('/');
        } else {
            return view('complaints.complaintReportByPartner');
        }
    }

    public function complaintSuccess($complaint_id){
        if (Auth::check()) {
            $rowEmail=array();
            $arrayEmail=array();
            $data['complaint_id'] = $complaint_id;

            $arrayComplaint = Complaint::getComplaintById($data);
            $relStore = RelUserStore::where('store_id',$arrayComplaint[0]->store_id)->where('supervisor_id','>',0)->first();
            //dd($relStore);
            $arraySupervisor = User::where('supervisor_id', $relStore->supervisor_id)->first();
            //dd($arraySupervisor);
            $data['arraySupervisor']=$arraySupervisor;
            //email
            $rowEmail['email']=$arraySupervisor->email;
            array_push($arrayEmail,$rowEmail);
            $dataManager = RelManagerSupervisor::where('supervisor_id', $relStore->supervisor_id)->first();
            $arrayManager = User::where('manager_id', $dataManager->manager_id)->first();
           // dd($arrayManager);
            ///email manager zone
            $rowEmail['email']=$arrayManager->email;
            array_push($arrayEmail,$rowEmail);
            $data['arrayManager']=$arrayManager;
            //email manager area
            $arrayDepartment = Department::where('department_id', $arrayComplaint[0]->department_id)->first();
            $data['arrayDepartment']=$arrayDepartment;
            $rowEmail['email']=$arrayDepartment->deparment_email;
            array_push($arrayEmail,$rowEmail);
            $data['arrayEmails']=(!empty($arrayEmail))?$arrayEmail:null;

            if (!empty($arrayComplaint)) {
                $data['arrayComplaint'] = $arrayComplaint;
                return view('complaints.complaintPartnerSuccess', compact('data'));
            } else {
                return redirect('/');
            }
        } else {
            return redirect('/');
        }
    }
    //suggestions..
    public function newSuggestion(){
        if (!Auth::check()) {
            return redirect('/');
        } else {

            $data['array_groups'] = Group::where('group_active', 1)
                ->orderBy('group_id', 'asc')->get();
            return view('suggestions.newSuggestionForm', compact('data'));
        }
    }

    public function suggestionReport(){
        if (!Auth::check()) {
            return redirect('/');
        } else {
            return view('suggestions/suggestionReport');
        }
    }

    //congratulations..
    public function congratulationReport(){
        if (!Auth::check()) {
            return redirect('/');
        } else {
            return view('congratulations/congratulationReport');
        }
    }
    public function newCongratulation(){
        if (!Auth::check()) {
            return redirect('/');
        } else {
            $data['array_groups'] = Group::where('group_active', 1)
                ->orderBy('group_id', 'asc')->get();
            return view('congratulations.newCongratulationForm', compact('data'));
        }
    }

    //survey..
    public function surveyJson(){
        $data['survey_id'] = 5;
        $dataSurvey['arrayDetailSurvey']= Survey::getDetailSurveyById($data);
        $dataSurvey['survey_id']=5;
        $arraySurvey= \Main::parsingArrayDetailSurvey($dataSurvey);
        echo '<pre>';
        print_r($arraySurvey);
        echo '</pre>';
    }

    public function profileByPartner(){
        if (!Auth::check()) {
            return redirect('/');
        } else {
            $data['array_user']=User::where('user_id',Auth::user()->user_id)->get();
            return view('profile.profileFormByPartner',compact('data'));
        }
    }

    public function profile(){
        if (!Auth::check()) {
            return redirect('/');
        } else {
            $data['array_user']=User::join('auth','users.auth_id','=','auth.auth_id')
            ->where('user_id',Auth::user()->user_id)->first();
            $data['array_auth']=AuthLevel::where('auth_id',session('SES_AUTH_ID'))->first();
            return view('profile.profileForm',compact('data'));
        }
    }

    //supervisors by manager

    public function supervisorsByManager(){
        if (!Auth::check()) {
            return redirect('/');
        } else {
            return view('users.supervisorsReportByManager');
        }
    }

}
