<?php

namespace App\Http\Controllers;

use App\Models\Listtask;


use Illuminate\Http\Request;

class TaskController extends Controller
{
    //
    public function oneentry(Request $request)
    {
        if ($request->isMethod('POST')) {
            
            $idstr =Listtask::find($request->idstr);

            $url_dat = [
                'id' =>$idstr->id,
                'name' =>$idstr->name,
                'numer' =>$idstr->numer,
                'klass' =>$idstr->klass,
                'time' =>$idstr->time,
                'num_quest' =>$idstr->num_quest,
                'purpose' =>$idstr->purpose,
            ];

            return ($url_dat);

        } else {
        }
    }
    public function update(Request $request) //updatuser
    {
        if ($request->isMethod('POST')) {
            $url_all = Listtask::all();
            // pluck('name', 'numer');
            $all_arr = [];
            foreach ($url_all as $url_alls) {
                $all_arr[] = $url_alls->name;
            }

            //$all_arr = json_encode($url_all);
            $url_dat = [
                'all' => $url_all,
            ];

            return ($url_dat);
        }
    }

    public function addtask(Request $request) //updatuser

    {
        //$flights = App\Flight::all();
        //$rty=Listtask::all();

        if ($request->isMethod('POST')) {

            Listtask::create([
                'name'  => $request->nametask,
                'numer'  => $request->numertask,
                'klass'  => $request->klass,
                'time'  => $request->timetask,
                'num_quest'  => $request->quanttask,
                'purpose'  => $request->periodtask,
            ]);

            $dat_list = Listtask::all();

            $url_dat = [
                'url_err' => $dat_list,
            ];
            return ($url_dat);
        } else {
            // dd(Listtask::all());
            return view('welcome');
        }
    }
}
