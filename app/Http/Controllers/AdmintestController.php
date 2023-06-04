<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Klass;

use App\Models\Question;
use App\Models\Result;
use App\Models\Resulquestion;
use App\Models\Answer;
use App\Models\Resulanswer;
use App\Models\Instal;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class admintestController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function updateadmin(Request $request)
    {
        $klass=Klass::all();
        $school=School::all();
        $url_dat = [
            'klass' => $klass,
            "school"=>$school,
        ];
        return ($url_dat);
    }
}
