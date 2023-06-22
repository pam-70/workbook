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
    public function delquest(Request $request)
    {
        //quest_id   vid
        Question::find($request->quest_id)->delete();
        if ($request->vid < 3) {
            Answer::where("question_id", $request->quest_id)->delete();
        }
        $url_dat = [
            "quest" =>  "OK",

        ];
        return ($url_dat);
    }
    public function editquest(Request $request)
    {

        if (!empty($request->pict)) {
            $pict =  $request->pict;
        } else {
            $pict = "";
        }
        //->update(['delayed' => 1]);
        $quest_id = Question::where("id", $request->quest_id)
            ->update([
                'quest' => $request->quest,
                't_numer' => $request->numertest,
                'pict' => $pict,
                'right_ansv' => $request->answer,
                'vid' => $request->vid,
            ]);
        //answer_id
        if ($request->vid < 3) {
            $per = 0;
            $checked = $request->checked;
            $answer_id = $request->answer_id;
            foreach ($request->inputtext as $inputtext) {
                if ($checked[$per] === true) {
                    $meaning = 1;
                } else {
                    $meaning = 0;
                }
                $an = Answer::where("id", $answer_id[$per])
                    ->update([

                        'answer' => $inputtext,
                        'meaning' => $meaning,
                    ]);
                $per++;
            }
        }




        $url_dat = [
            "quest" =>  $request->checked,

        ];
        return ($url_dat);
    }
    public function watchquest(Request $request)
    {
        $quest = "";
        $quest = Question::find($request->quest_id);
        $ansv = "";
        $checked = [];
        $inputtext = [];
        $id_answer = [];

        if ($quest->vid < 3) {
            $ansv = Answer::where('question_id', $request->quest_id)->get();
            foreach ($ansv as $ansv_ar) {
                if ($ansv_ar->meaning == 1) {
                    $checked[] = true;
                } else {
                    $checked[] = false;
                }

                $inputtext[] = $ansv_ar->answer;
                $id_answer[] = $ansv_ar->id;
            }
        }
        //checked
        // inputtext

        $url_dat = [
            "quest" => $quest,
            // "checked" => $checked,
            "checked" => $checked,
            "inputtext" => $inputtext,
            "labels" => $id_answer,
        ];
        return ($url_dat);
    }
    public function addquest(Request $request)
    {
        // checked: this.checked,
        // inputtext: this.inputtext,
        if (!empty($request->pict)) {
            $pict = $request->numertest . "_" . $request->pict . ".jpg";
        } else {
            $pict = "";
        }

        $quest_id = Question::create([
            'quest' => $request->quest,
            't_numer' => $request->numertest,
            'pict' => $pict,
            'right_ansv' => $request->answer,
            'vid' => $request->vid,
        ]);

        if ($request->vid < 3) {
            $per = 0;
            $checked = $request->checked;
            foreach ($request->inputtext as $inputtext) {
                $an = Answer::create([
                    'question_id' => $quest_id->id,
                    'answer' => $inputtext,
                    'meaning' => $checked[$per],
                ]);
                $per++;
            }
        }
        $url_dat = [
            "school" => $quest_id->id,
        ];
        return ($url_dat);
    }


    public function deluser(Request $request) // удаление списка класса
    {
        $rezult = User::where('klass_id', $request->klassid)->delete();
        $url_dat = [
            "school" => $rezult,
        ];
        return ($url_dat);
    }
    public function filtrpass(Request $request)
    {
        $result = User::where('klass_id', $request->klassid)
            ->orderBy("numer", "asc")
            ->get();
        // this.school_name=response.data.school_name;
        // this.klass_name=response.data.klass_name;
        $school_name = School::find($request->schoolid)->nameschool;
        $klass_name = Klass::find($request->klassid)->nameklass;


        $url_dat = [
            "result" => $result,
            "school_name" => $school_name,
            "klass_name" => $klass_name,
        ];
        return ($url_dat);
    }
    public function addstudent(Request $request)
    {
        $resukt = 0;
        $resukt = User::where("school_id", $request->schoolid)
            ->where("klass_id", $request->klassid)
            ->max("numer");
        // echo ($resukt . "<br>");

        for ($i = $resukt + 1; $i <= $request->kolstudent + $resukt; $i++) {
            $login = (string)rand(1000, 10000) . "=" . (string)rand(1000, 10000) . "=" . (string)rand(1000, 10000);
            $pasw = (string)rand(10000, 100000);
            $paswmd = Hash::make($pasw);


            $res = User::create([
                'name' => $login,
                'password_srtr' => $pasw,
                'password' => $paswmd,
                "numer" => $i,
                "school_id" => $request->schoolid,
                "klass_id" => $request->klassid
            ]);
        }

        $url_dat = [
            "result" => $res,
        ];
        return ($url_dat);


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
        if ($request->exactly == true) {
            $result = Question::with("answer")
                // ->where("t_numer", $request->numertest)
                ->where("t_numer", "like", $request->numertest . "%")
                ->orderBy("t_numer", "asc")
                ->get();
        } else {
            $result = Question::with("answer")
                // ->where("t_numer", $request->numertest)
                ->where("t_numer", $request->numertest)
                ->orderBy("t_numer", "asc")
                ->get();
        }


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

    public function updateadmin(Request $request)
    {
        $klass = Klass::orderBy('nameklass', 'asc')->get();
        //->orderBy('t_numer', 'desc')all();
        $school = School::orderBy('nameschool', 'asc')->get();
        $pass = Instal::find(11)->data;
        $url_dat = [
            'klass' => $klass,
            "school" => $school,
            "password" => $pass,
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
