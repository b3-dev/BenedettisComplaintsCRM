<?php
//app/Helpers/Main.php
namespace App\Helpers;
use Illuminate\Support\Collection as Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Store;
use App\User;
use App\Complaint;
use App\Customer;
use App\Department;
use App\RelManagerSupervisor;
use App\RelUserStore;
use App\Survey;

class Main
{

    public static function parsingArrayUsers($array){
        if(!empty($array)){
            $rowUser=array();
            $arrayUser=array();
            foreach ($array as $row) {
                if(intval($row->department_id)>0){
                    @$DBDepartment = Department::where('department_id', $row->department_id)->get();
                    $departmentName = (!empty($DBDepartment) && count($DBDepartment) > 0) ? $DBDepartment[0]->department_description : 'N/A';
                }
                else{
                    $departmentName = 'N/A';
                }

                $rowUser['user_id'] = $row->user_id;
                $rowUser['supervisor_id'] = $row->supervisor_id;
                $rowUser['manager_id'] = $row->manager_id;
                $rowUser['department_id'] = $row->department_id;
                $rowUser['data_department'] = $departmentName;
                $rowUser['first_name'] = $row->first_name;
                $rowUser['last_name'] = $row->last_name;
                $rowUser['email'] = $row->email;
                $rowUser['password'] = $row->password;
                $rowUser['user_active'] = $row->user_active;
                $rowUser['phone'] = $row->phone;
                $rowUser['auth_id'] = $row->auth_id;
                $rowUser['created_at'] = $row->created_at;
                $rowUser['updated_at'] = $row->updated_at;
                $rowUser['auth_description'] = $row->auth_description;
                $rowUser['auth_active'] = $row->auth_active;
                $rowUser['sort_auth'] = $row->sort_auth;

                array_push($arrayUser, $rowUser);
            }
            return $arrayUser;
        }
        else
        return null;
    }

    public static function parsingArrayDetailSurvey($array){
        $subRowSurvey= array();
        $rowSurvey= array();
        $rowAnswerSurvey= array();
        $subRowCuestion=array();
        $arraySurvey = array();
        $arrayFullArray=array();
        if (!empty($array)) {
            $recordSurvey=Survey::getSurveyById($array);
            $DBPartner=User::where('partner_id',$recordSurvey->partner_id)->first();
            $partnerName=(!empty($DBPartner) )?$DBPartner->first_name.' '.$DBPartner->last_name:'Sin datos';
            //arraySurvey is principal
            $arraySurvey['survey_id']=$recordSurvey->survey_id;
            $arraySurvey['survey_folio']=str_pad($recordSurvey->survey_id, 7, "0", STR_PAD_LEFT);
            $arraySurvey['complaint_folio']=str_pad($recordSurvey->complaint_id, 7, "0", STR_PAD_LEFT);
            $arraySurvey['partner_data']=$partnerName;
            $arraySurvey['comment_survey']=(strlen($recordSurvey->comment_survey)>1)?$recordSurvey->comment_survey:'Sin comentarios';
            $arraySurvey['register_survey_date']=$recordSurvey->register_survey_date;
            $arraySurvey['cuestions']=array();
            //getAnswers byCuestions..
            foreach($array['arrayDetailSurvey'] as $rowDetail){
                $data['cuestion_id']=$rowDetail->cuestion_id;
                $arrayAnswers=Survey::getAnswersByCuestion($data);

                //subrowCuestion is row to array cuestion
                $subRowCuestion['cuestion_id']=$rowDetail->cuestion_id;
                $subRowCuestion['text']=$rowDetail->cuestion_description;
                $subRowCuestion['answers']=array();
                foreach($arrayAnswers as $rowAnswers){

                    $rowAnswerSurvey['answer_id']=$rowAnswers->answer_id;
                    $rowAnswerSurvey['text']=$rowAnswers->answer_description;
                    $rowAnswerSurvey['selected']=($rowAnswers->answer_id==$rowDetail->answer_id)?'true':'false';
                    array_push($subRowCuestion['answers'],$rowAnswerSurvey);
                }

                array_push($arraySurvey['cuestions'],$subRowCuestion);

            }

            // array_push($arraySurvey,$subRowSurvey);


            array_push($arrayFullArray,$arraySurvey);


            return $arrayFullArray;

        }
        else
        return null;
    }

