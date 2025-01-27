<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Filial;
use App\Models\GuruhUser;
use App\Models\User;
use App\Models\UserHistory;
use App\Events\CreateTashrif;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BlogController extends Controller{
    public function createBlog($smm){
        return view('Admin.blog.users.index',compact('smm'));
    }
    public function createBlogStory(Request $request){
        $validate = $request->validate([
            'name1' => ['required', 'string', 'max:255'],
            'name2' => ['required', 'string', 'max:255'],
            'phone1' => ['required', 'string', 'max:255'],
            'phone2' => ['required', 'string', 'max:255'],
            'addres' => ['required', 'string', 'max:255'],
            'tkun' => ['required', 'string', 'max:255'],
            'smm' => ['required', 'string', 'max:255']
        ]);
        $Blog = Blog::create([
            'name' => $request->name1." ".$request->name2,
            'phone1' => $request->phone1,
            'phone2' => $request->phone2,
            'addres' => $request->addres,
            'tkun' => $request->tkun,
            'smm' => $request->smm,
        ]);
        return redirect()->back()->with('success', 'Tabriklaymiz siz ro\'yhatga olindingiz tez orada siz bilan menejerlarimiz bog\'lanadi.'); 
    }
    public function newBlog(){
        $Blog = Blog::where('status','new')->get();
        return view('Admin.blog.index',compact('Blog'));
    }
    public function newBlogshow($id){
        $Blog = Blog::find($id);
        $Reg = array();
        $User = User::where('phone',$Blog->phone1)->where('type','User')->first();
        if($User){
            $Reg['name'] = $User['name'];
            $Reg['phone'] = $User['phone'];
            $Reg['filial'] = Filial::find($User['filial_id'])->filial_name;
            $Status = 1;
        }else{
            $Status = 0;
        }
        return view('Admin.blog.index_show',compact('Blog','Reg','Status'));
    }
    public function newBlogupdate(Request $request){
        $Blog = Blog::find($request->id);
        $Admin = Auth::user()->email;
        if(Auth::user()->type=='SuperAdmin'){
            $Filial_id = Filial::first()->id;
        }else{
            $Filial_id = Auth::user()->filial_id;
        }
        if($request->status == 'delete'){
            $Blog->status = $request->status;
            $Blog->commit = $request->commit;
            $Blog->meneger = $Admin;
            $Blog->save();
            return redirect()->route('blogs')->with('success', "Blog o'chirildi"); 
        }
        if($request->status == 'arxiv'){
            $Blog->status = $request->status;
            $Blog->commit = $request->commit;
            $Blog->meneger = $Admin;
            $Blog->save();
            return redirect()->route('blogs')->with('success', "Arxivga saqlandi"); 
        }
        if($request->status == 'register'){
            $email = "F".time();
            $parol = rand(10000000,99999999);
            $NewUser = User::create([
                'filial_id' => $Filial_id,
                'name' => $Blog->name,
                'phone' => $Blog->phone1,
                'phone2' => $Blog->phone2,
                'addres' => $Blog->addres,
                'tkun' => $Blog->tkun,
                'type' => 'User',
                'status' => 'true',
                'about' => $request->commit,
                'smm' => $Blog->smm,
                'balans' => 0,
                'email' => $email,
                'password' => Hash::make($parol),
                'admin_id' => Auth::User()->id,
            ]);
            $Phone = str_replace(" ","",$Blog->phone1);
            $UserHistory = UserHistory::create([
                'filial_id' => $Filial_id,
                'user_id' => $NewUser->id,
                'status' => 'Form orqali tashrif',
                'balans' => 0,
            ]);
            CreateTashrif::dispatch($NewUser->id,$Phone,$parol);
            $Blog->status = $request->status;
            $Blog->commit = $request->commit;
            $Blog->meneger = $Admin;
            $Blog->user_id = $NewUser->id;
            $Blog->save();
            return redirect()->route('StudentShow',$NewUser->id)->with('success', "Form orqail yangi talaba");
        }
        dd($request);
    }
    
    public function regBlog(){
        $Blogs = Blog::where('blogs.status','register')->join('users','blogs.user_id','=','users.id')->get();
        $Blog = array();
        foreach ($Blogs as $key => $value) {
            $Blog[$key]['user_id'] = $value['user_id'];
            $Blog[$key]['name'] = $value['name'];
            $Blog[$key]['phone'] = $value['phone'];
            $GuruhUser = GuruhUser::where('user_id',$value['user_id'])->where('status','true')->get();
            $GuruhUserEnd = GuruhUser::where('user_id',$value['user_id'])->where('status','false')->get();
            $Blog[$key]['guruhlar'] = count($GuruhUser);
            $Blog[$key]['guruhlarEnd'] = count($GuruhUserEnd);
            $Blog[$key]['created_at'] = $value['created_at'];
        }
        return view('Admin.blog.reg_blog',compact('Blog'));
    }
    
    public function arxivBlog(){
        $Blog = Blog::where('status','arxiv')->get();
        return view('Admin.blog.arxiv_blog',compact('Blog'));
    }

    public function arxivBlogshow($id){
        $Blog = Blog::find($id);
        $Reg = array();
        $User = User::where('phone',$Blog->phone1)->where('type','User')->first();
        if($User){
            $Reg['name'] = $User['name'];
            $Reg['phone'] = $User['phone'];
            $Reg['filial'] = Filial::find($User['filial_id'])->filial_name;
            $Status = 1;
        }else{
            $Status = 0;
        }
        return view('Admin.blog.arxiv_blog_show',compact('Blog','Reg','Status'));
    }
    
    public function deleteBlog(){
        $Blog = Blog::where('status','delete')->get();
        return view('Admin.blog.delete_blog',compact('Blog'));
    }



}
