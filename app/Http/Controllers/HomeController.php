<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //echo(Auth::user()->roles);
        if (Auth::user()->roles == "student") {
            return view('student');
        }
        if (Auth::user()->roles == "admin") {

            return view('admin');
        }


        //return view('home');
    }
    public function exit()
    { // выход из личного кабинета
        //href="{{ route('logout') }}"
        Auth::logout();
        return redirect('/login');
        $url_dat = [
            'id' => Auth::user()->name,


        ];

        return ($url_dat);
    }
    public function updatestudent(Request $request)
    {
        if ($request->isMethod('POST')) {
            $url_dat = [
                'id' => Auth::user()->id,
                'school' => Auth::user()->school,
                'klass' => Auth::user()->klass,
                'numer' => Auth::user()->numer,
                'name' => Auth::user()->name,
                'time' => 300,

            ];

            return ($url_dat);
        } else {
        }
    }
}
