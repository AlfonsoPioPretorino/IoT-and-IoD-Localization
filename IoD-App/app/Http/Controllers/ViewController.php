<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Packet;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ViewController extends Controller
{
    function viewHome(){
        return view('home'); #Chiamo la vista
    }
    function collectdata(){
        /* $lastrecord = Packet::latest()->first();
        $pak = json_decode($lastrecord->packetcontent)->rxpk[0];
        return view('test')->with(['pak'=>$pak]); */

        /* $script_path = resource_path().'\scripts\triangulation.py';
        exec('python3 '.$script_path.' ciao ciao fernando', $output);
        error_log(implode($output));  */
        /* $script_path = base_path('resources/scripts/triangulation.py');
        dd($script_path); */

        return view('collectdata');

    }




    
    
}

