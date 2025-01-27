<?php

namespace App\Http\Controllers\SuperAdmin;
use App\Models\Cours;
use App\Models\Filial;
use App\Models\Test;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
        if(auth()->user()->type=='Techer' || auth()->user()->type=='User' || auth()->user()->type=='Operator' || auth()->user()->type=='Admin'){
            auth()->logout();
            return redirect()->route('login');
        }
        $Cours = Cours::get();
        $Cour = array();
        foreach ($Cours as $key => $value) {
            $Cour[$key]['id'] = $value->id;
            $Cour[$key]['filial'] = Filial::find($value->filial_id)->filial_name;
            $Cour[$key]['cours'] = $value->cours_name;
            $Cour[$key]['testcount'] = count(Test::where('cours_id',$value->id)->get());
        }
        return view('SuperAdmin.test.index',compact('Cour'));
    }

    public function show($id){
        $Test = Test::where('cours_id',$id)->get();
        return view('SuperAdmin.test.show', compact('id','Test'));
    }
    public function create(Request $request){
        $validate = $request->validate([
            'cours_id' => ['required', 'string', 'max:255'],
            'Savol' => ['required', 'string', 'max:255'],
            'TJavob' => ['required', 'string', 'max:255'],
            'NJavob1' => ['required', 'string', 'max:255'],
            'NJavob2' => ['required', 'string', 'max:255'],
            'NJavob3' => ['required', 'string', 'max:255']
        ]);
        Test::create($validate);
        return redirect()->back()->with('success', 'Yangi test savoli qo\'shildi'); 
    }
    public function delete($id){
        $Test = Test::find($id);
        $Test->delete();
        return redirect()->back()->with('success', 'Test savoli o\chirildi.'); 
    }
}
