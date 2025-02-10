<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Room;
use App\Models\Cours;
use App\Models\Test;
use App\Models\TestNatija;
use App\Models\GuruhTime;
use App\Models\Guruh;
use App\Models\Video;
use App\Models\GuruhUser;
use App\Models\Tulov;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class UserCoursController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function courss(){
        $userGuruhs = GuruhUser::where('guruh_users.user_id', Auth::user()->id)
            ->join('guruhs', 'guruhs.id', '=', 'guruh_users.guruh_id')
            ->where('guruh_users.status', 'true')
            ->select('guruhs.guruh_start', 'guruhs.guruh_end','guruhs.guruh_name','guruhs.id','guruhs.cours_id')
            ->get();
        $now = date('Y-m-d');
        $Cours = array();
        $k = 0;
        foreach ($userGuruhs as $key => $value) {
            $date = Carbon::parse($value->guruh_end)->addDays(30);
            $Video = Video::where('cours_name',Cours::find($value->cours_id)->cours_name)->select('sort_numbr','lessen_name','video_url')->orderBy('sort_numbr', 'asc')->get();            
            if($date>=$now){
                if($Video){
                    $Cours[$k]['name'] = Cours::find($value->cours_id)->cours_name; 
                    $Cours[$k]['video'] = $Video; 
                    $Cours[$k]['muddat'] = $date; 
                    $k++;
                }
            }
        }
        $uniqueCours = [];
        foreach ($Cours as $item) {
            if (!in_array($item['name'], array_column($uniqueCours, 'name'))) {
                $uniqueCours[] = $item;
            }
        }
        return response()->json([
            "status" => true,
            "message" => "Online Kurslar",
            "cours" => $uniqueCours,
        ]);
    }

    public function test(){
        $userGuruhs = GuruhUser::where('guruh_users.user_id', Auth::user()->id)
            ->join('guruhs', 'guruhs.id', '=', 'guruh_users.guruh_id')
            ->where('guruh_users.status', 'true')
            ->select('guruhs.guruh_start', 'guruhs.guruh_end','guruhs.guruh_name','guruhs.id','guruhs.cours_id')
            ->get();
        $now = date('Y-m-d');
        $Cours = array();
        $k = 0;
        foreach ($userGuruhs as $key => $value) {
            $Testlar = Test::where('cours_id',$value->cours_id)->inRandomOrder()->limit(15)->get();
            $Test = array();
            foreach ($Testlar as $key2 => $value2) {
                $rand = rand(1, 4);
                $Test[$key2]['savol'] = $value2->Savol;
                switch ($rand) {
                    case 1:
                        $Test[$key2]['javob'] = [
                            ["test"=> $value2->TJavob, "status"=> true],
                            ["test"=> $value2->NJavob1, "status"=> false],
                            ["test"=> $value2->NJavob2, "status"=> false],
                            ["test"=> $value2->NJavob3, "status"=> false],
                        ];
                        break;
                    case 2:
                        $Test[$key2]['javob'] = [
                            ["test"=> $value2->NJavob1, "status"=> false],
                            ["test"=> $value2->TJavob, "status"=> true],
                            ["test"=> $value2->NJavob2, "status"=> false],
                            ["test"=> $value2->NJavob3, "status"=> false],
                        ];
                        break;
                    case 3:
                        $Test[$key2]['javob'] = [
                            ["test"=> $value2->NJavob1, "status"=> false],
                            ["test"=> $value2->NJavob2, "status"=> false],
                            ["test"=> $value2->TJavob, "status"=> true],
                            ["test"=> $value2->NJavob3, "status"=> false],
                        ];
                        break;
                    case 4:
                        $Test[$key2]['javob'] = [
                            ["test"=> $value2->NJavob1, "status"=> false],
                            ["test"=> $value2->NJavob2, "status"=> false],
                            ["test"=> $value2->NJavob3, "status"=> false],
                            ["test"=> $value2->TJavob, "status"=> true],
                        ];
                        break;
                    default:
                        return "Noto'g'ri kun!";
                }
            }
            //
            if($Test){
            $Cours[$k]['guruh_id'] = $value->id;  
            $Cours[$k]['name'] = Cours::find($value->cours_id)->cours_name; 
            $Natija = TestNatija::where('guruh_id',$value->id)->where('user_id',Auth()->user()->id)->first();
            if($Natija){
                $Cours[$k]['count'] = $Natija->savol_count; 
                $Cours[$k]['true'] = $Natija->tugri_count; 
                $Cours[$k]['ball'] = $Natija->ball; 
            }else{
                $Cours[$k]['count'] = 0; 
                $Cours[$k]['true'] = 0; 
                $Cours[$k]['false'] = 0; 
                $Cours[$k]['ball'] = 0; 
                TestNatija::create([
                    'filial_id' => Auth()->user()->filial_id,
                    'guruh_id' => $value->id,
                    'user_id' => Auth()->user()->id,
                    'savol_count' => 1,
                    'tugri_count' => 0,
                    'notugri_count' =>0,
                    'ball' => 0,
                ]);
            }
            $Cours[$k]['testlar'] = $Test; 
            }
            $k++;
        }
        $uniqueCours = [];
        foreach ($Cours as $item) {
            if (!in_array($item['name'], array_column($uniqueCours, 'name'))) {
                $uniqueCours[] = $item;
            }
        }
        return response()->json([
            "status" => true,
            "message" => "Testlar",
            "test" => $uniqueCours,
        ]);
    }
    public function test_check(Request $request){
        $natija = $request->validate([
            "guruh_id" => "required",
            "tugri_count" => "required",
        ]);
        $User_ID = Auth()->User()->id;
        $filial_id = Auth()->User()->filial_id;
        $notugri_count = 15 - intval($request->tugri_count);
        $TestNatija = TestNatija::where('guruh_id',$request->guruh_id)->where('user_id',$User_ID)->first();
        if($TestNatija){
            $TestNatija->tugri_count = $request->tugri_count;
            $TestNatija->savol_count = $TestNatija->savol_count+1;
            $TestNatija->ball = $request->tugri_count*2;
            $TestNatija->save();
        }else{
            TestNatija::create([
                'filial_id' => Auth()->user()->filial_id,
                'guruh_id' => $request->guruh_id,
                'user_id' => $User_ID,
                'savol_count' => 1,
                'tugri_count' => $request->tugri_count,
                'notugri_count' =>15-$request->tugri_count,
                'ball' => $request->tugri_count*2,
            ]);
        }
        return response()->json([
            "status" => true,
            "true" => $request->tugri_count,
            "ball" => $request->tugri_count*2,
        ]);
    }
}
