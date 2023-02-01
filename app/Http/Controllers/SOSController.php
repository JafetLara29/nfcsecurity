<?php

namespace App\Http\Controllers;

use App\Models\SOS;
use App\Http\Requests\StoreSOSRequest;
use App\Http\Requests\UpdateSOSRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class SOSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sosArray = SOS::where('user_id', Auth::user()->id)->get();
        // dd($sosArray);
        return view('admin.sosreport')->with([
            'sos' => $sosArray
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSOSRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSOSRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SOS  $sOS
     * @return \Illuminate\Http\Response
     */
    public function show(SOS $sOS)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SOS  $sOS
     * @return \Illuminate\Http\Response
     */
    public function edit(SOS $sOS)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSOSRequest  $request
     * @param  \App\Models\SOS  $sOS
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSOSRequest $request, SOS $sOS)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SOS  $sOS
     * @return \Illuminate\Http\Response
     */
    public function destroy(SOS $sOS)
    {
        //
    }

    function makeSOSCall(){
        // Obtenemos la data del usuario guarda 
        $user = User::where('id', Auth::user()->id)
        ->get();
        // Guardamos la info del llamado sos en la db para que sea detectada por el usuario de la organizacion
        $sos = new SOS;
        $sos->user_id = $user[0]->user_admin_id;
        $sos->oficial_id = $user[0]->id;
        $sos->save();
        return Response::json([
            'success' => true
        ]);
    }
    
    function makeSOSReport(){
        return view('admin.sosreport');
    }

    // Metodo para el usuario admin que verifica si hay una llamada sos sin atender
    function checkSOS(){
        $alert = false;
        $exist = DB::table('s_o_s')
        ->where('user_id', Auth::user()->id)
        ->where('checked', false)
        ->exists();
        if($exist){
            $alert = true;
        }
        return Response::json([
            'alert' => $alert
        ]);
    }

    // Marca una llamada sos como atendida
    function checked(Request $request){
        $data = $request->all();
        $sos = SOS::find($data['id']);
        $sos->checked = true;
        $sos->save();
        return $this->index();
    }
    
}
