<?php

namespace App\Http\Controllers\SuperAdmin;
use App\Models\User;
use App\Models\Filial;
use App\Models\GuruhUser;
use App\Models\Guruh;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportsController extends Controller
{
    public function activeUser(){
        $Filial = Filial::get();
        $startDate = Carbon::now()->subMonths(5)->startOfMonth(); // Oxirgi 6 oyni olish uchun
        $formattedDates = [];
        for ($i = 0; $i < 6; $i++) {
            $formattedDates[] = [
                'Y-m' => $startDate->format('Y-m'),
                'Y-M' => $startDate->format('Y-M'),
            ];
            $startDate->addMonth();
        }
        return view('SuperAdmin.activeUsers.index',compact('Filial','formattedDates'));
    }

    public function uploadActiveUser(Request $request){
        $FilialID = $request->filial_id;
        $Start = $request->monchs.'-01';
        $End = $request->monchs.'-31';
        $Guruh = Guruh::where('guruh_start','<=',$End)->where('guruh_end','>=',$Start)->where('guruh_status','true')->where('filial_id',$FilialID)->get();
        $Users = array();
        $keys = 0;
        foreach ($Guruh as $key => $value) {
            $GuruhID = $value->id;
            $techer = User::find($value['techer_id'])->name;
            $GuruhName = $value->guruh_name;
            $guruh_start = $value->guruh_start;
            $guruh_end = $value->guruh_end;
            $GuruhUser = GuruhUser::where('guruh_id',$GuruhID)->where('status','true')->get();
            foreach ($GuruhUser as $valuess) {
                $User = User::find($valuess->user_id)->name;
                $Users[$keys]['guruh_id'] = $GuruhID;
                $Users[$keys]['guruh_name'] = $GuruhName;
                $Users[$keys]['guruh_start'] = $guruh_start;
                $Users[$keys]['guruh_end'] = $guruh_end;
                $Users[$keys]['techer'] = $techer;
                $Users[$keys]['user_id'] = $valuess->user_id;
                $Users[$keys]['user'] = $User;
                $keys++;
            }
        }
        return view('SuperAdmin.activeUsers.print',compact('Users','End','Start'));
    }

}
