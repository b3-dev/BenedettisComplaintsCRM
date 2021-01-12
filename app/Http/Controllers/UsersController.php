<?php
namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class UsersController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function user(Request $request)
    {
        return response()->json($request->user());
    }


    public function ajaxValidateUserEmail(Request $request)
    {
        if ($request->ajax()) {
            try {
                if (!empty($request->input('email'))) {


                    $clientExist = User::where('email', $request->input('email'))->get();
                    //dd($clientExist);
                    if (count($clientExist) > 0) {
                        return response('La cuenta de email ya se encuentra registrada', 400)
                        ->header('Content-Type', 'text/plain');
                    } else {
                        return response('La cuenta está disponible', 200)
                        ->header('Content-Type', 'text/plain');
                    }
                } else {
                    return response('Petición incorrecta. Not input field', 400)
                    ->header('Content-Type', 'text/plain');
                }
            } catch (\Exception $e) {
                return response('Petición incorrecta ' . $e->getMessage(), 400)
                    ->header('Content-Type', 'text/plain');
            }
        }
    }

}
