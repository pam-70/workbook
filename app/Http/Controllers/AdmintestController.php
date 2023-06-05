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
        $klass = Klass::all();
        $school = School::all();
        $url_dat = [
            'klass' => $klass,
            "school" => $school,
        ];
        return ($url_dat);
    }
    public function updateschool(Request $request) // обновляем данные школы
    {
        // $request->inputschool;
        //$request->schoolid;
        $rezult = School::where('id', $request->schoolid)->update(['nameschool' => $request->inputschool]);
        $url_dat = [
            "school" => $rezult,
        ];
        return ($url_dat);
    }
    public function addschool(Request $request)
    {
        $rezult = School::create(['nameschool' => $request->inputschool]);
        $url_dat = [
            "school" => $rezult,
        ];
        return ($url_dat);
    }
    public function delschool(Request $request){
        $rezult = School::destroy($request->schoolid);
        $url_dat = [
            "school" => $rezult,
        ];
        return ($url_dat);

    }
}
