<?php

namespace App\Http\Controllers;
//use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\DB;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Klass;
use App\Models\School;
use App\Models\User;
use App\Models\Resulanswer;
use App\Models\Resulquestion;
use App\Models\Result;
use App\Models\Instal;


use Illuminate\Http\Request;


class PerenosController extends Controller
{
    public function perenos(){

        
    }
    public function perenos17()
    {
        $resukt=User::where("school_id", 2)
        ->where("klass_id", 20)
        ->max("numer");
        echo ($resukt."<br>");
        for ($i = $resukt+1; $i <= $resukt+3; $i++) {
            echo($i."<br>");
        }
        
        dd($resukt);

    }
        public function perenos16()
        {
        //номера всех тестов 
        $result = Question::select('t_numer')
         ->distinct()->orderBy('t_numer', 'asc')->get();
        //     ->where("t_numer", 417021)
        //     ->get();

           // $ntt= DB::table('questions')->select('t_numer')->distinct()->orderBy('t_numer', 'asc')->get();

            
        foreach ($result as $result_v) {
            echo ($result_v->t_numer. "<br>");
            // foreach ($result_v->answer as $answ) {
            //     echo (" ----- ".$answ->answer . "<br>");
            // }
        }
        dd($result);
        //Resulquestion::with("question", "resultanswer")
        // $result=0;
     
    }
    public function perenos15()

