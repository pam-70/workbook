<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Result;
use App\Models\Resulquestion;
use App\Models\Answer;
use App\Models\Resulanswer;
use App\Models\Instal;

use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function resultview(Request $request)
    { //письменный ответ
        if ($request->isMethod('POST')) {
            if (empty($request->numer_testa)) {
                $result = Result::where('user_id', Auth::user()->id)
                    ->where('mark', "!=", "")
                    ->where('mark', "!=", "0")
                    ->orderBy('t_numer', 'asc')
                    //->orderBy('t_numer', 'desc')
                    ->orderBy('mark', 'desc')
                    ->get();
            } else {
                $result = Result::where('t_numer', $request->numer_testa)
                    ->where('user_id', Auth::user()->id)
                    ->where('mark', "!=", "")
                    ->where('mark', "!=", "0")
                    ->orderBy('mark', 'desc')
                    ->get();
            }

            $url_dat = [
                'result' => $result,
            ];
            return ($url_dat);
        }
    }
    public function resulttest(Request $request)
    {
        if ($request->isMethod('POST')) // подсчет результатов и выставление
        {
            $test_id = 256; //257,256,258
            $test_id = $request->result_id;
            $faithful = 0; //верных ответов
            $itog = Resulquestion::with("question", "resultanswer")
                ->where("result_id", $test_id)
                ->get(); //`result_id`
            foreach ($itog as $itog_v) {
                if ($itog_v->question[0]['vid'] == 3) { //если писменный ответ
                    if (trim(mb_strtoupper($itog_v->right_answer_str)) == trim(mb_strtoupper($itog_v->student_answer_str))) {
                        if (trim(mb_strtoupper($itog_v->right_answer_str)) != "") {
                            $faithful++;
                        }
                    }
                }
                $vsego = 0;
                $ansv = 0;
                $answ_wsego = 0;
                foreach ($itog_v->resultanswer as $rezansw) {
                    if ($itog_v->question[0]['vid'] == 1) { //выборный ответ
                        if (trim(mb_strtoupper($rezansw->right_answer)) == trim(mb_strtoupper($rezansw->student_answer))) {
                            if (trim(mb_strtoupper($rezansw->right_answer)) == "1") {
                                $faithful++;
                            }
                        }
                    }
                    if ($itog_v->question[0]['vid'] == 2) { //множественный ответ
                        if (trim(mb_strtoupper($rezansw->right_answer)) == "1") {
                            $vsego++;
                        }
                        if (trim(mb_strtoupper($rezansw->student_answer)) == "1") {
                            $answ_wsego++;
                        }
                        if (trim(mb_strtoupper($rezansw->right_answer)) == "1") {
                            if (trim(mb_strtoupper($rezansw->right_answer)) == trim(mb_strtoupper($rezansw->student_answer))) {
                                $ansv++;
                            }
                        }
                    }
                }
                if ($ansv == $vsego and $vsego != 0 and $answ_wsego == $ansv) {
                    $faithful++;
                }
                $vsego = 0;
                $ansv = 0;
                $answ_wsego = 0;
            }
            $prozent = round((($faithful / $request->all_quest) * 100), 2);

            $mark5 = Instal::find(7)->data * 1; //5
            $mark4 = Instal::find(8)->data * 1; //4
            $mark3 = Instal::find(9)->data * 1; //3
            if ($prozent > $mark5) {
                $mark = 5;
            }
            if ($prozent < $mark5 and $prozent > $mark4) {
                $mark = 4;
            }
            if ($prozent < $mark4 and $prozent > $mark3) {
                $mark = 3;
            }
            if ($prozent < $mark3) {
                $mark = 2;
            }
            // $mark = "5";
            Result::find($test_id)
                ->update(['mark' => $mark]);


            $url_dat = [
                'mark' => $mark,
                'prozent' => $prozent,
            ];

            return ($url_dat);
            // dump($faithful);
            // dd($itog);
        }
    }
    ///---------------------------------------------------
    public function textansver(Request $request)
    { //письменный ответ
        if ($request->isMethod('POST')) {
            Resulquestion::where('result_id', $request->result_id)
                ->where('numerquestion', $request->numer_quest)
                ->update(['student_answer_str' => $request->text_var]);
        }
    }
    //------------------------------------------------------
    public function checkanswer(Request $request)
    { // запись cehck
        if ($request->isMethod('POST')) {
            $arr_chec = $request->check_arr;
            foreach ($arr_chec as $check_id) {
                Resulanswer::where('id', $check_id)
                    ->update(['student_answer' => 1]);
            }
            $url_dat = [
                //'numer_ts' => "YES",
                // 'quest_test' => $next_zapr,
                'answer_test' => $request->check_arr,
                'check_id' => $check_id,
            ];
            return ($url_dat);
        }
    }

    //-------------------------------------------
    public function radioclic(Request $request)
    {
        if ($request->isMethod('POST')) {
            Resulanswer::where('id', $request->click_id)
                ->update(['student_answer' => $request->clik_data]);
        }
    }
    //----------------------------------------------------------
    public function next(Request $request)
    {
        // result_id : this.result_id,
        // numer_quest: this.numer_quest
        $next_zapr = DB::table('resulquestions')
            ->where([
                ['result_id', $request->result_id],
                ['numerquestion', $request->numer_quest]
            ])
            ->join('questions', 'questions.id', '=', 'resulquestions.question_id')
            //->join('resulanswers', 'resulanswers.resulquestion_id', '=', 'resulquestions.id')
            ->get();
        // dd($perv_zapr);
        if ($next_zapr[0]->vid == 1 or $next_zapr[0]->vid == 2) {
            $next_zapr_answ = DB::table('resulquestions')
                ->where([
                    ['result_id', $request->result_id],
                    ['numerquestion', $request->numer_quest]
                ])
                ->join('questions', 'questions.id', '=', 'resulquestions.question_id')
                ->join('resulanswers', 'resulanswers.resulquestion_id', '=', 'resulquestions.id')
                ->get();
        } else {
            $next_zapr_answ[] = 0;
        }

        $url_dat = [
            'numer_ts' => "YES",
            'quest_test' => $next_zapr,
            'answer_test' => $next_zapr_answ,
            // 'time_test' => $time_test,
            // 'all_quest' => $kol_qu,

        ];
        return ($url_dat);
    }
    //--------------------------------------------------------------

    public function starttest(Request $request)
    {
        if ($request->isMethod('POST')) {

            // $idstr = Question::where("t_numer", $request->test_numer)->get();
            if (DB::table('questions')->where('t_numer', $request->test_numer)->exists()) {
                // процедура при условии что есть номер теста
                //запрос на время выполнения
                $time_test = Instal::find(1)->data; //время выполнения теста
                $kol_qu = Instal::find(2)->data; // количество вопросов
                $t_numer = $request->test_numer; // номер теста

                $perv_quest = 1; //начинать с первого вопроса

                $id_result = Result::create([
                    'user_id' => Auth::user()->id,
                    't_numer' => $t_numer,
                    'school' => Auth::user()->school,
                    'klass' => Auth::user()->klass,
                    'numer' => Auth::user()->numer,
                    'name' => Auth::user()->name,

                ]);
                // echo ($id_result->id . "    =ID tebl Result <br>"); // айди записи для добавления в таблицу
                if (Instal::find(10)->data == 0) { // если промежуточная то не 0
                    $idstr = Question::select('id')->where("t_numer", $t_numer)->inRandomOrder()->get(); //случайный выбор 
                } else {

                    $idstr = Question::select('id','t_numer')->havingBetween('t_numer', [Instal::find(10)->data_n, Instal::find(10)->data_k])
                        ->inRandomOrder()->get(); //случайный выбор 
                }

                foreach ($idstr as $name) {
                    $arr[] = $name->id;
                }
                $arr_z = (array_slice($arr, 0, $kol_qu)); // берем 12 вопросов
                $numer_quest = 1;
                foreach ($arr_z as $arr_v) {
                    $vid = Question::find($arr_v);
                    $id_res_quest = Resulquestion::create([ //здесь добавлять в базу вопросы
                        'result_id' => $id_result->id,
                        'question_id' => $arr_v,
                        'numerquestion' => $numer_quest,
                        'right_answer_str' => $vid->right_ansv,

                    ]);

                    if ($vid->vid == 1 or $vid->vid == 2) { //добавляем вопросы
                        $answerb = Answer::where('question_id', $arr_v)
                            ->inRandomOrder()
                            ->get();
                        foreach ($answerb as $answerb_n) {
                            Resulanswer::create([
                                'resulquestion_id' => $id_res_quest->id,
                                'answer_id' => $answerb_n->id,
                                'result_answer' => $answerb_n->answer,
                                'right_answer' => $answerb_n->meaning,
                            ]);
                        };
                    }
                    $numer_quest = $numer_quest + 1;
                }
                $perv_zapr = DB::table('resulquestions')
                    ->where([
                        ['result_id', $id_result->id],
                        ['numerquestion', $perv_quest]
                    ])
                    ->join('questions', 'questions.id', '=', 'resulquestions.question_id')
                    //->join('resulanswers', 'resulanswers.resulquestion_id', '=', 'resulquestions.id')
                    ->get();
                // dd($perv_zapr);
                if ($perv_zapr[0]->vid == 1 or $perv_zapr[0]->vid == 2) {
                    $perv_zapr_answ = DB::table('resulquestions')
                        ->where([
                            ['result_id', $id_result->id],
                            ['numerquestion', $perv_quest]
                        ])
                        ->join('questions', 'questions.id', '=', 'resulquestions.question_id')
                        ->join('resulanswers', 'resulanswers.resulquestion_id', '=', 'resulquestions.id')
                        ->get();
                } else {
                    $perv_zapr_answ[] = 0;
                }

                $url_dat = [
                    'numer_ts' => "YES",
                    'quest_test' => $perv_zapr,
                    'answer_test' => $perv_zapr_answ,
                    'time_test' => $time_test,
                    'all_quest' => $kol_qu,

                ];
                return ($url_dat);
            } else { // если нет теста
                $perv_zapr_answ[] = 0;
                $perv_zapr[] = "";
                $time_test = 0;
                $kol_qu = 0;
                $url_dat = [
                    'numer_ts' => "NO",
                    'test' => $perv_zapr,
                    'answer_test' => $perv_zapr_answ,
                    'time_test' => $time_test,
                    'all_quest' => $kol_qu,

                ];
                return ($url_dat);
            };
        } else { //===============================================================

            // // процедура при условии что есть номер теста
            // $t_numer = "429306"; // номер теста
            // $kol_qu = 12; // количество вопросов
            // $perv_quest = 12; //начинать с первого вопроса
            // //Result::truncate(); // очистить модель
            // $id_result = Result::create([
            //     'user_id' => Auth::user()->id,
            //     't_numer' => $t_numer,
            //     'school' => Auth::user()->school,
            //     'klass' => Auth::user()->klass,
            //     'numer' => Auth::user()->numer,
            //     'name' => Auth::user()->name,

            // ]);
            // // echo ($id_result->id . "    =ID tebl Result <br>"); // айди записи для добавления в таблицу

            // $idstr = Question::select('id')->where("t_numer", $t_numer)->inRandomOrder()->get(); //случайный выбор 
            // // $idstr = Question::select('id')->where("t_numer", $t_numer)->get(); //случайный выбор
            // // dd($idstr);
            // foreach ($idstr as $name) {
            //     // echo ($name->id . "<br>");
            //     $arr[] = $name->id;
            // }
            // $arr_z = (array_slice($arr, 0, $kol_qu)); // берем 12 вопросов
            // //->whereIn('id', [1, 2, 3])
            // // print_r($arr_z);
            // //echo ("<BR>");
            // // echo ("------------------------------------");
            // // echo ("<BR>");
            // $numer_quest = 1;
            // foreach ($arr_z as $arr_v) {
            //     //echo ($arr_v . "<br>"); 
            //     $vid = Question::find($arr_v);
            //     $id_res_quest = Resulquestion::create([ //здесь добавлять в базу вопросы
            //         'result_id' => $id_result->id,
            //         'question_id' => $arr_v,
            //         'numerquestion' => $numer_quest,
            //         'right_answer_str' => $vid->right_ansv,
            //     ]);
            //     //  echo ($id_res_quest->id . " =======");
            //     //  echo ("<BR>");

            //     if ($vid->vid == 1 or $vid->vid == 2) { //добавляем вопросы
            //         $answerb = Answer::where('question_id', $arr_v)
            //             ->inRandomOrder()
            //             ->get();
            //         // dd($answerb);
            //         foreach ($answerb as $answerb_n) {
            //             $resulanswer = Resulanswer::create([
            //                 'resulquestion_id' => $id_res_quest->id,
            //                 'answer_id' => $answerb_n->id,
            //                 'result_answer' => $answerb_n->answer,
            //                 'right_answer' => $answerb_n->meaning,
            //             ]);
            //         };
            //         //dump($answerb);
            //     }
            //     $numer_quest = $numer_quest + 1;
            // }
            // // echo ("------------------------------------");
            // // echo (Auth::user()->id);
            // //dd($idstr);
            // //закнчивается подготовительная часть
            // //выдаем первый вопрос теста

            // $perv_zapr = DB::table('resulquestions')
            //     ->where([
            //         ['result_id', $id_result->id],
            //         ['numerquestion', $perv_quest]
            //     ])
            //     ->join('questions', 'questions.id', '=', 'resulquestions.question_id')
            //     // ->join('resulanswers', 'resulanswers.resulquestion_id', '=', 'resulquestions.id')
            //     ->get();
            // if ($perv_zapr[0]->vid == 1 or $perv_zapr[0]->vid == 2) {
            //     $perv_zapr_answ = DB::table('resulquestions')
            //         ->where([
            //             ['result_id', $id_result->id],
            //             ['numerquestion', $perv_quest]
            //         ])
            //         ->join('questions', 'questions.id', '=', 'resulquestions.question_id')
            //         ->join('resulanswers', 'resulanswers.resulquestion_id', '=', 'resulquestions.id')
            //         ->get();
            // } else {
            //     $perv_zapr_answ[] = 0;
            // }


            // dd($perv_zapr);
        } //закончилась процедура подготовки
    }
}

