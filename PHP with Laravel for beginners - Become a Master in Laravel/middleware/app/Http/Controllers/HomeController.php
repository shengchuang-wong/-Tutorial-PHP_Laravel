<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // $request->session('edwin'=>'master instructor');

        // session(['peter'=>'student']);

        // $request->session()->get('edwin');

        // echo $request->session()->all(); 

        // return view('home');

        // session(['edwin2'=>'your teacher']);

        // $request->session()->forget('edwin2');

        // // delete all session
        // $request->session()->flush();

        // return session('edwin2');

        // $request->session()->flash('message', 'Post has been created');

        // return $request->session()->get('message'); 

        $request->session()->reflash();

        $request->session()->keep('message');
    }
}