    {
        $dt_n = date(Instal::find(3)->data_n);
        // $dt_n = strtotime(Instal::find(3)->data_n);
        $dt_k = date(Instal::find(3)->data_k);
        // $dt_k = strtotime(Instal::find(3)->data_k);
        echo ($dt_n . " ====" . $dt_k . "<br>");
        $result_ar = [];
        $result = Result::whereBetween('updated_at', [$dt_n, $dt_k])
            ->where("school_id", 2)
            ->where("klass_id", 18)
            ->where("mark", ">", 0)
            ->where("t_numer", 417021)
            ->orderBy("numer", "asc")

            ->orderBy("mark", "desc")

            ->distinct()
            ->get();
        $numst = 0;
        $markstud = 0;
        foreach ($result as $result_arr) {
            if ($numst != $result_arr->numer) {
                echo ($result_arr->t_numer . "---" . $result_arr->numer . "---" . $result_arr->mark . "<br>");
                $result_ar[] = $result_arr;
                $numst = $result_arr->numer;
                $markstud = $result_arr->mark;
            }
            echo ($result_arr->t_numer . "================" . $result_arr->numer . "==================" . $result_arr->mark . "==================" . $result_arr->id . "<br>");
        }
        //  $ntt= DB::table('bquestions')->select('t_numer')->distinct()->orderBy('t_numer', 'asc')->get();
        dump($result_ar);
        dd($result);
    } //перенос классов  id usera{}
    public function perenos14() //перенос классов  id usera
    {
        $sh = School::all();
        $result = Result::all();
        $kl = Klass::all();
        foreach ($result as $result_v) {
            foreach ($kl as $kl_v) {
                if ($kl_v->school_id === $result_v->school_id && trim($kl_v->nameklass) === $result_v->klass) {
                    $rezult = User::where('id', $result_v->id)->update(['klass_id' => $kl_v->id]);
                    echo ($result_v->school . " ----" . $result_v->school_id . " -----" . $result_v->klass . "---" . $kl_v->id . "<br>");
                }
            }

            // echo($user_v->name."<br>");
        }

        dd($sh);
    }
    public function perenos13() // перенос id школл в таблицу результатов
    {
        $sh = School::all();
        $result = Result::all();
        $kl = Klass::all();

        foreach ($sh as $sh_v) {
            echo ($sh_v->nameschool . "<br>");
        }
        foreach ($result as $result_v) {
            foreach ($sh as $sh_v) {
                // echo($sh_v->nameschool."<br>");
                if ($result_v->school === $sh_v->nameschool) {
                    $rezult = Result::where('id', $result_v->id)->update(['school_id' => $sh_v->id]);
                    echo ($result_v->name . "------" . $result_v->school . "<br>");
                }
            }
            // echo($user_v->name."<br>");
        }
        dd($sh);
    }
    public function perenos12() //перенос классов  id usera
    {
        $sh = School::all();
        $user = User::all();
        $kl = Klass::all();
        foreach ($user as $user_v) {
            foreach ($kl as $kl_v) {
                if ($kl_v->school_id === $user_v->school_id && trim($kl_v->nameklass) === $user_v->klass) {
                    $rezult = User::where('id', $user_v->id)->update(['klass_id' => $kl_v->id]);
                    echo ($user_v->school . " ----" . $user_v->school_id . " -----" . $user_v->klass . "---" . $kl_v->id . "<br>");
                }
            }

            // echo($user_v->name."<br>");
        }

        dd($sh);
    }
    public function perenos11() // перенос id школл в usera
    {
        $sh = School::all();
        $user = User::all();
        $kl = Klass::all();

        foreach ($sh as $sh_v) {
            echo ($sh_v->nameschool . "<br>");
        }
        foreach ($user as $user_v) {
            foreach ($sh as $sh_v) {
                // echo($sh_v->nameschool."<br>");
                if ($user_v->school === $sh_v->nameschool) {
                    $rezult = User::where('id', $user_v->id)->update(['school_id' => $sh_v->id]);
                    echo ($user_v->name . "------" . $user_v->school . " res=" . $rezult . "<br>");
                }
            }
            // echo($user_v->name."<br>");
        }
        dd($sh);
    }
    public function perenos10()
    { //подсчет правильных ответов
        $test_id = 256; //257,256,258
        $faithful = 0; //верный ответов
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
        dump($faithful);
        dd($itog);
    }
    public function perenos9()
    { //Проверка переноса строк 
        //количество вопросов из формы
        // $itog = DB::table("resulquestions")
        //     ->where("result_id", "258") //256  258
        //     ->join("questions", "resulquestions.question_id", '=', "questions.id")
        //    ->leftJoin("answers", "questions.id", '=', "answers.question_id")
        //    // ->rightJoin("answers", "questions.id", '=', "answers.question_id")
        //     ->get();
        $itog = DB::table("resulquestions")
            ->where("result_id", "258") //256  258
            ->join("questions", "resulquestions.question_id", '=', "questions.id")
            ->leftJoin("resulanswers", "resulquestions.id", '=', "resulanswers.resulquestion_id")
            //    ->leftJoin("answers", "questions.id", '=', "answers.question_id")
            //    // ->rightJoin("answers", "questions.id", '=', "answers.question_id")
            ->get();








        dd($itog);




        $kol_quest = 12;
        $quest_kolvo = 0;
        $itog = Resulquestion::where("result_id", "257") //256
            ->get();
        foreach ($itog as $title) {
            echo ($title->id . " Ответ эталон==== " . $title->right_answer_str . "  Студент ответил ==== " . $title->student_answer_str . "<br>");
            if (trim(mb_strtoupper($title->right_answer_str)) == trim(mb_strtoupper($title->student_answer_str))) {
                if (trim(mb_strtoupper($title->right_answer_str)) != "") {
                    $quest_kolvo++;
                }
            }
        }
        echo ("Вернгых ответов=" . $quest_kolvo);
    }
    public function perenos8()
    { //Проверка переноса строк 
        $itog = Question::where("vid", "1")
            ->get();
        foreach ($itog as $title) {
            echo ($title->id . " ==== " . $title->t_numer . "<br>");
        }
    }
    public function perenos7()
    { //7
        echo ("9999999999999");
        DB::table('titor_bquestions')->truncate(); //очищаем тблицу
        DB::table('titor_banswers')->truncate(); //очищаем тблицу
        $itog = DB::table('titor_questions')->get();
        //     $gg=Questions::all();
        foreach ($itog as $title) {
            echo ("<font size='3' color='red'> ");
            echo "<b>" . $title->n_t . "</font></b><br>";
            echo "id==" . $title->id . "<br>";
            echo $title->v_p . "<br>";
            echo $title->ris . "<br>";
            echo "<b>" . $title->v . "=" . $title->pis_otv . "</b><br>";
            $tyr = DB::table('titor_bquestions')->insert([
                'quest' => $title->v,
                'vid' => $title->v_p,
                't_numer' => $title->n_t,
                'pict' => $title->ris,
                'right_ansv' => $title->pis_otv,
            ]);
            $id_gl = DB::table('titor_bquestions')->max('id');
            echo ($id_gl . "====================<br>");
            if (!empty($title->o1)) {
                echo $title->o1 . "=" . $title->pr1 . "<br>";
                DB::table('titor_banswers')->insert([
                    'bquest_id' => $id_gl,
                    'quest' => $title->o1,
                    'pranswer' => $title->pr1,
                ]);
            }
            if (!empty($title->o2)) {
                echo $title->o2 . "=" . $title->pr2 . "<br>";
                DB::table('titor_banswers')->insert([
                    'bquest_id' => $id_gl,
                    'quest' => $title->o2,
                    'pranswer' => $title->pr2,
                ]);
            }
            if (!empty($title->o3)) {
                echo $title->o3 . "=" . $title->pr3 . "<br>";
                DB::table('titor_banswers')->insert([
                    'bquest_id' => $id_gl,
                    'quest' => $title->o3,
                    'pranswer' => $title->pr3,
                ]);
            }
            if (!empty($title->o4)) {
                echo $title->o4 . "=" . $title->pr4 . "<br>";
                DB::table('titor_banswers')->insert([
                    'bquest_id' => $id_gl,
                    'quest' => $title->o4,
                    'pranswer' => $title->pr4,
                ]);
            }



            echo "---------------------------" . "<br>";
        }
        //dd($itog);
        // $itog = DB::table('bquestions')->get();
    }






