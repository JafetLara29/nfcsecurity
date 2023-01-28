<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SOSController extends Controller
{
    function makeSOSCall(){
        return 'Llamada de ayuda';
    }
    // Metodo que se ejecuta cada 10 segundos verificando si hay una llamada sos
    function checkAlert(){
        return 'Chekeando llamada de sos';
    }

    function makeSOSReport(){
        return view('admin.sosreport');
    }

    function checkSOS(){
        return Response::json([
            'alert' => true
        ]);
    }
    function checked(){
        return Response::json([
            'result' => true
        ]);
    }
}
