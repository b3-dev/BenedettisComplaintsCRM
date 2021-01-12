<?php
namespace App\Http\Controllers;

use App\AppConfigEmail;
use App\AuthLevel;
use App\User;
use App\Store;
use App\Complaint;
use App\Customer;
use App\Department;
use App\RelUserStore;
use App\Survey;
use App\Priority;
use App\RelManagerSupervisor;
use App\Category;
use App\CategoryRequest;
use App\Congratulation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Main;
use App\Suggestion;
use Illuminate\Support\Facades\App;
use Mail;

class ApiController extends Controller
{
    //
    public function getUsers(Request $request)
    {
        // return response()->json($request->user());
        try {
           //dd('aca');
            $dataUsers = User::getUsers();
            //dd($dataUsers);
            $arrayUsers = \Main::parsingArrayUsers($dataUsers);
            return response()->json([
                'total'=>count($arrayUsers),
                'totalNotFiltered'=>count($arrayUsers),
                'rows'=>$arrayUsers]);
         } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage(), 'success' => false]);
            //return $e->getMessage();
        }
    }

    public function getSupervisorsByManager(Request $request)
    {
        // return response()->json($request->user());
        try {
            $dataSearch['manager_id']=Auth::user()->manager_id;
            $dataSupervisors=RelManagerSupervisor::getSupervisorsByManager($dataSearch);
            $arrayUsers = \Main::parsingArrayUsers($dataSupervisors);
            return response()->json([
                'total'=>count($arrayUsers),
                'totalNotFiltered'=>count($arrayUsers),
                'rows'=>$arrayUsers]);
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage(), 'success' => false]);
            //return $e->getMessage();
        }
    }

    public function getUserById(Request $request){
        try{
            $arrayUser=User::where('user_id',$request->user_id)->first();
            $arrayAuth=AuthLevel::where('auth_active',1)->orderBy('auth_id','asc')->get();
            $arrayDepartment=Department::where('department_active',1)->orderBy('department_id','asc')->get();

            $data['array_user'] = $arrayUser;
            $data['array_auth']=$arrayAuth;
            $data['array_department']=$arrayDepartment;
            return response()->json([
                'success' => true,
                'msg' => 'Usuario obtenido correctamente',
                'data' => $data,
            ]);


        }catch(\Exception $e){
            return response()->json(['msg'=>$e->getMessage(),'success'=>false]);
        }
    }

    public function getStores(Request $request)
    {
        // return response()->json($request->user());
        try {

            $totalStores=Store::count();
            $dataSearch['search']=(!empty($request->input('search')))?$request->input('search'):'';
            $dataSearch['offset']=(!empty($request->input('offset')))?$request->input('offset'):0;
            $dataSearch['limit']=(!empty($request->input('limit')))?$request->input('limit'):$totalStores;
            $dataSearch['sort']=(!empty($request->input('sort'))?$request->input('sort'):'id_unidad');
            $dataSearch['order']=(!empty($request->input('order'))?$request->input('order'):'asc');
            $arrayStores = Store::getStores($dataSearch);
            return response()->json([
                'total'=>$totalStores,
                'totalNotFiltered'=>count($arrayStores),
                'rows'=>$arrayStores]);
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage(), 'success' => false]);
            //return $e->getMessage();
        }
    }

    public function getDepartments(Request $request){
        try{
            $arrayDepartments = Department::where('department_active', 1)->get(); //asociado..
            if (!empty($arrayDepartments)) {
                return response()->json([
                    'success' => true,
                    'msg' => 'Departamentos obtenidos correctamente',
                    'data' => $arrayDepartments
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'msg' => 'No hay datos disponibles',
                    'data' => null
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage(), 'success' => false]);
            //return $e->getMessage();
        }
    }
    public function getStoresByPartner(Request $request)
    {
        // return response()->json($request->user());
        try {

            //$totalStores=Store::count();
            $totalStores=RelUserStore::where('partner_id', Auth::user()->user_id)->count();
            $dataSearch['partner_id']=Auth::user()->user_id;
            $dataSearch['search']=(!empty($request->input('search')))?$request->input('search'):'';
            $dataSearch['offset']=(!empty($request->input('offset')))?$request->input('offset'):0;
            $dataSearch['limit']=(!empty($request->input('limit')))?$request->input('limit'):$totalStores;
            $dataSearch['sort']=(!empty($request->input('sort'))?$request->input('sort'):'store_id');
            $dataSearch['order']=(!empty($request->input('order'))?$request->input('order'):'asc');
            $arrayStores = Store::getStoresByPartner($dataSearch);
            $arrayParsingStores=\Main::parsingStoresByPartner($arrayStores);
            return response()->json([
                'total'=>$totalStores,
                'totalNotFiltered'=>count($arrayStores),
                'rows'=>$arrayParsingStores]);
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage(), 'success' => false]);
            //return $e->getMessage();
        }
    }

    public function getStoresBySupervisor(Request $request)
    {
        // return response()->json($request->user());
        try {

            //$totalStores=Store::count();
           // $User=User::where('user_id',Auth::user()->user_id)->first();
            $totalStores=RelUserStore::where('supervisor_id',Auth::user()->supervisor_id)->count();
            $dataSearch['supervisor_id']=Auth::user()->supervisor_id;
            $dataSearch['search']=(!empty($request->input('search')))?$request->input('search'):'';
            $dataSearch['offset']=(!empty($request->input('offset')))?$request->input('offset'):0;
            $dataSearch['limit']=(!empty($request->input('limit')))?$request->input('limit'):$totalStores;
            $dataSearch['sort']=(!empty($request->input('sort'))?$request->input('sort'):'store_id');
            $dataSearch['order']=(!empty($request->input('order'))?$request->input('order'):'asc');
            $arrayStores = Store::getStoresBySupervisor($dataSearch);
            $arrayParsingStores=\Main::parsingStoresByPartner($arrayStores);
            return response()->json([
                'total'=>$totalStores,
                'totalNotFiltered'=>count($arrayStores),
                'rows'=>$arrayParsingStores]);
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage(), 'success' => false]);
            //return $e->getMessage();
        }
    }

    public function getStoresByManager(Request $request)
    {
        // return response()->json($request->user());
        try {

            //$totalStores=Store::count();
            $totalStores=RelUserStore::where('manager_id', Auth::user()->manager_id)->count();
            $dataSearch['manager_id']=Auth::user()->manager_id;
            $dataSearch['search']=(!empty($request->input('search')))?$request->input('search'):'';
            $dataSearch['offset']=(!empty($request->input('offset')))?$request->input('offset'):0;
            $dataSearch['limit']=(!empty($request->input('limit')))?$request->input('limit'):$totalStores;
            $dataSearch['sort']=(!empty($request->input('sort'))?$request->input('sort'):'store_id');
            $dataSearch['order']=(!empty($request->input('order'))?$request->input('order'):'asc');
            $arrayStores = Store::getStoresByManager($dataSearch);
            $arrayParsingStores=\Main::parsingStoresByPartner($arrayStores);
            return response()->json([
                'total'=>$totalStores,
                'totalNotFiltered'=>$totalStores,
                'rows'=>$arrayParsingStores]);
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage(), 'success' => false]);
            //return $e->getMessage();
        }
    }

    public function storesByGroup(Request $request)
    {
        // return response()->json($request->user());
        try {
            $dataSearch['search']=$request->input('search');
            $arrayStores = Store::getStores($dataSearch);

            return response()->json([
                'total'=>Store::count(),
                'totalNotFiltered'=>count($arrayStores),
                'rows'=>$arrayStores]);
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage(), 'success' => false]);
            //return $e->getMessage();
        }
    }
    //suggestions...

    public function createSuggestion(Request $request)
    {
        try {

            //QUEJA TIPO CLIENTE=1, 2 ASOCIADO..
            $arrayEmails = array();
            $arrayToEmails = array();
            $rowEmails = array();
            $dataReturn = array();
            $operativeDay = \Main::dateToOperativeDay(date('Y-m-d'));
            //RETURN EJEM:2020251
            $dayNumber = substr($operativeDay, 4, 3);
            //RETURN EJEM:251
            $periodWeekDay = \Main::getPSD($dayNumber);
            //RETURN EJEM:P14S1D1
            // $relStore = RelUserStore::where('store_id', $request->post_store)->where('supervisor_id', '>', 0)->first();


            if ($request->post_group == 1) {
                //guardo el cliente primero
                $customer = new Customer();
                $customer->customer_first_name = trim(strip_tags($request->post_customer_first_name));
                $customer->customer_last_name = trim(strip_tags($request->post_customer_last_name));
                $customer->customer_phone = trim(strip_tags($request->post_customer_phone));
                $customer->customer_email = trim($request->post_customer_email);
                $customer->save();
                $customerId = $customer->id;
                //Insertando queja
                $suggestion = new Suggestion();
                $suggestion->group_id = $request->post_group;
                $suggestion->user_id = Auth::user()->user_id;
                $suggestion->customer_id = $customerId;
                $suggestion->register_date = date('Y-m-d H:i:s');
                $suggestion->period = $periodWeekDay['PERIODO'];
                $suggestion->operativeday_id = $operativeDay;
                $suggestion->suggestion_description = trim(strip_tags($request->post_description));
                $suggestion->partner_id = -1;

                ///QEJA Y SUGERENCIA QUEDAJ SEPARADOS..
            } else {
                $suggestion = new Suggestion();
                $suggestion->group_id = $request->post_group;
                $suggestion->customer_id = '-1';
                $suggestion->user_id = Auth::user()->user_id;
                $suggestion->partner_id = $request->post_partner;
                $suggestion->register_date = date('Y-m-d H:i:s');
                $suggestion->period = $periodWeekDay['PERIODO'];
                $suggestion->operativeday_id = $operativeDay;
                $suggestion->suggestion_description =  trim(strip_tags($request->post_description));
            }

            $suggestion->save();
            $dataReturn['suggestion_id'] = $suggestion->id;
            $dataReturn['suggestion_folio'] = str_pad($suggestion->id, 7, "0", STR_PAD_LEFT);

            if ($request->post_group == 2) {
                //Agregar datos del asociado
                $arrayPartner = User::where('partner_id', $request->post_partner)->first();
                $rowEmails['email'] = $arrayPartner->email;
                $arrayToEmails[] = $arrayPartner->email;
                array_push($arrayEmails, $rowEmails);
            }
            //test
            // $rowEmails['email'] = 'prueba@benedettis.com';
            // array_push($arrayEmails, $rowEmails);
            // $arrayToEmails[]='prueba@benedettis.com';
            //endtest
            $arrayEmailsReturn = array();
            array_push($arrayEmailsReturn, $arrayEmails);

            $dataReturn['suggestion_emails'] = $arrayEmailsReturn;
            $arrayReturn = array();
            array_push($arrayReturn, $dataReturn);
            //envio de email..
            //dd($arrayToEmails);
            $to =  $arrayToEmails; //email corporativo
            $subject = ($request->post_group == 2) ? "Sugerencia de asociado registrada" : 'Nueva sugerencia registrada';

            //recibe view, data and anonimus functon
            $dataParams['suggestion_subjet'] = $subject;
            $dataParams['suggestion_folio'] = $dataReturn['suggestion_folio'];

            $dataParams['suggestion_register_date'] = $suggestion->register_date;
            $dataParams['suggestion_description'] = $suggestion->suggestion_description;
            $dataParams['suggestion_footer'] = ($request->post_group == 2) ? "Centro de Atención y Solución al Asociado" : 'Sistema de Atención al Cliente';
            $dataParams['suggestion_customer_header'] = ($request->post_group == 2) ? "Asociado" : 'Cliente';
            $dataParams['suggestion_customer_name'] = ($request->post_group == 2)
            ? $arrayPartner->first_name . ' ' . $arrayPartner->last_name : $customer->customer_first_name . ' ' . $customer->customer_last_name;
            $dataParams['suggestion_customer_phone'] = ($request->post_group == 2) ? $arrayPartner->phone : $customer->customer_phone;

            /* Mail::send('email.suggestionNotification', $dataParams, function ($msg) use ($to, $subject) {
                  $msg->from('eperez@benedettis.com', 'Lalo Perez');
                  // ->bcc('mybcc@email.com','My bcc Name') copia oculta,
                  $msg->to($to)->subject($subject);
              });

              if (count(Mail::failures()) > 0) {
                  return response()->json(['msg' => 'Hubo un problema al enviar la notificación a tu correo. ', 'success' => false]);
              }*/

            return response()->json([
                'success' => true,
                'data' => $arrayReturn,
                'msg' => 'Registro creado correctamente'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage(),
            ]);
        }
    }

    public function getSuggestions(Request $request){
        try{
            $dataSearch['search']=(!empty($request->input('search')))?$request->input('search'):'';
            $dataSearch['offset']=(!empty($request->input('offset')))?$request->input('offset'):0;
            $dataSearch['limit']=(!empty($request->input('limit')))?$request->input('limit'):0;
            $dataSearch['sort']=(!empty($request->input('sort'))?$request->input('sort'):'register_date');
            $dataSearch['order']=(!empty($request->input('order'))?$request->input('order'):'desc');
            $dataSuggestions= Suggestion::getSuggestions($dataSearch);
            $arraySuggestions = \Main::parsingArraySuggestions($dataSuggestions);
            return response()->json([
                'total'=>Suggestion::where('register_date','like', "%".date('Y')."%")->count(),
                'totalNotFiltered'=>count($arraySuggestions),
                'rows'=>$arraySuggestions]);
         } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage(), 'success' => false]);
            //return $e->getMessage();
        }
    }

    public function getSuggestionById(Request $request)
    {
        // return response()->json($request->user());
       try {
            $data['suggestion_id'] = $request->suggestion_id;
            $dataSuggestion = Suggestion::getSuggestionById($data);
            $arraySuggestion = \Main::parsingArraySuggestions($dataSuggestion);

            if (!empty($arraySuggestion)) {
                return response()->json([
                    'msg' => 'Sugerencia obtenida correctamente',
                    'data' => $arraySuggestion,
                    'success' => true
                ]);
            } else {
                return response()->json([
                    'msg' => 'No se pudo localizar en la base de datos',
                    'success' => false
                ]);
            }

        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage(), 'success' => false]);
            //return $e->getMessage();
        }
    }

    //congratulations
    public function createCongratulation(Request $request)
    {
        try {

            //QUEJA TIPO CLIENTE=1, 2 ASOCIADO..
            $arrayEmails = array();
            $arrayToEmails = array();
            $rowEmails = array();
            $dataReturn = array();
            $operativeDay = \Main::dateToOperativeDay(date('Y-m-d'));
            //RETURN EJEM:2020251
            $dayNumber = substr($operativeDay, 4, 3);
            //RETURN EJEM:251
            $periodWeekDay = \Main::getPSD($dayNumber);
            //RETURN EJEM:P14S1D1
            // $relStore = RelUserStore::where('store_id', $request->post_store)->where('supervisor_id', '>', 0)->first();
            if ($request->post_group == 1) {
                //guardo el cliente primero
                $customer = new Customer();
                $customer->customer_first_name = trim(strip_tags($request->post_customer_first_name));
                $customer->customer_last_name = trim(strip_tags($request->post_customer_last_name));
                $customer->customer_phone = trim(strip_tags($request->post_customer_phone));
                $customer->customer_email = trim($request->post_customer_email);
                $customer->save();
                $customerId = $customer->id;
                //Insertando queja
                $congratulation = new Congratulation();
                $congratulation->group_id = $request->post_group;
                $congratulation->user_id = Auth::user()->user_id;
                $congratulation->customer_id = $customerId;
                $congratulation->register_date = date('Y-m-d H:i:s');
                $congratulation->period = $periodWeekDay['PERIODO'];
                $congratulation->operativeday_id = $operativeDay;
                $congratulation->congratulation_description = trim(strip_tags($request->post_description));
                $congratulation->partner_id = -1;

                ///QEJA Y SUGERENCIA QUEDAJ SEPARADOS..
            } else {
                $congratulation = new Congratulation();
                $congratulation->group_id = $request->post_group;
                $congratulation->customer_id = '-1';
                $congratulation->user_id = Auth::user()->user_id;
                $congratulation->partner_id = $request->post_partner;
                $congratulation->register_date = date('Y-m-d H:i:s');
                $congratulation->period = $periodWeekDay['PERIODO'];
                $congratulation->operativeday_id = $operativeDay;
                $congratulation->congratulation_description =  trim(strip_tags($request->post_description));
            }

            $congratulation->save();
            $dataReturn['congratulation_id'] = $congratulation->id;
            $dataReturn['congratulation_folio'] = str_pad($congratulation->id, 7, "0", STR_PAD_LEFT);

            if ($request->post_group == 2) {
                //Agregar datos del asociado
                $arrayPartner = User::where('partner_id', $request->post_partner)->first();
                $rowEmails['email'] = $arrayPartner->email;
                $arrayToEmails[] = $arrayPartner->email;
                array_push($arrayEmails, $rowEmails);
            }
            //test
            // $rowEmails['email'] = 'prueba@benedettis.com';
            // array_push($arrayEmails, $rowEmails);
            // $arrayToEmails[]='prueba@benedettis.com';
            //endtest
            $arrayEmailsReturn = array();
            array_push($arrayEmailsReturn, $arrayEmails);

            $dataReturn['congratulation_emails'] = $arrayEmailsReturn;
            $arrayReturn = array();
            array_push($arrayReturn, $dataReturn);
            //envio de email..
            //dd($arrayToEmails);
            $to =  $arrayToEmails; //email corporativo
            $subject = ($request->post_group == 2) ? "Felicitación de asociado registrada" : 'Nueva felicitación registrada';

            //recibe view, data and anonimus functon
            $dataParams['congratulation_subjet'] = $subject;
            $dataParams['congratulation_folio'] = $dataReturn['congratulation_folio'];

            $dataParams['congratulation_register_date'] = $congratulation->register_date;
            $dataParams['congratulation_description'] = $congratulation->suggestion_description;
            $dataParams['congratulation_footer'] = ($request->post_group == 2) ? "Centro de Atención y Solución al Asociado" : 'Sistema de Atención al Cliente';
            $dataParams['congratulation_customer_header'] = ($request->post_group == 2) ? "Asociado" : 'Cliente';
            $dataParams['congratulation_customer_name'] = ($request->post_group == 2)
                ? $arrayPartner->first_name . ' ' . $arrayPartner->last_name : $customer->customer_first_name . ' ' . $customer->customer_last_name;
            $dataParams['congratulation_customer_phone'] = ($request->post_group == 2) ? $arrayPartner->phone : $customer->customer_phone;

            /* Mail::send('email.suggestionNotification', $dataParams, function ($msg) use ($to, $subject) {
                $msg->from('eperez@benedettis.com', 'Lalo Perez');
                // ->bcc('mybcc@email.com','My bcc Name') copia oculta,
                $msg->to($to)->subject($subject);
            });

            if (count(Mail::failures()) > 0) {
                return response()->json(['msg' => 'Hubo un problema al enviar la notificación a tu correo. ', 'success' => false]);
            }*/

            return response()->json([
                'success' => true,
                'data' => $arrayReturn,
                'msg' => 'Registro creado correctamente'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage(),
            ]);
        }
    }

    public function getCongratulationById(Request $request)
    {
        // return response()->json($request->user());
       try {
            $data['congratulation_id'] = $request->congratulation_id;
            $dataCongratulation = Congratulation::getCongratulationById($data);
            $arrayCongratulation = \Main::parsingArrayCongratulations($dataCongratulation);

            if (!empty($arrayCongratulation)) {
                return response()->json([
                    'msg' => 'Felicitación obtenida correctamente',
                    'data' => $arrayCongratulation,
                    'success' => true
                ]);
            } else {
                return response()->json([
                    'msg' => 'No se pudo localizar en la base de datos',
                    'success' => false
                ]);
            }

        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage(), 'success' => false]);
            //return $e->getMessage();
        }
    }
    public function getCongratulations(Request $request)
    {
        try {
            $dataSearch['search'] = (!empty($request->input('search'))) ? $request->input('search') : '';
            $dataSearch['offset'] = (!empty($request->input('offset'))) ? $request->input('offset') : 0;
            $dataSearch['limit'] = (!empty($request->input('limit'))) ? $request->input('limit') : 0;
            $dataSearch['sort'] = (!empty($request->input('sort')) ? $request->input('sort') : 'register_date');
            $dataSearch['order'] = (!empty($request->input('order')) ? $request->input('order') : 'desc');
            $dataCongratulations = Congratulation::getCongratulations($dataSearch);
            $arrayCongratulations = \Main::parsingArrayCongratulations($dataCongratulations);
            return response()->json([
                'total' => Congratulation::where('register_date', 'like', "%" . date('Y') . "%")->count(),
                'totalNotFiltered' => count($arrayCongratulations),
                'rows' => $arrayCongratulations
            ]);
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage(), 'success' => false]);
            //return $e->getMessage();
        }
    }

    //complaints..
    public function getComplaints(Request $request)
    {
        // return response()->json($request->user());
        try {
            $dataSearch['search'] = (!empty($request->input('search'))) ? $request->input('search') : '';
            $dataSearch['offset'] = (!empty($request->input('offset'))) ? $request->input('offset') : 0;
            $dataSearch['limit'] = (!empty($request->input('limit'))) ? $request->input('limit') : 0;
            $dataSearch['sort'] = (!empty($request->input('sort')) ? $request->input('sort') : 'register_date');
            $dataSearch['order'] = (!empty($request->input('order')) ? $request->input('order') : 'desc');
            $dataSearch['status_id'] = (!empty($request->input('status_id'))) ? $request->input('status_id') : '';
            $dataSearch['store_id'] = (!empty($request->input('store_id'))) ? $request->input('store_id') : '';
            $dataSearch['dateFrom'] = (!empty($request->input('dateFrom'))) ? $request->input('dateFrom') : '';
            $dataSearch['dateTo'] = (!empty($request->input('dateTo'))) ? $request->input('dateTo') : '';

            $dataComplaints = Complaint::getComplaints($dataSearch);
            $arrayComplaints = \Main::parsingArrayComplaints($dataComplaints);
            $totalComplaints = Complaint::getTotalComplaints($dataSearch);
            return response()->json([
                'total' => $totalComplaints,
                'totalNotFiltered' => $totalComplaints,
                'rows' => $arrayComplaints
            ]);
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage(), 'success' => false]);
            //return $e->getMessage();
        }
    }

    public function getComplaintById(Request $request)
    {
        // return response()->json($request->user());
       try {
            $data['complaint_id'] = $request->complaint_id;
            $dataComplaint = Complaint::getComplaintById($data);
            $arrayComplaint = \Main::parsingArrayComplaints($dataComplaint);

            if (!empty($arrayComplaint)) {
                return response()->json([
                    'msg' => 'Incidencia obtenida correctamente',
                    'data' => $arrayComplaint,
                    'success' => true
                ]);
            } else {
                return response()->json([
                    'msg' => 'No se pudo localizar en la base de datos',
                    'success' => false
                ]);
            }

        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage(), 'success' => false]);
            //return $e->getMessage();
        }
    }

    public function getComplaintsBySupervisor(Request $request)
    {
        try {
            //$User=User::where('user_id',Auth::user()->user_id)->first();
            $dataSearch['supervisor_id']=Auth::user()->supervisor_id; //is the same that supervisor id
            $dataSearch['search'] = (!empty($request->input('search'))) ? $request->input('search') : '';
            $dataSearch['offset'] = (!empty($request->input('offset'))) ? $request->input('offset') : 0;
            $dataSearch['limit'] = (!empty($request->input('limit'))) ? $request->input('limit') : 0;
            $dataSearch['sort'] = (!empty($request->input('sort')) ? $request->input('sort') : 'register_date');
            $dataSearch['order'] = (!empty($request->input('order')) ? $request->input('order') : 'desc');
            $dataSearch['status_id'] = (!empty($request->input('status_id'))) ? $request->input('status_id') : '';
            $dataSearch['store_id'] = (!empty($request->input('store_id'))) ? $request->input('store_id') : '';
            $dataSearch['dateFrom'] = (!empty($request->input('dateFrom'))) ? $request->input('dateFrom') : '';
            $dataSearch['dateTo'] = (!empty($request->input('dateTo'))) ? $request->input('dateTo') : '';
            $dataComplaints = Complaint::getComplaintsBySupervisor($dataSearch);
            $arrayComplaints = \Main::parsingArrayComplaints($dataComplaints);
            $totalComplaints=Complaint::getTotalComplaintsBySupervisor($dataSearch);
            return response()->json([
                'total' => $totalComplaints,
                'totalNotFiltered' => $totalComplaints,
                'rows' => $arrayComplaints
            ]);
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage(), 'success' => false]);
            //return $e->getMessage();
        }
    }

    public function getComplaintsByManager(Request $request)
    {
        try {
           // $User=User::where('user_id',Auth::user()->user_id)->first();
            $dataSearch['manager_id']=Auth::user()->manager_id; //is the same that supervisor id
            $dataSearch['search'] = (!empty($request->input('search'))) ? $request->input('search') : '';
            $dataSearch['offset'] = (!empty($request->input('offset'))) ? $request->input('offset') : 0;
            $dataSearch['limit'] = (!empty($request->input('limit'))) ? $request->input('limit') : 0;
            $dataSearch['sort'] = (!empty($request->input('sort')) ? $request->input('sort') : 'register_date');
            $dataSearch['order'] = (!empty($request->input('order')) ? $request->input('order') : 'desc');
            $dataSearch['status_id'] = (!empty($request->input('status_id'))) ? $request->input('status_id') : '';
            $dataSearch['store_id'] = (!empty($request->input('store_id'))) ? $request->input('store_id') : '';
            $dataSearch['dateFrom'] = (!empty($request->input('dateFrom'))) ? $request->input('dateFrom') : '';
            $dataSearch['dateTo'] = (!empty($request->input('dateTo'))) ? $request->input('dateTo') : '';
            $dataComplaints = Complaint::getComplaintsByManager($dataSearch);
            //dd($dataComplaints);
            $arrayComplaints = \Main::parsingArrayComplaints($dataComplaints);
            $totalComplaints=Complaint::getTotalComplaintsByManager($dataSearch);

            return response()->json([
                'total' => $totalComplaints,
                'totalNotFiltered' => $totalComplaints,
                'rows' => $arrayComplaints
            ]);
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage(), 'success' => false]);
            //return $e->getMessage();
        }
    }

    public function getComplaintsByManagerArea(Request $request)
    {
        try {
            //$User=User::where('user_id',Auth::user()->user_id)->first();
            $dataSearch['department_id']=Auth::user()->department_id; //is the same that supervisor id
            $dataSearch['search'] = (!empty($request->input('search'))) ? $request->input('search') : '';
            $dataSearch['offset'] = (!empty($request->input('offset'))) ? $request->input('offset') : 0;
            $dataSearch['limit'] = (!empty($request->input('limit'))) ? $request->input('limit') : 0;
            $dataSearch['sort'] = (!empty($request->input('sort')) ? $request->input('sort') : 'register_date');
            $dataSearch['order'] = (!empty($request->input('order')) ? $request->input('order') : 'desc');
            $dataSearch['status_id'] = (!empty($request->input('status_id'))) ? $request->input('status_id') : '';
            $dataSearch['store_id'] = (!empty($request->input('store_id'))) ? $request->input('store_id') : '';
            $dataSearch['dateFrom'] = (!empty($request->input('dateFrom'))) ? $request->input('dateFrom') : '';
            $dataSearch['dateTo'] = (!empty($request->input('dateTo'))) ? $request->input('dateTo') : '';
            $dataComplaints = Complaint::getComplaintsByManagerArea($dataSearch);
            $arrayComplaints = \Main::parsingArrayComplaints($dataComplaints);
            $totalComplaints=Complaint::getTotalComplaintsByManagerArea($dataSearch);
            return response()->json([
                'total' => $totalComplaints,
                'totalNotFiltered' => $totalComplaints,
                'rows' => $arrayComplaints
            ]);
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage(), 'success' => false]);
            //return $e->getMessage();
        }
    }

    public function getComplaintsPendingByManagerArea(Request $request)
    {
        try {
            //$User=User::where('user_id',Auth::user()->user_id)->first();
            $dataSearch['department_id']=Auth::user()->department_id; //is the same that supervisor id
            $dataSearch['search'] = (!empty($request->input('search'))) ? $request->input('search') : '';
            $dataSearch['offset'] = (!empty($request->input('offset'))) ? $request->input('offset') : 0;
            $dataSearch['limit'] = (!empty($request->input('limit'))) ? $request->input('limit') : 0;
            $dataSearch['sort'] = (!empty($request->input('sort')) ? $request->input('sort') : 'register_date');
            $dataSearch['order'] = (!empty($request->input('order')) ? $request->input('order') : 'desc');
            $dataSearch['status_id'] = (!empty($request->input('status_id'))) ? $request->input('status_id') : '';
            $dataSearch['store_id'] = (!empty($request->input('store_id'))) ? $request->input('store_id') : '';
            $dataSearch['dateFrom'] = (!empty($request->input('dateFrom'))) ? $request->input('dateFrom') : '';
            $dataSearch['dateTo'] = (!empty($request->input('dateTo'))) ? $request->input('dateTo') : '';
            $dataComplaints = Complaint::getPendingComplaintsByManagerArea($dataSearch);
            $arrayComplaints = \Main::parsingArrayComplaints($dataComplaints);
            $totalComplaints=count($dataComplaints);
            return response()->json([
                'total' => $totalComplaints,
                'totalNotFiltered' => $totalComplaints,
                'rows' => $arrayComplaints
            ]);
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage(), 'success' => false]);
            //return $e->getMessage();
        }
    }

    public function getComplaintsByPartner(Request $request)
    {
        try {
           // $User=User::where('user_id',Auth::user()->user_id)->first();
            $dataSearch['partner_id']=Auth::user()->partner_id; //is the same that partner id
            $dataSearch['search'] = (!empty($request->input('search'))) ? $request->input('search') : '';
            $dataSearch['offset'] = (!empty($request->input('offset'))) ? $request->input('offset') : 0;
            $dataSearch['limit'] = (!empty($request->input('limit'))) ? $request->input('limit') : 0;
            $dataSearch['sort'] = (!empty($request->input('sort')) ? $request->input('sort') : 'register_date');
            $dataSearch['order'] = (!empty($request->input('order')) ? $request->input('order') : 'desc');
            $dataComplaints = Complaint::getComplaintsByPartner($dataSearch);
            //dd($dataComplaints);
            $arrayComplaints = \Main::parsingArrayComplaints($dataComplaints);
            $totalComplaints=Complaint::getTotalComplaintsByPartner($dataSearch);

            return response()->json([
                'total' =>$totalComplaints,
                'totalNotFiltered' =>$totalComplaints,
                'rows' => $arrayComplaints
            ]);
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage(), 'success' => false]);
            //return $e->getMessage();
        }
    }

    public function createComplaint(Request $request)
    {
        try {

            //QUEJA TIPO CLIENTE=1, 2 ASOCIADO..
            $arrayEmails = array();
            $arrayToEmails = array();
            $rowEmails = array();
            $dataReturn = array();
            $operativeDay = \Main::dateToOperativeDay(date('Y-m-d'));
            //RETURN EJEM:2020251
            $dayNumber = substr($operativeDay, 4, 3);
            //RETURN EJEM:251
            $periodWeekDay = \Main::getPSD($dayNumber);
            //RETURN EJEM:P14S1D1
            $relStore = RelUserStore::where('store_id', $request->post_store)->where('supervisor_id', '>', 0)->first();

            if ($request->post_group == 1) {
                //guardo el cliente primero
                $customer = new Customer();
                $customer->customer_first_name = trim(strip_tags($request->post_customer_first_name));
                $customer->customer_last_name = trim(strip_tags($request->post_customer_last_name));
                $customer->customer_phone = trim($request->post_customer_phone);
                $customer->customer_email = trim($request->post_customer_email);
                $customer->save();
                $customerId = $customer->id;
                //Insertando queja
                $complaint = new Complaint();
                $complaint->group_id = $request->post_group;
                $complaint->store_id = $request->post_store;
                $complaint->supervisor_id = (!empty($relStore)) ? $relStore->supervisor_id : '-1';
                $complaint->zone_id = (!empty($relStore)) ? $relStore->zone_id : '-1';
                $complaint->customer_id = $customerId;
                $complaint->status_id = 1; //pendiente..
                $complaint->register_date = date('Y-m-d H:i:s');
                $complaint->solved_date = '';
                $complaint->period = $periodWeekDay['PERIODO'];
                $complaint->operativeday_id = $operativeDay;
                $complaint->priority_id = $request->post_urgency;
                $complaint->department_id = 0;
                $complaint->complaint_description = trim(strip_tags($request->post_description));
                $complaint->complaint_solution = '';
                $complaint->partner_id = -1;
                $complaint->category_id = $request->post_category; //facebook, tweeter..
                $complaint->category_request_id = 1; //1 es queja..

                ///QEJA Y SUGERENCIA QUEDAJ SEPARADOS..
            } else {
                $complaint = new Complaint();
                $complaint->group_id = $request->post_group;
                $complaint->store_id = $request->post_store;
                $complaint->supervisor_id = (!empty($relStore)) ? $relStore->supervisor_id : '-1';
                $complaint->zone_id = (!empty($relStore)) ? $relStore->zone_id : '-1';
                $complaint->customer_id = '-1';
                $complaint->user_id = Auth::user()->user_id;
                $complaint->partner_id = $request->post_partner;
                $complaint->status_id = 1; //pendiente..
                $complaint->register_date = date('Y-m-d H:i:s');
                $complaint->solved_date = '';
                $complaint->period = $periodWeekDay['PERIODO'];
                $complaint->operativeday_id = $operativeDay;
                $complaint->priority_id = $request->post_urgency;
                $complaint->department_id = $request->post_department;
                $complaint->complaint_description =  trim(strip_tags($request->post_description));
                $complaint->complaint_solution = '';
                $complaint->category_id = (!empty($request->post_category))?$request->post_category:6; //OTROS //facebook, tweeter..
                $complaint->category_request_id = (!empty($request->post_category_request))?$request->post_category_request:1; //1 es Incidencia..

            }
            $arrayPriority = Priority::where('priority_id', $complaint->priority_id)->first();
            $complaint->save();
            $dataReturn['complaint_id'] = $complaint->id;
            $dataReturn['complaint_folio'] = str_pad($complaint->id, 7, "0", STR_PAD_LEFT);
            $arrayStore = Store::where('id_unidad', $request->post_store)->first();
            $arraySupervisor = User::where('supervisor_id', $relStore->supervisor_id)->first();
            $dataManager = RelManagerSupervisor::where('supervisor_id', $relStore->supervisor_id)->first();
            $arrayManager = User::where('manager_id', $dataManager->manager_id)->first();
            // dd($relStore->supervisor_id);
            $dataReturn['complaint_store'] = $arrayStore->id_unidad . ' ' . $arrayStore->nombre_unidad;
            $dataReturn['complaint_supervisor'] = (!empty($arraySupervisor)) ? $arraySupervisor->first_name . ' ' . $arraySupervisor->last_name : 'N/A';
            $dataReturn['complaint_manager'] = (!empty($arrayManager)) ? $arrayManager->first_name . ' ' . $arrayManager->last_name : 'N/A';

            if (!empty($arraySupervisor->email)) {
                $rowEmails['email'] = $arraySupervisor->email;
                $arrayToEmails[] = $arraySupervisor->email;
                array_push($arrayEmails, $rowEmails); //for json display in view
            }

            if (!empty($arrayManager->email)) {
                $rowEmails['email'] = $arrayManager->email;
                $arrayToEmails[] = $arrayManager->email;
                array_push($arrayEmails, $rowEmails); //for json display in view
            }

            if ($request->post_group == 2) {
                //Agregar datos del asociado
                $arrayPartner = User::where('partner_id', $request->post_partner)->first();
                $rowEmails['email'] = $arrayPartner->email;
                $arrayToEmails[] = $arrayPartner->email;
                array_push($arrayEmails, $rowEmails); //for json display in view

                //meter email de area..
                $arrayDepartment = Department::where('department_id', $complaint->department_id)->first();
                $rowEmails['email'] = $arrayDepartment->deparment_email;
                $arrayToEmails[] = $arrayPartner->email;
                array_push($arrayEmails, $rowEmails); //for json display in view
            }
            //test
            // $rowEmails['email'] = 'prueba@benedettis.com';
            // array_push($arrayEmails, $rowEmails);
            // $arrayToEmails[]='prueba@benedettis.com';
            //endtest
            $arrayEmailsReturn = array();
            array_push($arrayEmailsReturn, $arrayEmails);

            $dataReturn['complaint_emails'] = $arrayEmailsReturn;
            $arrayReturn = array();
            array_push($arrayReturn, $dataReturn);

            //envio de email..
            //dd($arrayToEmails);
            $to =  $arrayToEmails; //email corporativo
            $subject = ($request->post_group == 2) ? "Nueva solicitud de asociado registrada" : 'Nueva incidencia registrada';
            //dd($subject);
            //recibe view, data and anonimus functon
            $dataParams['complaint_subjet'] = $subject;
            $dataParams['complaint_store'] = $dataReturn['complaint_store'];
            $dataParams['complaint_folio'] = $dataReturn['complaint_folio'];
            $dataParams['complaint_supervisor'] = $dataReturn['complaint_supervisor'];
            $dataParams['complaint_manager'] = $dataReturn['complaint_manager'];
            $dataParams['complaint_register_date'] = $complaint->register_date;
            $dataParams['complaint_description'] = $complaint->complaint_description;
            $dataParams['complaint_priority'] = (!empty($arrayPriority)) ? $arrayPriority->priority_description : 'N/A';
            $dataParams['complanint_footer'] = ($request->post_group == 2) ? "Centro de Atención y Solución al Asociado" : 'Sistema de Atención al Cliente';
            $dataParams['complaint_customer_header'] = ($request->post_group == 2) ? "Asociado" : 'Cliente';
            $dataParams['complaint_customer_name'] = ($request->post_group == 2)
                ? $arrayPartner->first_name . ' ' . $arrayPartner->last_name : $customer->customer_first_name . ' ' . $customer->customer_last_name;
            $dataParams['complaint_customer_phone'] = ($request->post_group == 2) ? $arrayPartner->phone : $customer->customer_phone;
            $dataParams['complaint_customer_email'] = ($request->post_group == 2) ? $arrayPartner->email : $customer->customer_email;

           //config email address from and bcc addreses email
            $from=AppConfigEmail::getEmailFrom();
            $arrayBcc=AppConfigEmail::where('active_email',1)->get();
            $bcc=array();
            if(!empty($arrayBcc)){
                foreach($arrayBcc as $rowBcc){
                    $bcc[]=$rowBcc->email;
                }
            }
            //dd($bcc);
            Mail::send('email.complaintNotification', $dataParams, function ($msg) use ($from,$to, $subject,$bcc) {
                $msg->from($from->email_from, $from->name_from)
                ->bcc($bcc); //copia oculta,
                $msg->to($to)->subject($subject);
            });

            if (count(Mail::failures()) > 0) {
                return response()->json(['msg' => 'Hubo un problema al enviar la notificación a tu correo. ', 'success' => false]);
            }

            return response()->json([
                'success' => true,
                'data' => $arrayReturn,
                'msg' => 'Registro creado correctamente'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage(),
            ]);
        }
    }

    public function solveComplaint(Request $request)
    {
        try {

            //QUEJA TIPO CLIENTE=1, 2 ASOCIADO..
            $arrayEmails = array();
            $arrayToEmails = array();
            $rowEmails = array();
            $dataReturn = array();
            //RETURN EJEM:2020251
            //RETURN EJEM:251
            $data['complaint_id']=$request->complaint_id;
            $data['complaint_solution']=trim(strip_tags($request->post_description));


            Complaint::where('complaint_id',$data['complaint_id'])
                ->update([
                    'complaint_solution'=>$data['complaint_solution'],
                    'status_id'=>2,
                    'solved_date'=>date('Y-m-d H:i:s')
                ]);
                //enviar notificación de que la insidencia fué resuelta

                $complaintSolved=Complaint::where('complaint_id',$data['complaint_id'])->first();
                if($complaintSolved->group_id==2){
                    $data['partner_id']=$complaintSolved->partner_id;
                    $partnerUser=User::where('partner_id',$data['partner_id'])->first();
                    if(!empty($partnerUser)){
                        //enviar email AQUÍ
                         $arrayStore = Store::where('id_unidad', $complaintSolved->store_id)->first();
                        //$arraySupervisor = User::where('supervisor_id', $relStore->supervisor_id)->first();
                        //$dataManager = RelManagerSupervisor::where('supervisor_id', $relStore->supervisor_id)->first();
                        //$arrayManager = User::where('manager_id', $dataManager->manager_id)->first();

                        $dataParams['complaint_folio'] = str_pad($complaintSolved->complaint_id, 7, "0", STR_PAD_LEFT);
                        $dataParams['complaint_store'] = $arrayStore->id_unidad . ' ' . $arrayStore->nombre_unidad;
                        $dataParams['complaint_register_date'] = $complaintSolved->register_date;
                        $dataParams['complaint_solved_date'] = $complaintSolved->solved_date;
                        $dataParams['complaint_description'] = $complaintSolved->complaint_description;
                        $dataParams['complaint_solution'] = $complaintSolved->complaint_solution;
                        $dataParams['complanint_footer'] = ($complaintSolved->post_group == 2) ? "Centro de Atención y Solución al Asociado" : 'Sistema de Atención al Cliente';
                        $dataParams['complaint_customer_header'] = ($complaintSolved->post_group == 2) ? "Asociado" : 'Cliente';

                        $from=AppConfigEmail::getEmailFrom();
                        //$arrayBcc=AppConfigEmail::where('active_email',1)->get();
                        //$bcc=array();
                        /*if(!empty($arrayBcc)){
                            foreach($arrayBcc as $rowBcc){
                                $bcc[]=$rowBcc->email;
                            }
                        }*/
                      //  dd($dataParams);
                        $subject = ($request->post_group == 2) ? "Respuesta a tu solicitud ".$dataParams['complaint_folio'] : 'Respuesta a tu solicitud';
                        $to=array();
                        $to[]=$partnerUser->email;
                        Mail::send('email.complaintSolveNotification', $dataParams, function ($msg) use ($from,$to, $subject) {
                            $msg->from($from->email_from, $from->name_from);
                            //->bcc($bcc); //copia oculta,
                            $msg->to($to)->subject($subject);
                        });
                        if (count(Mail::failures()) > 0) {
                           //  return response()->json(['msg' => 'Hubo un problema al enviar la notificación por correo a los destinatarios. ', 'success' => false]);
                        }

                        //generando link para responder encuesta..
                        $linkSurvey=url('/newSurvey/complaint_id/'. $data["complaint_id"].'/partner_id/'.$data["partner_id"]);
                        $dataParams['link_survey']=$linkSurvey;
                        //enviando mail con link de encuesta..
                        $subject = ($request->post_group == 2) ? "Encuesta de satisfacción referente a tu solicitud ".$dataParams['complaint_folio'] : 'Encuesta de satisfacción referente a tu solicitud';
                        $dataParams['survey_subjet']=$subject;

                        Mail::send('email.surveyPartnerNotification', $dataParams, function ($msg) use ($from,$to, $subject) {
                            $msg->from($from->email_from, $from->name_from);
                            //->bcc($bcc); //copia oculta,
                            $msg->to($to)->subject($subject);
                        });
                        if (count(Mail::failures()) > 0) {
                           //  return response()->json(['msg' => 'Hubo un problema al enviar la notificación por correo a los destinatarios. ', 'success' => false]);
                        }

                        //dd($linkSurvey);


                    }
                   // dd('enviar queja resuelta a '.$partnerUser);
                }

                return response()->json([
                    'success' => true,
                    'msg' => 'Solicitud actualizada correctamente',
                    'data' => $request->complaint_id
                ]);


        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage(),
            ]);
        }
    }

    public function createComplaintByPartner(Request $request)
    {
        try {

            $arrayEmails = array();
            $arrayToEmails = array();
            $rowEmails = array();
            $dataReturn = array();

            //arrays
            $operativeDay=\Main::dateToOperativeDay(date('Y-m-d'));
            //RETURN EJEM:2020251
            $dayNumber=substr($operativeDay,4,3);
            //RETURN EJEM:251
            $periodWeekDay=\Main::getPSD($dayNumber);
            //RETURN EJEM:P14S1D1
            $relStore = RelUserStore::where('store_id',$request->post_store)->where('supervisor_id','>',0)->first();
            $complaint = new Complaint();
            $complaint->group_id= $request->post_group;
            $complaint->store_id= $request->post_store;
            $complaint->supervisor_id=(!empty($relStore))?$relStore->supervisor_id:'-1';
            $complaint->zone_id=(!empty($relStore))?$relStore->zone_id:'-1';
            $complaint->customer_id='-1';
            $complaint->user_id=Auth::user()->user_id;
            $complaint->partner_id=$request->post_partner;
            $complaint->status_id=1; //pendiente..
            $complaint->register_date= date('Y-m-d H:i:s');
            $complaint->solved_date= '';
            $complaint->period=$periodWeekDay['PERIODO'];
            $complaint->operativeday_id=$operativeDay;
            $complaint->priority_id=$request->post_urgency;
            $complaint->department_id=$request->post_department;
            $complaint->complaint_description= $request->post_description;
            $complaint->complaint_solution= '';
            $complaint->category_id=$request->post_category; //facebook, tweeter.
            $complaint->category_request_id=$request->post_category_request;
            $complaint->save();
            //email sender
            $arrayPriority = Priority::where('priority_id', $complaint->priority_id)->first();
            $dataReturn['complaint_id'] = $complaint->id;
            $dataReturn['complaint_folio'] = str_pad($complaint->id, 7, "0", STR_PAD_LEFT);
            $arrayStore = Store::where('id_unidad', $request->post_store)->first();
            $arraySupervisor = User::where('supervisor_id', $relStore->supervisor_id)->first();
            $dataManager = RelManagerSupervisor::where('supervisor_id', $relStore->supervisor_id)->first();
            $arrayManager = User::where('manager_id', $dataManager->manager_id)->first();
            // dd($relStore->supervisor_id);
            $dataReturn['complaint_store'] = $arrayStore->id_unidad . ' ' . $arrayStore->nombre_unidad;
            $dataReturn['complaint_supervisor'] = (!empty($arraySupervisor)) ? $arraySupervisor->first_name . ' ' . $arraySupervisor->last_name : 'N/A';
            $dataReturn['complaint_manager'] = (!empty($arrayManager)) ? $arrayManager->first_name . ' ' . $arrayManager->last_name : 'N/A';

            if (!empty($arraySupervisor->email)) {
                $rowEmails['email'] = $arraySupervisor->email;
                $arrayToEmails[] = $arraySupervisor->email;
                array_push($arrayEmails, $rowEmails); //for json display in view
            }

            if (!empty($arrayManager->email)) {
                $rowEmails['email'] = $arrayManager->email;
                $arrayToEmails[] = $arrayManager->email;
                array_push($arrayEmails, $rowEmails); //for json display in view
            }

            $arrayPartner = User::where('partner_id', $request->post_partner)->first();
            $rowEmails['email'] = $arrayPartner->email;
            $arrayToEmails[] = $arrayPartner->email;
            array_push($arrayEmails, $rowEmails); //for json display in view

            //meter email de area..
            $arrayDepartment = Department::where('department_id', $complaint->department_id)->first();
            $rowEmails['email'] = $arrayDepartment->deparment_email;
            $arrayToEmails[] = $arrayPartner->email;
            array_push($arrayEmails, $rowEmails); //for json display in view

            //config template an email bcc list
            $arrayEmailsReturn = array();
            array_push($arrayEmailsReturn, $arrayEmails);

            $dataReturn['complaint_emails'] = $arrayEmailsReturn;
            $arrayReturn = array();
            array_push($arrayReturn, $dataReturn);

            //envio de email..
            //dd($arrayToEmails);
            $to =  $arrayToEmails; //email corporativo
            $subject =  "Nueva solicitud de asociado registrada" ;
            //recibe view, data and anonimus functon
            $dataParams['complaint_subjet'] = $subject;
            $dataParams['complaint_store'] = $dataReturn['complaint_store'];
            $dataParams['complaint_folio'] = $dataReturn['complaint_folio'];
            $dataParams['complaint_supervisor'] = $dataReturn['complaint_supervisor'];
            $dataParams['complaint_manager'] = $dataReturn['complaint_manager'];
            $dataParams['complaint_register_date'] = $complaint->register_date;
            $dataParams['complaint_description'] = $complaint->complaint_description;
            $dataParams['complaint_priority'] = (!empty($arrayPriority)) ? $arrayPriority->priority_description : 'N/A';
            $dataParams['complanint_footer'] =  "Centro de Atención y Solución al Asociado" ;
            $dataParams['complaint_customer_header'] =  "Asociado" ;
            $dataParams['complaint_customer_name'] = $arrayPartner->first_name . ' ' . $arrayPartner->last_name;
            $dataParams['complaint_customer_phone'] = $arrayPartner->phone;
            $dataParams['complaint_customer_email'] = $arrayPartner->email;

            //config email address from and bcc addreses email
            $from = AppConfigEmail::getEmailFrom();
            $arrayBcc = AppConfigEmail::where('active_email', 1)->get();
            $bcc = array();
            if (!empty($arrayBcc)) {
                foreach ($arrayBcc as $rowBcc) {
                    $bcc[] = $rowBcc->email;
                }
            }
            //dd($bcc);
            Mail::send('email.complaintNotification', $dataParams, function ($msg) use ($from, $to, $subject, $bcc) {
                $msg->from($from->email_from, $from->name_from)
                    ->bcc($bcc); //copia oculta,
                $msg->to($to)->subject($subject);
            });

            if (count(Mail::failures()) > 0) {
                return response()->json(['msg' => 'Hubo un problema al enviar la notificación a tu correo. ', 'success' => true]);
            }



            //Enviando notificacion a email..
           // $request->session()->flash('SessionComplaintSuccess', 'true');
            return response()->json([
                'success' => true,
                'data' => $complaint->id,
                'data_emails'=>$arrayReturn,
                'msg' => 'Registro creado correctamente'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage(),
            ]);
        }
    }

    public function getCategoryComplaint(Request $request){
        try{
            $arrayCategiories= Category::where('category_active', 1)
            ->orderBy('category_id', 'asc')->get();

            if (!empty($arrayCategiories)) {

                return response()->json([
                    'success' => true,
                    'msg' => 'Categorias obtenidas correctamente',
                    'data' => $arrayCategiories
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'msg' => 'No hay datos disponibles',
                    'data' => null
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage(),
            ]);
        }
    }

    public function getCustomers(Request $request)
    {
        // return response()->json($request->user());
        try {
            $dataSearch['search']=$request->input('search');
            $dataSearch['offset']=$request->input('offset');
            $dataSearch['limit']=$request->input('limit');
            $dataSearch['sort']=(!empty($request->input('sort'))?$request->input('sort'):'customer_id');
            $dataSearch['order']=(!empty($request->input('order'))?$request->input('order'):'desc');

            $arrayCustomers = Customer::getCustomers($dataSearch);
            return response()->json([
                'total'=>Customer::count(),
                'totalNotFiltered'=>count($arrayCustomers),
                'rows'=>$arrayCustomers]);
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage(), 'success' => false]);
            //return $e->getMessage();
        }
    }

    public function createUser(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'first_name'     => 'required|string',
                'email'    => 'required|string|email|unique:users',
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'msg' => 'Validator fails '.$validator->errors()
                ], 400);
            }
            $data=array();
            $data['auth_id']=intval($request->auth_id);
            $data['department_id']=$request->department_id;
            $data['first_name']=trim($request->first_name);
            $data['last_name']=trim($request->last_name);
            $data['email']=trim($request->email);
            $data['phone']=trim($request->phone);
            $data['password']= bcrypt(trim($request->password));
            $UserId=User::createUserAccount($data);

            if(intval($request->auth_id)==1) //supervisor_id
                User::where('user_id',$UserId)->update(['supervisor_id' => $UserId]);
            if(intval($request->auth_id)==3) //manager_id
                User::where('user_id',$UserId)->update(['manager_id' => $UserId]);
            if(intval($request->auth_id)==6) //partner_id
                User::where('user_id',$UserId)->update(['partner_id' => $UserId]);

            return response()->json([
                'success' => true,
                'data'=>$UserId,
                'msg' => 'Cuenta creada correctamente '
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage(),
            ]);
        }
    }

    public function changeUserPassword(Request $request)
    {
        try {
            if (!empty($request->post_password)) {
                $user = User::where('user_id', Auth::user()->user_id)->first();
                // var_dump(bcrypt($request->post_password));

                if (Hash::check($request->post_password, $user->password)) {
                    // if (!empty($user) && $user->password == bcrypt($request->post_password)) {
                    $validator = Validator::make($request->all(), [
                        'post_password'          => 'required',
                        'post_new_password'              => 'min:8|confirmed|different:post_password',
                        'post_new_password_confirmation' => 'required_with:post_new_password|min:8'
                    ]);
                    if ($validator->fails()) {
                        return response()->json([
                            'success' => false,
                            'msg' => 'Tus contraseñas capturadas no coinciden o no cumplen con el formato. Por favor, revisa los datos capturados e intenta nuevamente'
                        ], 400);
                    }
                    //IF PASSWORD PASSED
                    User::where('user_id', Auth::user()->user_id)->update(['password' => bcrypt($request->post_new_password)]);
                    return response()->json([
                        'success' => true,
                        'msg' => 'Password actualizado correctamente'
                    ], 201);
                } else {
                    return response()->json([
                        'success' => false,
                        'msg' => 'Tu contraseña actual no coincide. Por favor revisa los datos capturados e intenta nuevamente'
                    ], 400);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Hubo un error al realizar la operacion: '.$e->getMessage(),
            ], 400);
        }
    }

    public function changeUserPasswordById(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'post_user'=> 'required',
                'post_password'=> 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'msg' => 'Hubo un error al actualizar la información. Por favor, revisa los datos capturados e intenta nuevamente'
                ], 400);
            }

            $user = User::where('user_id', $request->post_user)->first();
            $user->password=bcrypt(trim($request->post_password));

            if ($user->save()) {
                return response()->json([
                    'success' => true,
                    'msg' => 'Contraseña actualizada correctamente'
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'msg' => 'Hubo un error al realizar la operacion',
                ], 400);
            }


        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Hubo un error al realizar la operacion: ' . $e->getMessage(),
            ], 400);
        }
    }

    public function deleteUserById(Request $request){
        try{
            $user = User::where('user_id', $request->post_user_delete)->first();
            $user->user_active=0; //sin vigencia

            if ($user->save()) {
                return response()->json([
                    'success' => true,
                    'msg' => 'Vigencia actualizada correctamente'
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'msg' => 'Hubo un error al realizar la operación',
                ], 400);
            }


        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Hubo un error al realizar la operación: ' . $e->getMessage(),
            ], 400);
        }
    }

    public function updateUserAccountById(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'post_auth_id'=> 'required',
                'post_first_name'=> 'required',
                'post_last_name'=> 'required',
                'post_phone' => 'required',
                'post_email' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'msg' => 'Hubo un error al actualizar tus información. Por favor, revisa los datos capturados e intenta nuevamente'
                ], 400);
            }

            $user = User::where('user_id',$request->post_user_id)->first();
            $user->auth_id=intval($request->post_auth_id);
            $user->department_id=$request->post_department_id;
            $user->first_name=trim($request->post_first_name);
            $user->last_name = trim($request->post_last_name);
            $user->phone = trim($request->post_phone);
            $user->email = trim($request->post_email);
            if ($user->save()) {
                return response()->json([
                    'success' => true,
                    'msg' => 'Cuenta actualizada correctamente'
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'msg' => 'Hubo un error al realizar la operacion',
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Hubo un error al realizar la operacion: ' . $e->getMessage(),
            ], 400);
        }
    }

    public function updateUserProfile(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'post_first_name'=> 'required',
                'post_last_name'=> 'required',
                'post_phone' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'msg' => 'Hubo un error al actualizar tus información. Por favor, revisa los datos capturados e intenta nuevamente'
                ], 400);
            }

            $user = User::where('user_id', Auth::user()->user_id)->first();
            $user->first_name=trim($request->post_first_name);
            $user->last_name = trim($request->post_last_name);
            $user->phone = trim($request->post_phone);
            if ($user->save()) {
                return response()->json([
                    'success' => true,
                    'msg' => 'Perfil actualizado correctamente'
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'msg' => 'Hubo un error al realizar la operacion',
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Hubo un error al realizar la operacion: ' . $e->getMessage(),
            ], 400);
        }
    }

    public function getPartners(Request $request)
    {
        // return response()->json($request->user());
        try {

            $arrayPartners = User::where('auth_id', 6)->get(); //asociado..
            if (!empty($arrayPartners)) {
                return response()->json([
                    'success' => true,
                    'msg' => 'Asociados obtenidos correctamente',
                    'data' => $arrayPartners
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'msg' => 'No hay datos disponibles',
                    'data' => null
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage(), 'success' => false]);
            //return $e->getMessage();
        }
    }

    public function getPartnerStores(Request $request)
    {
        // return response()->json($request->user());
        try {

            $arrayRelStores= RelUserStore::where('partner_id', $request->partner_id)
            ->where('rel_user_active',1)->get(); //asociado..
            if (!empty($arrayRelStores)) {

                $arrayStores= \Main::parsingArrayStores($arrayRelStores);
                if(!empty($arrayStores)){
                    return response()->json([
                        'success' => true,
                        'msg' => 'UBEs de asociado obtenidas correctamente',
                        'data' => $arrayStores
                    ]);
                }
                else{
                    return response()->json([
                        'success' => false,
                        'msg' => 'No hay datos disponibles',
                        'data' => null
                    ]);
                }

            } else {
                return response()->json([
                    'success' => false,
                    'msg' => 'No hay datos disponibles',
                    'data' => null
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage(), 'success' => false]);
            //return $e->getMessage();
        }
    }

    public function getCategoryRequest(Request $request){
        try{
            $arrayCategiories= CategoryRequest::where('request_active', 1)
            ->orderBy('category_request_id', 'asc')->get();

            if (!empty($arrayCategiories)) {

                return response()->json([
                    'success' => true,
                    'msg' => 'Categorias obtenidas correctamente',
                    'data' => $arrayCategiories
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'msg' => 'No hay datos disponibles',
                    'data' => null
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage(),
            ]);
        }
    }

    public function getSurveys(Request $request)
    {
        // return response()->json($request->user());
        try {
            $dataSearch['search']=(!empty($request->input('search')))?$request->input('search'):'';
            $dataSearch['offset']=(!empty($request->input('offset')))?$request->input('offset'):0;
            $dataSearch['limit']=(!empty($request->input('limit')))?$request->input('limit'):0;
            $dataSearch['sort']=(!empty($request->input('sort'))?$request->input('sort'):'survey_id');
            $dataSearch['order']=(!empty($request->input('order'))?$request->input('order'):'desc');

            $arraySurveys = Survey::getSurveys($dataSearch);
            $arrayAllSurveys = Survey::getAllSurveys($dataSearch);
            $arrayParsingSurveys=\Main::parsingArraySurveys($arraySurveys);


            return response()->json([
                'total'=>count($arrayAllSurveys),
                'totalNotFiltered'=>count($arraySurveys),
                'rows'=>$arrayParsingSurveys]);
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage(), 'success' => false]);
            //return $e->getMessage();
        }
    }
    //surveys
    public function getSurveyById(Request $request){
        try {
            $data['survey_id'] = $request->survey_id;
            $dataSurvey['arrayDetailSurvey']= Survey::getDetailSurveyById($data);
            $dataSurvey['survey_id']=$request->survey_id;
            $arraySurvey= \Main::parsingArrayDetailSurvey($dataSurvey);

            if (!empty($arraySurvey)) {
                return response()->json([
                    'msg' => 'Encuesta obtenida correctamente',
                    'data' => $arraySurvey,
                    'success' => true
                ]);
            } else {
                return response()->json([
                    'msg' => 'No se pudo localizar en la base de datos',
                    'success' => false
                ]);
            }

        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage(), 'success' => false]);
            //return $e->getMessage();
        }
    }

}
