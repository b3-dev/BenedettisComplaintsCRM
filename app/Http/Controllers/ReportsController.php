<?php

namespace App\Http\Controllers;

use App\Category;
use App\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Main;
use App\Report;

class ReportsController extends Controller
{
    //

    public function reports(){
        if (!Auth::check()) {
            return redirect('/');
            //$data
        }
        else{

            $operativeDay = \Main::dateToOperativeDay(date('Y-m-d'));
            //RETURN EJEM:2020251
            $dayNumber = substr($operativeDay, 4, 3);
            //RETURN EJEM:251
            $periodWeekDay = \Main::getPSD($dayNumber);
            $actualPeriod=$periodWeekDay['PERIODO'];
            $actualPeriodInit=1;
            $pastPeriodInit=0;
            //$actualYear=date('Y');

            if($actualPeriod==1){
                $pastPeriod=14; //last yeard period,
                $actualPeriodInit=1;
                $pastPeriodInit=14;
              //  $pastYear=$actualYear-1;
            }
            else{
                $pastYear=date('Y');
                $pastPeriod=$actualPeriod-1;
                $pastPeriodInit=1;
            }
            $data['PP']=$pastPeriod;
            $data['PPInit']=$pastPeriodInit;
            $data['PA']=$actualPeriod;
            $data['PAInit']=$actualPeriodInit;

            return view('reports/reportsForm',compact('data'));
        }
    }

    public function processorReport(Request $request){
        if (!Auth::check()) {
            return redirect('/');
            //$data
        }
        else{
            /*<option value="1">Por tipo </option>
                            <option value="2">Supervisor/Gerente de zona </option>
                            <option value="3">Por zona </option>
                            <option value="4">UBE's con más quejas </option>*/
            if(!empty($request->input('post_type_report')) && intval($request->input('post_type_report'))>0 ){
                switch($request->input('post_type_report')){
                    case 1: //1">Por tipo </option>
                        $pp=$request->post_pp;
                        $pa=$request->post_pa;
                        $year_pa=date('Y');
                        $year_pp=($request->post_pa==1 && $request->post_pp==14 )?date('Y')-1:date('Y');
                        $arrayCategory=Category::where('category_active',1)->orderBy('category_id','ASC')->get();
                        $rowPerType=array();
                        $arrayPerType=array();
                        if(!empty($arrayCategory) && count($arrayCategory)>0){

                            //GET TOTAL PP COMPLAINTS CLIENTS
                            $data['YEAR']=$year_pp;
                            $data['PERIOD']=$pp;
                            $data['PERIOD_PP']=$pp;

                            $totalComplaintsPP=intval(Complaint::getTotalComplaintsPerPeriod($data));

                            $data['YEAR']=$year_pa;
                            $data['PERIOD']=$pa;
                            $data['PERIOD_PA']=$pa;

                            $totalComplaintsPA=intval(Complaint::getTotalComplaintsPerPeriod($data));

                            foreach($arrayCategory as $rowCategory){
                                $rowPerType['CATEGORY_DESCRIPTION']=$rowCategory->category_description;

                                $data['CATEGORY_ID']=$rowCategory->category_id; //CALIDAD DE SERVICIO
                                $data['YEAR']=$year_pp;
                                $data['PERIOD']=$pp;
                                $countPP=Complaint::getTotalComplaintsPerCategoryId($data);
                                @$percentPP=($countPP*100)/$totalComplaintsPP;
                                $percentPP=($percentPP>0)?$percentPP:0;
                                $data['YEAR']=$year_pa;
                                $data['PERIOD']=$pa;
                                $countPA=Complaint::getTotalComplaintsPerCategoryId($data);
                                @$percentPA=($countPA*100)/$totalComplaintsPA;
                                $percentPA=($percentPA>0)?$percentPA:0;

                                //LLENANDO TOTALES POR CATEGORIA
                                $rowPerType['COUNT_PP']=$countPP;
                                $rowPerType['PERCENT_PP']=round($percentPP,1);
                                $rowPerType['COUNT_PA']=$countPA;
                                $rowPerType['PERCENT_PA']=round($percentPA,1);
                                $rowPerType['VARIANCE']=$countPA-$countPP;

                                array_push($arrayPerType,$rowPerType);
                            }//endforeach
                            $data['arrayPerType']=$arrayPerType;
                            return view('reports/byTypeReport',compact('data'));

                        }
                        else{
                            echo 'Ocurrió un error al obtener los datos';
                        }

                        //QUEJAS DE SERVICIO




                    break;
                    case 1:break;

                }
            }
            else{
                return redirect('reports');
            }

            return view('reports/reportsForm',compact('data'));
        }
    }
}
