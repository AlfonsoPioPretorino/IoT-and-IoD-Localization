<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Session;
use DB;

class SessionController extends Controller
{
    function addSession(Request $request){
        #Creazione Nuova sessione dai dati presi dal form.
        $new_session = new Session();

        $new_session->g1 = json_encode(array("g1la"=>$request->g1la, "g1lo"=>$request->g1lo));
        
        $new_session->g2 = json_encode(array("g2la"=>$request->g2la, "g2lo"=>$request->g2lo));
        
        $new_session->g3 = json_encode(array("g3la"=>$request->g3la, "g3lo"=>$request->g3lo));
        
        $new_session->save(); #Salvataggio su DB
        
        $request->session()->put(["ID-session" => $new_session->id, 'success'=>'Session started']);
        
        return view('map', ['session'=>$new_session]);
    } 

    function viewMap($id){
        $ses = DB::table("sessions")->where('id', '=', $id)->first();
        
        return view('map', ['session'=>$ses]);
    }
}
