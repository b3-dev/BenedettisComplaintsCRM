<?php

namespace App\Http\Controllers;
//uses..

use App\RelUserAuth;
use App\RelUserStore;
use Session;
use App\User;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Mail;

class LoginController extends Controller
{

    public function login(Request $request)
    {

        if ($request->ajax()) {
            try {

                $request->validate([
                    'email'       => 'required|string|email',
                    'password'    => 'required|string',
                    // 'remember_me' => 'boolean',
                ]);
                $credentials = request(['email', 'password']);
                //dd(Auth::attempt($credentials));
                if (!Auth::attempt(['email' => $request->email, 'password' => $request->password, 'user_active' => 1])) {
                    return response()->json([
                        'message' => 'Unauthorized'
                    ], 401);
                }

                $user = $request->user();
                // if ($user->user_active > 0) {
                //dd($user->user_id);
                $tokenResult = $user->createToken('Personal Access Token');
                $token = $tokenResult->token;
                if ($request->remember_me) {
                    $token->expires_at = Carbon::now()->addWeeks(1);
                }
                $token->save();
                //$dataLogin
                //SESSION TOKEN GUARDO EN SESION....
                Auth::login($user);
                //GET MENU BY AUTH
                //MULTIPLE MENU
                if (Auth::user()->multiple_auth_level > 0) {
                    session(['SES_ACCESS_TOKEN' => $tokenResult->accessToken]);
                    $arrayRelAuth = RelUserAuth::where('user_id', Auth::user()->user_id)->get();
                    if (!empty($arrayRelAuth)) {
                        return response()->json([
                            'success' => true,
                            'multiple_auth' => true,
                            'array_multiple_auth' => $arrayRelAuth,
                            'main_screen' => '',
                            'access_token' => $tokenResult->accessToken,
                            'token_type'   => 'Bearer',
                            'expires_at'   => Carbon::parse(
                                $tokenResult->token->expires_at
                            )
                                ->toDateTimeString(),
                        ]);
                    } else {
                        //no se trajo el menu
                    }
                } else {
                    $data['auth_id'] = Auth::user()->auth_id;
                    $arrayMenu = User::getAuthMenu($data);
                    if (!empty($arrayMenu) && count($arrayMenu) > 0) {
                        $arrayMainScreen = User::getAuthMainScreen($data);
                        session(['SES_USER_MENU' => $arrayMenu]);
                        session(['SES_ACCESS_TOKEN' => $tokenResult->accessToken]);
                        session(['SES_AUTH_ID' => Auth::user()->auth_id]);


                        //dd(session('SES_ACCESS_TOKEN'));
                        //END SESSION
                        return response()->json([
                            'success' => true,
                            'main_screen' => $arrayMainScreen[0]->url,
                            'access_token' => $tokenResult->accessToken,
                            'token_type'   => 'Bearer',
                            'expires_at'   => Carbon::parse(
                                $tokenResult->token->expires_at
                            )
                                ->toDateTimeString(),
                        ]);
                    } else {
                        return response()->json([
                            'success' => false,
                            'msg' => 'Tu cuenta NO ha sido creada correctamente, por favor, comunicate con el área de sistemas [undefined menuApplication] '
                        ]);
                    }
                }

                /*}
                else{
                    return response()->json([
                        'success' => false,
                        'msg' => 'Tu cuenta se encuentra inactiva o no existe, comunicate con el área de sistemas [undefined userAccount] '
                    ], 400);
                }*/

            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'msg' => '¡Ups! Hubo un error al realizar la operación ' . $e->getMessage()
                ], 400);
            }
        } else {
            return redirect('/');
        }


    }

    public function getAuthMenu(Request $request)
    {
        if (Auth::check()) {
            $data['auth_id'] = $request->auth_id;
            $arrayMenu = User::getAuthMenu($data);
            if (!empty($arrayMenu) && count($arrayMenu) > 0) {
                $arrayMainScreen = User::getAuthMainScreen($data);
                session(['SES_USER_MENU' => $arrayMenu]);
                session(['SES_AUTH_ID' => $request->auth_id]);

                //dd(session('SES_ACCESS_TOKEN'));
                //END SESSION
                return response()->json([
                    'success' => true,
                    'main_screen' => $arrayMainScreen[0]->url,
                    'token_type'   => 'Bearer',

                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'msg' => 'Tu cuenta NO ha sido creada correctamente, por favor, comunicate con el área de sistemas [undefined menuApplication] '
                ]);
            }
        }
    }

    public function authLoader(Request $request){
        if (Auth::check()) {
            $data['user_id'] = Auth::user()->user_id;
            $arrayRelAuth=RelUserAuth::getRelUserAuth($data);
            $data['arrayAuth']=$arrayRelAuth;
            return view('login/authLoader',compact('data'));
        }

    }

    public function logout(Request $request)
    {
        //Auth::user()->token()->revoke();
        Auth::logout();
        Session::flush();
        return redirect('/');
    }

    public function recoveryAccess(Request $request){
        return view('login/recoveryAccessForm');
    }

    public function recoveryProcess(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email'    => 'required|string|email',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'msg' => 'Validator fails '.$validator->errors()
                ], 400);
            }

            $email = trim($request->input('email'));
            if (User::where('email', $email)->exists()) {
                $cadString = Str::random(10);
                $data['password'] = bcrypt($cadString);
                $dataParams['randomStr'] = $cadString;
                $updateAddress = User::where('email', $email)->update($data);
                //Send email
                $to = $email; //email corporativo
                $subject = "Recuperación de contraseña";
                //recibe view, data and anonimus functon
                Mail::send('email.recoveryAccessNotification', $dataParams, function ($msg) use ($to, $subject) {
                    $msg->from('atencionaclientes@benedettis.com', 'Sistema CASA');
                    // ->bcc('mybcc@email.com','My bcc Name') copia oculta,
                    $msg->to($to)->subject($subject);
                });

                if (count(Mail::failures()) > 0) {
                    return response()->json(['msg' => 'Hubo un problema al enviar la notificación a tu correo. ', 'success' => false]);

                } else {
                    $request->session()->flash('SessionRecoverySuccess', 'true');
                    return response()->json([
                        'success' => true,
                        'data' => $cadString,
                        'msg' => 'Se ha enviado un email con tu contraseña temporal'
                    ]);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'msg' => 'La cuenta de email no existe '
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => '¡Ups! Hubo un error al realizar la operación ' . $e->getMessage()
            ]);
        }
    }

    public function recoverySuccess(Request $request){

        if(Session::has('SessionRecoverySuccess')){
            return view('login.recoverySuccess');
        }
        else{
            return redirect('/');
        }

    }

}
