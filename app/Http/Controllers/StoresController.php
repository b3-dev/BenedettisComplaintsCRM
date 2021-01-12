<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Session;

class StoresController extends Controller
{
    //

    public function storesBySupervisor()
    {
        if (!Auth::check()) {
            return redirect('/');
        } else {
            return view('stores.storesReportBySupervisor');
        }
    }

    public function storesByManager()
    {
        if (!Auth::check()) {
            return redirect('/');
        } else {
            return view('stores.storesReportByManager');
        }
    }
}
