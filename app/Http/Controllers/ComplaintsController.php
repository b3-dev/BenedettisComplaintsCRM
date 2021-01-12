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
use App\Store;
use App\Complaint;
use Session;
use App\Helpers\Main;

class ComplaintsController extends Controller
{
    //
    //complaints..
    public function complaintReportBySupervisor(Request $request)
    {
        if (Auth::check()) {
            try {

                // $User = User::where('user_id', Auth::user()->user_id)->first();
                $totalStores = RelUserStore::where('supervisor_id', Auth::user()->supervisor_id)
                                ->where('rel_user_active',1)->count();
                $dataSearch['supervisor_id'] = Auth::user()->supervisor_id;
                $dataSearch['offset'] = 0;
                $dataSearch['limit'] = $totalStores;
                $dataSearch['sort'] = 'store_id';
                $dataSearch['order'] = 'asc';
                $arrayStores = Store::getStoresBySupervisor($dataSearch);
                $arrayParsingStores = \Main::parsingStoresByPartner($arrayStores);
                $data['array_stores']=$arrayParsingStores;
               /// dd($arrayParsingStores);
                $data['supervisor_id'] = Auth::user()->supervisor_id;
                $data['pendingsComplaint'] = count(Complaint::getPendingComplaintsBySupervisor($data));
                session(['SessionHtmlView'=> 'complaintReportBySupervisor']);

                return view('complaints/complaintReportBySupervisor',compact('data'));
            } catch (\Exception $e) {
                echo $e->getMessage();
                //return redirect('/');
            }
        } else {
            return redirect('/');
        }
    }

    public function complaintReportByManager(Request $request)
    {
        if (Auth::check()) {
           // $User = User::where('user_id', Auth::user()->user_id)->first();
           $totalStores = RelUserStore::where('manager_id', Auth::user()->manager_id)
                            ->where('rel_user_active',1)->count();

           $dataSearch['manager_id'] = Auth::user()->manager_id;
           $dataSearch['offset'] = 0;
           $dataSearch['limit'] = $totalStores;
           $dataSearch['sort'] = 'store_id';
           $dataSearch['order'] = 'asc';
           $arrayStores = Store::getStoresByManager($dataSearch);
           $arrayParsingStores = \Main::parsingStoresByPartner($arrayStores);
           $data['array_stores']=$arrayParsingStores;

            $data['manager_id'] = Auth::user()->manager_id;
            $data['pendingsComplaint'] = count(Complaint::getPendingComplaintsByManager($data));
            session(['SessionHtmlView'=> 'complaintReportByManager']);
            return view('complaints/complaintReportByManager',compact('data'));
        }else{
            return redirect('/');
        }

    }

    public function complaintReportByManagerArea(Request $request)
    {
        if (Auth::check()) {

           $data['array_stores']=Store::where('vigencia_db_unidad', 1)
           ->orderBy('id_unidad','asc')->get();
            $data['department_id'] = Auth::user()->department_id;
            $data['pendingsComplaint'] = count(Complaint::getPendingComplaintsByManagerArea($data));
            $dataDepartment=Department::where('department_id',Auth::user()->department_id)->get('department_description')->first();
            $data['department_name']=(!empty($dataDepartment->department_description))?$dataDepartment->department_description:'N/A';
            session(['SessionHtmlView'=> 'complaintReportByManagerArea']);
            return view('complaints/complaintReportByManagerArea',compact('data'));
        }else{
            return redirect('/');
        }

    }

    public function createComplaintSolution($complaint_id){
        if (Auth::check()) {
            try {

                $data['complaint_id'] = $complaint_id;
                $data['HtmlViewReturn']=(!empty(session('SessionHtmlView')))?session('SessionHtmlView'):'/';
                $dataComplaint = Complaint::getComplaintById($data);
                if ($dataComplaint[0]->status_id == 1) { //si está pendiente
                    $arrayComplaint = \Main::parsingArrayComplaints($dataComplaint);
                    if (!empty($arrayComplaint)) {
                        $data['arrayComplaint'] = $arrayComplaint[0];
                        return view('complaints.solveComplaintForm', compact('data'));
                    } else {
                        return redirect('/');
                    }
                } else {
                    return redirect('/');
                }
            } catch (\Exception $e) {
                return redirect('/');
            }


        } else {
            return redirect('/');
        }
    }

    public function complaintSolvedSuccess($complaint_id){
        if (Auth::check()) {
            $data['complaint_id'] = $complaint_id;
            $arrayComplaint = Complaint::getComplaintById($data);
            $data['HtmlViewReturn']=(!empty(session('SessionHtmlView')))?session('SessionHtmlView'):'/';

            if (!empty($arrayComplaint)) {
                $data['arrayComplaint'] = $arrayComplaint;
                return view('complaints.complaintSolvedSuccess', compact('data'));
            } else {
                return redirect('/');
            }
        } else {
            return redirect('/');
        }
    }

    public function complaintPDF($complaint_id)
    {
        try {
            $data['user_name'] = Auth::user()->first_name . ' ' . Auth::user()->last_name;
            $data['complaint_id'] = intval($complaint_id);
            $dataComplaint = Complaint::getComplaintById($data);
            $arrayComplaint = \Main::parsingArrayComplaints($dataComplaint);
            //  dd($arrayComplaint);
            if (!empty($arrayComplaint)) {
                $pdf = app('dompdf.wrapper');
                \PDF::setOptions(['defaultFont' => 'Roboto-Regular']);
                $data['arrayComplaint'] = $arrayComplaint[0];
                $pdf = \PDF::loadView('pdfTemplates/complaintTemplate', $data);
                //$pdf->loadHTML('<h1>Styde.net</h1>');
                return $pdf->download('solicitud_'.$complaint_id.'.pdf');
            } else {
                echo 'not found.';
                //return redirect('/');
            }
        } catch (\Exception $e) {
            return redirect('/');
        }
    }
}