    public static function parsingArraySurveys($array)
    {
        $rowSurvey = array();
        $arraySurvey = array();
        if (!empty($array)) {
            foreach ($array as $row) {
                if(intval($row->partner_id)>0){
                @$DBUser = User::where('partner_id', $row->partner_id)->get();
                    $userName = (!empty($DBUser) && count($DBUser) > 0) ? $DBUser[0]->first_name . ' ' . $DBUser[0]->last_name : 'Sin datos';
                } else {
                    $userName = 'Sin datos';
                }
                $rowSurvey['survey_id'] = $row->survey_id;
                $rowSurvey['survey_folio'] = str_pad( $row->survey_id, 7, "0", STR_PAD_LEFT);
                $rowSurvey['partner_id'] = $row->partner_id;
                $rowSurvey['partner_name_data'] = $userName;
                $rowSurvey['complaint_id'] = $row->complaint_id;
                $rowSurvey['complaint_folio'] = str_pad($row->complaint_id, 7, "0", STR_PAD_LEFT);
                $rowSurvey['comment_survey'] = (strlen($row->comment_survey)+3>30)?Str::limit($row->comment_survey, 27, '...'):$row->comment_survey;
                $rowSurvey['comment_survey'] = (strlen(trim($rowSurvey['comment_survey'])) >1)?$rowSurvey['comment_survey']:'Sin comentarios';
                $rowSurvey['register_survey_date'] = $row->register_survey_date;

                array_push($arraySurvey, $rowSurvey);
            }

            return $arraySurvey;
        } else {
            return null;
        }
    }

    public static function parsingArraySuggestions($array){
        $rowSuggestion= array();
        $arraySuggestion = array();
        if (!empty($array)) {
            foreach ($array as $row) {

                @$DBUser=User::where('user_id',$row['user_id'])->get();
                $userName=(!empty($DBUser)&& count($DBUser)>0)?$DBUser[0]->first_name.' '.$DBUser[0]->last_name:'Sin datos';
                ;
                if($row['group_id']==1){
                    //1 cliente, 2 asociado
                    $rowName=Customer::where('customer_id',$row['customer_id'])->get();
                    $nameData=(!empty($rowName) && count($rowName)>0)?$rowName[0]->customer_first_name.' '.$rowName[0]->customer_last_name:'Sin datos';
                    $emailData=(!empty($rowName) && !empty($rowName[0]->customer_email))?$rowName[0]->customer_email:'Sin datos';

                }
                elseif($row['group_id']==2) {
                    //asociado..
                    @$rowName=User::where('partner_id',$row['partner_id'])->get();
                    $nameData=(!empty($rowName) && count($rowName)>0)?$rowName[0]->first_name.' '.$rowName[0]->last_name:'Sin datos';
                    $emailData=(!empty($rowName) && !empty($rowName[0]->email))?$rowName[0]->email:'Sin datos';

                }

                $rowSuggestion['suggestion_id']=$row['suggestion_id'];
                $rowSuggestion['suggestion_folio']=str_pad($row['suggestion_id'], 7, "0", STR_PAD_LEFT);
                $rowSuggestion['group_id']=$row['group_id'];
                $rowSuggestion['group_description']=$row['group_description'];
                $rowSuggestion['customer_type']=($row['group_id']==2)?'Asociado':'Cliente';
                $rowSuggestion['name_data']=$nameData;
                $rowSuggestion['email_data']=$emailData; //customer email
                $rowSuggestion['user_name_data']=$userName;
                $rowSuggestion['suggestion_description']=(strlen($row['suggestion_description'])+3>30)?Str::limit($row['suggestion_description'], 27, '...'):$row['suggestion_description'];
                $rowSuggestion['suggestion_description_full']=$row['suggestion_description'];
                $rowSuggestion['register_date']=$row['register_date'];

                array_push($arraySuggestion, $rowSuggestion);
            }

            return $arraySuggestion;
        } else {
            return null;
        }
    }

