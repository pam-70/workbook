<?php

namespace App\Http\Controllers;
//use Illuminate\Support\Facades\DB;
use DB;
use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use App\Models\Resulanswer;
use App\Models\Resulquestion;
use App\Models\Result;
use Illuminate\Http\Request;


class PerenosController extends Controller
{
    public function perenos()
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
