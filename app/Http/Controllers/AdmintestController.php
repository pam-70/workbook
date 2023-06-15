<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Klass;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
    public function filtrpass (Request $request){
        $result = User::where('klass_id', $request->klassid)
        ->orderBy("numer","asc")
        ->get();
       
       
        $url_dat = [
            "result" => $result,
        ];
        return ($url_dat);

    }
    public function addstudent(Request $request)
    {
        $url_dat = [
            "result" => "777",
        ];
        return ($url_dat);

    //     // $t1=rand(1000,10000) . "\n";
    //     //$t2=rand(1000,10000) . "\n";
    //     $ar1 = [];
    //     for ($t = 0; $t < 1000; $t++) {
    //         $login = (string)rand(1000, 10000) . "=" . (string)rand(1000, 10000) . "=" . (string)rand(1000, 10000);
    //         $pasw = (string)rand(10000, 100000);
    //         //$paswmd = Hash::make($pasw);
    //         $ar1[] = $login;
    //     }
    //     $ar2 = $ar1;
    //     $n = count($ar2);
    //     for ($t = 0; $t < $n; $t++) {
    //         $sr=0;
    //         for ($v = 0; $v < $n; $v++) {
    //             if ($ar2[$t] === $ar1[$v] && $sr>1) {
    //                 echo $ar2[$t]."<br>";
    //                 $sr++;
    //             }
    //         }
    //     }






    //    // dd($ar2);
    //     //  echo $login . " пароль " . $pasw . " HASH= " . $paswmd;


    //     $fio = array("Петрович", "Вольдемарыч", "Сансаныч");
    //     $n = count($fio);
    //     $a = 1;
    //     for ($t = 0; $t < $n; $t++) {
    //         echo $fio[$t] . "<br>";
    //         if ($t == $a) {
    //             echo "<b>Попался, Вольдемарыч </b>" . "<br>";
    //         }
    //     }
    }
    public function saveinstal(Request $request)
    {


        $result = Instal::where('id', $request->id)
            ->update([
                'data' => $request->konst,
                'data_n' => $request->d_n,
                'data_k' => $request->d_k,
            ]);

        $url_dat = [
            "result" => $result,
        ];
        return ($url_dat);
    }
    public function updateinstall(Request $request)
    {
        $instal = Instal::all();

        $url_dat = [
            "instal" => $instal,
        ];
        return ($url_dat);
    }
    public function allnumer(Request $request)
    {
        $result = Question::select('t_numer')
            ->distinct()->orderBy('t_numer', 'asc')->get();
        $url_dat = [
            "result" => $result,
        ];
        return ($url_dat);
    }

    public function alltest(Request $request)
    { // просмотр результатов админа
        $result = $request->numertest;
        $result = Question::with("answer")
            // ->where("t_numer", $request->numertest)
            ->where("t_numer", "like", $request->numertest . "%")
            ->orderBy("t_numer", "asc")
            ->get();


        $url_dat = [
            "result" => $result,
        ];
        return ($url_dat);
    }


    public function showresult(Request $request)
    { // просмотр результатов админа
        //определение диапазона четверти
        if ($request->quarter > 0) {
            $dt_n = date(Instal::find($request->quarter)->data_n);
            $dt_k = date(Instal::find($request->quarter)->data_k);
        } else {
            $dt_n = date(Instal::find(3)->data_n);
            $dt_k = date(Instal::find(6)->data_k);
        }


        if ($request->numertest > 0) {
            if ($request->numerstudent > 0) {
                $result = Result::whereBetween('updated_at', [$dt_n, $dt_k])
                    ->where("school_id", $request->schoolid)
                    ->where("klass_id", $request->klassid)
                    ->where("numer", $request->numerstudent)
                    ->where("mark", ">", 0)
                    ->where("t_numer", $request->numertest)
                    ->orderBy("mark", "desc")
                    ->get();
            } else {
                //сдесь вывод только по одной оценки
                $result = [];
                $result_zap  = Result::whereBetween('updated_at', [$dt_n, $dt_k])
                    ->where("school_id", $request->schoolid)
                    ->where("klass_id", $request->klassid)
                    ->where("mark", ">", 0)
                    ->orderBy("numer", "asc")
                    ->where("t_numer", $request->numertest)
                    ->orderBy("mark", "desc")
                    ->get();
                $numst = 0;
                foreach ($result_zap as $result_arr) {
                    if ($numst != $result_arr->numer) {
                        //echo ($result_arr->t_numer . "---" . $result_arr->numer . "---" . $result_arr->mark . "<br>");
                        $result[] = $result_arr;
                        $numst = $result_arr->numer;
                    }
                }
            }
        } else {


            if ($request->numerstudent > 0) {
                $result = Result::whereBetween('updated_at', [$dt_n, $dt_k])
                    ->where("school_id", $request->schoolid)
                    ->where("klass_id", $request->klassid)
                    ->where("numer", $request->numerstudent)
                    ->where("mark", ">", 0)
                    ->orderBy("t_numer", "asc")
                    ->orderBy("mark", "desc")
                    ->get();
            } else {
                if ($request->checkedtest == false) {
                    $result = Result::whereBetween('updated_at', [$dt_n, $dt_k])
                        ->where("school_id", $request->schoolid)
                        ->where("klass_id", $request->klassid)
                        ->where("mark", ">", 0)
                        ->orderBy("numer", "asc")
                        ->orderBy("t_numer", "asc")
                        ->orderBy("mark", "desc")
                        ->get();
                } else {
                    $result = Result::whereBetween('updated_at', [$dt_n, $dt_k])
                        ->where("school_id", $request->schoolid)
                        ->where("klass_id", $request->klassid)
                        ->where("mark", ">", 0)
                        ->orderBy("t_numer", "asc")
                        ->orderBy("numer", "asc")
                        ->orderBy("mark", "desc")
                        ->get();
                }
            }
        }
        $url_dat = [
            "result" => $result,
        ];
        return ($url_dat);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
    public function delklass(Request $request)
    {
        $rezult = Klass::destroy($request->klassid);
        $url_dat = [
            "school" => $rezult,
        ];
        return ($url_dat);
    }
    public function updateadmin(Request $request)
    {
        $klass = Klass::orderBy('nameklass', 'asc')->get();
        //->orderBy('t_numer', 'desc')all();
        $school = School::orderBy('nameschool', 'asc')->get();
        $url_dat = [
            'klass' => $klass,
            "school" => $school,
            "password"=>"778611",
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
    public function addschool(Request $request) //добавляем школу
    {
        $rezult = School::create(['nameschool' => $request->inputschool]);
        $url_dat = [
            "school" => $rezult,
        ];
        return ($url_dat);
    }
    public function delschool(Request $request)
    { // удаляем школу
        $rezult = School::destroy($request->schoolid);
        $url_dat = [
            "school" => $rezult,
        ];
        return ($url_dat);
    }
    public function filtrklass(Request $request)
    {
        $rezult = Klass::where('school_id', $request->schoolid)->get();
        $url_dat = [
            "klass" => $rezult,
        ];
        return ($url_dat);
    }
    public function updateklass(Request $request)
    {
        $rezult = Klass::where('id', $request->klassid)->update(['nameklass' => $request->inputklass]);
        if ($rezult == 0) {
            $mess = "Такого класса нет. необходимо выбрать из списка.";
        } else {
            $mess = "Обновил имя класса.";
        }
        $url_dat = [
            "klass" =>  $mess,
            "result" => $rezult,

        ];
        return ($url_dat);
        //inputklass: this.inputklass,
        //klassid: this.klassid,

    }
    public function addklass(Request $request)
    {
        $rezult = Klass::create(
            [
                'nameklass' => $request->inputklass,
                'school_id' => $request->schoolid
            ], //`school_id`
        );
        $url_dat = [
            "klass" => $rezult,
        ];
        return ($url_dat);
    }
}