    public function perenos6()
    {
        echo ("Проверка на перенос <br>");
        $itog_wse = DB::table('titor_questions')->get();
        foreach ($itog_wse as $title) {
            $itog_od = DB::table('questions')->find($title->id);
            if ($title->v != $itog_od->quest) {
                echo ($title->v . " # " . $itog_od->quest . "<br>");
            }


            // echo($title->id."=".$title->v."<br>");

        }


        dd($itog_wse);
    }
    public function perenos5() //5
    {
        echo ("Проверка на соответствие вопросов и ответов");
        $itog = DB::table('titor_bquestions')
            ->where([
                ['t_numer', '=', '419016'], //419016

            ])
            //->Join('titor_banswers', 'titor_banswers.bquest_id', '=', 'titor_bquestions.id') 
            ->get();
        dd($itog);
    }
    public function perenos4()
    {
        //выполняем по номером строки 17
        $itog = DB::table('resulquestions')
            ->where([
                ['result_id', '=', '17'],
                ['numerquestion', '=', '4']
            ])
            ->Join('questions', 'questions.id', '=', 'resulquestions.question_id')
            ->get();
        //Post::find(1)->comments()->where('title', 'foo')->first();
        // $itog=Result::find(17)->resulquestion()->where('numerquestion', '1')->get();


        dump($itog);
        dump($itog[0]->quest);
        $itogq = DB::table('answers')
            ->where([
                ['question_id', '=', $itog[0]->question_id],
            ])
            ->inRandomOrder()
            //->Join('questions', 'questions.id', '=', 'resulquestions.question_id')
            ->get();
        dd($itogq);


        echo ("999999");
    }
    public function perenos3()
    {
        echo ("Функция переноса");
        $itog = DB::table('questions')
            ->where('t_numer', '417023')
            ->Join('answers', 'questions.id', '=', 'answers.question_id')
            ->select('questions.quest', 'answers.answer')
            ->get();
        dd($itog);
    }
    public function perenos2()
    {
        $itog = DB::table('titor_users')->get();
        // dd($itog);
        $iuy = 0;
        foreach ($itog as $title) {
            echo "id==" . $title->id . "<br>";
            echo "NAME==" . $title->name . "<br>";
            echo "EMAIL==" . $title->email . "<br>";
            echo "PASSWORD==" . $title->password . "<br>";
            echo "PASSWORD STR==" . $title->password_srtr . "<br>";
            echo "ROLES==" . $title->roles . "<br>";
            echo "SCHOOL==" . $title->school . "<br>";
            echo "KLASS==" . $title->klass . "<br>";
            echo "NUMER==" . $title->numer . "<br>";
            //  $yt = User::create([
            //         'name' => $title->name,
            //          'email' => $title->email,
            //          'password' => $title->password,
            //          'password_srtr'=>$title->password_srtr,
            //          'roles'=>$title->roles,
            //          'school'=>$title->school,
            //          'klass'=>$title->klass,
            //          'numer'=>$title->numer,

            //  ]);

        }
    }
    public function perenos1()
    {
        Answer::truncate(); //очищаем тблицу
        $itog = DB::table('titor_banswers')->get();
        // dd($itog);
        $iuy = 0;
        foreach ($itog as $title) {
            //  echo "id==" . $title->id . "<br>";
            // echo "ID вопроса==" . $title->bquest_id. "<br>";
            // echo "<b>" . $title->quest . " Правильный ответ=" . $title->pranswer . "</b><br>";

            Answer::create([
                'question_id' => $title->bquest_id,
                'answer' => $title->quest,
                'meaning' => $title->pranswer,

            ]);
        }
        //$ws=Answer::get();   `question_id`
        //dd($ws);

    }
    public function perenos0()
    {
        //DB::table('banswers')->truncate(); //очищаем тблицу
        //DB::table('bquestions')->truncate(); //очищаем тблицу
        Question::truncate(); //очищаем тблицу
        $itog = DB::table('titor_bquestions')->get();

        foreach ($itog as $title) {

            echo "id==" . $title->id . "<br>";
            echo "Номер теста==" . $title->t_numer . "<br>";
            echo "<b>" . $title->quest . " Правильный ответ=" . $title->right_ansv . "</b><br>";

            echo "вид задания=" . $title->vid . "  Файл рисунка=" . $title->pict . "<br>";
            // $rt=Question::all();
            $yt = Question::create([
                'quest' => $title->quest,
                't_numer' => $title->t_numer,
                'vid' => $title->vid,
                'pict' => $title->pict,
                'right_ansv' => $title->right_ansv,
            ]);
            //$table->integer('question_id')->nullable();//таблица ответов
            // $table->string('answer')->nullable();//ответ на вопрос
            // $table->string('meaning')->nullable();//значение 0-1
            // $table->string('prim')->nullable();//примечание


            //  echo $title->ris ."<br>";
            // echo "<b>". $title->v ."=".$title->pis_otv ."</b><br>";
            //dd($itog);
            echo ("----------------------------- <BR>");
            // $table->text('quest');//
            // $table->string('t_numer');//
            // $table->string('vid');//
            // $table->string('pict');//
            // $table->string('ball');//
            //$table->string('right_ansv');//
            // return User::create([
            //     'name' => $data['name'],
            //     'email' => $data['email'],
            //     'password' => Hash::make($data['password']),
            //     'password_str' => $data['password'],
            // ]);

        }
        echo "perenos";
    }
}
//$flight = App\Flight::create(['name' => 'Flight 10']);
           // $table->integer('question_id');//таблица ответов
          // $table->string('quest');//
           //$table->string('t_numer');//
           //$table->string('vid');//
           //$table->string('pict');//
           //$table->string('ball');//
           //$table->string('right_ansv');//
           //$table->string('pr');//
           //$table->timestamps();