    public static function parsingArrayCongratulations($array){
        $rowCongratulations= array();
        $arrayCongratulation = array();
        if (!empty($array)) {
            foreach ($array as $row) {

                $DBUser=User::where('user_id',$row['user_id'])->get();
                $userName=(!empty($DBUser)&& count($DBUser)>0)?$DBUser[0]->first_name.' '.$DBUser[0]->last_name:'Sin datos';

                if($row['group_id']==1){
                    //1 cliente, 2 asociado
                    $rowName=Customer::where('customer_id',$row['customer_id'])->get();
                    $nameData=(!empty($rowName) && count($rowName)>0)?$rowName[0]->customer_first_name.' '.$rowName[0]->customer_last_name:'Sin datos';
                    $emailData=(!empty($rowName) && !empty($rowName[0]->customer_email))?$rowName[0]->customer_email:'Sin datos';

                }
                elseif($row['group_id']==2) {
                    //asociado..
                    @$rowName=User::where('partner_id',$row['partner_id'])->get();
                    $nameData=(!empty($rowName && count($rowName)>0))?$rowName[0]->first_name.' '.$rowName[0]->last_name:'Sin datos';
                    $emailData=(!empty($rowName) && !empty($rowName[0]->email))?$rowName[0]->email:'Sin datos';

                }

                $rowCongratulations['congratulation_id']=$row['congratulation_id'];
                $rowCongratulations['congratulation_folio']=str_pad($row['congratulation_id'], 7, "0", STR_PAD_LEFT);
                $rowCongratulations['group_id']=$row['group_id'];
                $rowCongratulations['group_description']=$row['group_description'];
                $rowCongratulations['customer_type']=($row['group_id']==2)?'Asociado':'Cliente';
                $rowCongratulations['name_data']=$nameData;
                $rowCongratulations['email_data']=$emailData; //customer email
                $rowCongratulations['user_name_data']=$userName;
                $rowCongratulations['congratulation_description']=(strlen($row['congratulation_description'])+3>30)?Str::limit($row['congratulation_description'], 27, '...'):$row['congratulation_description'];
                $rowCongratulations['congratulation_description_full']=$row['congratulation_description'];
                $rowCongratulations['register_date']=$row['register_date'];

                array_push($arrayCongratulation, $rowCongratulations);
            }

            return $arrayCongratulation;
        } else {
            return null;
        }
    }
    public static function parsingArrayComplaints($array){
        $rowComplaint = array();
        $arrayComplaint = array();
        if (!empty($array)) {
            foreach ($array as $row) {

                $DBUser=User::where('user_id',$row['user_id'])->get();
                $userName=(!empty($DBUser)&& count($DBUser)>0)?$DBUser[0]->first_name.' '.$DBUser[0]->last_name:'Sin datos';

                $DBStore=Store::where('id_unidad',$row['store_id'])->get();
                $storeName=(!empty($DBStore)&& count($DBStore)>0)?$DBStore[0]->id_unidad.' '.$DBStore[0]->nombre_unidad:'Sin datos';
                //GET SUPERVISOR_NAME
                @$DBSupervisor=User::where('supervisor_id',$row['supervisor_id'])->get();
                $supervisorName=(!empty($DBSupervisor)&& count($DBSupervisor)>0)?$DBSupervisor[0]->first_name.' '.$DBSupervisor[0]->last_name:'Sin datos';

                @$DBManager=RelManagerSupervisor::getManagerBySupervisor($row);
                $managerName=(!empty($DBManager)&& count($DBManager)>0)?$DBManager[0]->first_name.' '.$DBManager[0]->last_name:'Sin datos';

                if($row['group_id']==1){
                    //1 cliente, 2 asociado
                    $rowName=Customer::where('customer_id',$row['customer_id'])->get();
                    $nameData=(!empty($rowName) && count($rowName)>0)?$rowName[0]->customer_first_name.' '.$rowName[0]->customer_last_name:'Sin datos';
                    $emailData=(!empty($rowName) && !empty($rowName[0]->customer_email))?$rowName[0]->customer_email:'Sin datos';
                    $phoneData=(!empty($rowName) && !empty($rowName[0]->customer_phone))?$rowName[0]->customer_phone:'Sin datos';

                }
                elseif($row['group_id']==2) {
                    //asociado..
                    $rowName=User::where('partner_id',$row['partner_id'])->get();
                    //dd(empty($rowName));
                    $nameData=(!empty($rowName) && count($rowName)>0)?$rowName[0]->first_name.' '.$rowName[0]->last_name:'Sin datos';
                    $emailData=(!empty($rowName) && !empty($rowName[0]->email))?$rowName[0]->email:'Sin datos';
                    $phoneData=(!empty($rowName) && !empty($rowName[0]->phone))?$rowName[0]->phone:'Sin datos';
                }
                if($row->department_id>0){
                    $DBDepartment=Department::where('department_id',$row->department_id)->first();
                    $departmentName=$DBDepartment->department_description;
                }
                else{
                    $departmentName='Sin datos';
                }


                $departmentId=$row->department_id;
                $rowComplaint['complaint_id']=$row['complaint_id'];
                $rowComplaint['complaint_folio']=str_pad($row['complaint_id'], 7, "0", STR_PAD_LEFT);
                $rowComplaint['group_id']=$row['group_id'];
                $rowComplaint['group_description']=$row['group_description'];
                $rowComplaint['customer_type']=($row['group_id']==2)?'Asociado':'Cliente';
                $rowComplaint['name_data']=$nameData; //customer name
                $rowComplaint['email_data']=$emailData; //customer email
                $rowComplaint['phone_data']=$phoneData; //customer phone

                $rowComplaint['store_data']=$storeName;
                $rowComplaint['supervisor_data']=$supervisorName;
                $rowComplaint['manager_data']=$managerName;
                $rowComplaint['user_name_data']=$userName;
                $rowComplaint['complaint_description']=(strlen($row['complaint_description'])+3>30)?Str::limit($row['complaint_description'], 27, '...'):$row['complaint_description'];
                $rowComplaint['complaint_description_full']=$row['complaint_description'];
                $rowComplaint['complaint_solution']=(strlen($row['complaint_solution'])+3>30)?Str::limit($row['complaint_solution'], 27, '...'):$row['complaint_solution'];
                $rowComplaint['complaint_solution_full']=(strlen($row['complaint_solution'])>1)?$row['complaint_solution']:'Aún no se ha generado respuesta a la solicitud';

                $rowComplaint['register_date']=$row['register_date'];
                $rowComplaint['solved_date']=(($row['solved_date']!='0000-00-00 00:00:00') && $row['solved_date']!='' )?$row['solved_date']:'-';
                $rowComplaint['status_description']=$row['status_description'];
                $rowComplaint['status_id']=$row['status_id'];
                $rowComplaint['priority_description']=$row['priority_description'];
                $rowComplaint['category_request_id']=$row['category_request_id'];

                $rowComplaint['category_description']=$row['category_description'];
                $rowComplaint['department_id']= $departmentId;
                $rowComplaint['department_description']=$departmentName;
               // dd($rowComplaint);

                $rowComplaint['description_request']=$row['description_request'];
                $rowComplaint['name_zone']=$row['name_zone'];
                array_push($arrayComplaint, $rowComplaint);
            }

            return $arrayComplaint;
        } else {
            return null;
        }
    }
    public static function parsingStoresByPartner($array){

        $rowStores = array();
        $arrayStores = array();
        if (!empty($array)) {
            foreach ($array as $row) {
                $DBStore=Store::where('id_unidad',$row->store_id)->get();
                if(!empty($DBStore)){
                    $rowStores['id_unidad'] = $DBStore[0]->id_unidad;
                    $rowStores['nombre_unidad']=$DBStore[0]->nombre_unidad;
                    $rowStores['domicilio_unidad']=$DBStore[0]->domicilio_unidad;
                    $rowStores['colonia_unidad']=$DBStore[0]->colonia_unidad;
                    $rowStores['codigo_postal_unidad']=$DBStore[0]->codigo_postal_unidad;
                    $rowStores['telefono_unidad']=$DBStore[0]->telefono_unidad;
                    array_push($arrayStores, $rowStores);
                }
            }
            return $arrayStores;
        } else {
            return null;
        }
    }
    public static function parsingArrayStores($array)
    {
        $rowStores = array();
        $arrayStores = array();
        if (!empty($array)) {
            foreach ($array as $row) {
                $DBStore=Store::where('id_unidad',$row['store_id'])->where('vigencia_db_unidad',1)->get();
                if(!empty($DBStore)){
                    $rowStores['store_id'] = $DBStore[0]->id_unidad;
                    $rowStores['store_name']=$DBStore[0]->nombre_unidad;
                    array_push($arrayStores, $rowStores);
                }
            }
            return $arrayStores;
        } else {
            return null;
        }
    }

