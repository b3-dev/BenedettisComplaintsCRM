<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\AuthLevel;
use App\Category;
use App\Department;
use App\Group;
use App\Priority;
use App\RelUserStore;
use App\Survey;
use App\User;
use App\Complaint;
use Session;
use App\Helpers\Main;

class SurveyController extends Controller
{
    //

    public function surveyPDF($survey_id)
    {
        //try {

            $data['user_name'] = Auth::user()->first_name . ' ' . Auth::user()->last_name;
            $data['survey_id'] = $survey_id;
            $dataSurvey['arrayDetailSurvey']= Survey::getDetailSurveyById($data);
            $dataSurvey['survey_id']=$survey_id;
            $arraySurvey= \Main::parsingArrayDetailSurvey($dataSurvey);


            if (!empty($arraySurvey)) {
                $pdf = app('dompdf.wrapper');
                \PDF::setOptions(['defaultFont' => 'Roboto-Regular']);
                $data['arraySurvey'] = $arraySurvey[0];
               // dd($data);
                $pdf = \PDF::loadView('pdfTemplates/surveyTemplate', $data);

               // dd($pdf);
                //$pdf->loadHTML('<h1>Styde.net</h1>');
                return $pdf->download('encuesta_'.$survey_id.'.pdf');
            } else {
                echo 'not found.';
                //return redirect('/');
            }
        /*} catch (\Exception $e) {
            return redirect('/');
        }*/
    }


    public function surveyReport(){
        if (!Auth::check()) {
            return redirect('/');
        }
        else{
            return view('survey/surveyReport');

        }
    }
    public function newSurvey($complaint_id,$partner_id){

        try {
            if (Complaint::where('complaint_id', $complaint_id)->where('partner_id', $partner_id)->count() > 0) {
                if (!Survey::where('complaint_id', $complaint_id)->where('partner_id', $partner_id)->count() > 0) {
                    $User=User::where('partner_id',$partner_id)->first();
                    $data['array_cuestions'] = Survey::getCuestionsSurvey();
                    $data['complaint_folio'] = \Main::getStrFolio($complaint_id);
                    $data['user_id'] = $User->user_id;
                    $data['user_name']=$User->first_name;
                    $data['complaint_id'] = $complaint_id;
                    $data['partner_id'] = $partner_id;
                    $data['partner_id'] = $partner_id;
                    return view('survey/newSurveyForm', compact('data'));
                } else {

                    return view('survey/surveyWrong', compact('data'));
                }
            } else {
                return view('survey/surveyWrong', compact('data'));
                //return 'Solicitud no encontrada';
            }
        } catch (\Exception $e) {

            echo $e->getMessage();
            //return redirect('/');
        }
    }

    //create survey does not contain token
    public function createSurvey(Request $request){
        try {

            if (!empty($request->input('resp_cuestion'))) {

                //SAVE SURVEY..
                $dataSurvey['user_id'] = $request->user_id;
                $dataSurvey['partner_id'] = $request->partner_id;
                $dataSurvey['complaint_id'] = $request->complaint_id;
                $dataSurvey['comment_survey'] = trim(htmlentities(strip_tags($request->input('post_comment_survey'))));
                $dataSurvey['register_survey_date'] = date('Y-m-d H:i:s');

                $surveyCounter=Survey::getIfExistSurvey($dataSurvey);
                //$surveyCounter = 0;
                if (!$surveyCounter) {
                    $surveyId = Survey::createSurvey($dataSurvey);
                    $arrayRespCuestions = $request->input('resp_cuestion');
                    foreach ($arrayRespCuestions as $cuestion_id => $value) {
                        $dataResult['cuestion_id'] = $cuestion_id;
                        $dataResult['answer_id'] = $value;
                        $dataResult['survey_id'] = $surveyId;
                        $resultId = Survey::createResultSurvey($dataResult);
                        //dd('resultID'.$resultId);
                    }

                    if ($surveyId) {
                        return response()->json([
                            'success' => true,
                            'data' => \Main::getStrFolio($surveyId),
                            'msg' => 'La encuesta ' . \Main::getStrFolio($surveyId) . ' registrada correctamente',
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => false,
                        'msg' => 'Ya existe una encuesta para esta solicitud',
                    ]);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage(),
            ]);
        }
    }
}
