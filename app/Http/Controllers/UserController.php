<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

//Controller para administrar los usuarios de oficiales
class UserController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }  

    // Metodo que extrae los usuarios de los guardas ligados a la empresa logueada
    public function index(){
        $users = DB::table('users')
            ->select('id', 'name', 'email')
            ->where('user_admin_id', Auth::user()->id)
            ->get();
        return view('admin.users')->with([
            'users' => $users
        ]);
    }

    public function create(){
        return view('admin.createuser');
    }

    // Registration for agents
    public function store(Request $request)
    {
        User::create([
            'name'          => $request['name'],
            'email'         => $request['email'],
            'password'      => Hash::make($request['password']),
            'user_admin_id' => Auth::user()->id, 
            'is_admin'      => false
        ]);
        return $this->index(); 
    }
}