    public static function getStrFolio($id){
        $folio= str_pad($id, 7, "0", STR_PAD_LEFT);
        return $folio;
    }

    public static function strReplaceChars($str)
    {
        //Codificamos la cadena en formato utf8 en caso de que nos de errores
        // $cadena = utf8_encode($cadena);

        //Ahora reemplazamos las letras
        $str = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $str
        );

        $str = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $str
        );

        $str = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $str
        );

        $str = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $str
        );

        $str = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $str
        );

        $str = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'),
            array('n', 'N', 'c', 'C'),
            $str
        );

        return $str;
    }
    //operativeDay functions
    public static function dateToOperativeDay($fecha,$in_chr='-'){
        $y = strtok($fecha, $in_chr);
        $m = strtok($in_chr);
        $d = strtok($in_chr);
        return sprintf("%04d%03d",$y,(date("z",mktime(0,0,0,$m,$d,$y))+1));
    }

    public static function getPSD($dayNumber) {
        $d = $dayNumber % 7;
        $s = intval($dayNumber / 7) % 4 + 1;
        $p = intval(($dayNumber / 7) / 4) + 1;
        if (!$d) {$d=7; $s--;}
        if (!$s) {$s=4; $p--;}
        $array= array('PERIODO'=>$p,'SEMANA'=>$s,'DIA'=>$d);
        return $array;
    }


}
