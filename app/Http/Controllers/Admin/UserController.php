<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users=User::where('role','!=','admin')
            ->when($request->filled('role'),fn($q)=>$q->where('role',$request->role))
            ->when($request->filled('q'),fn($q)=>$q->where(fn($x)=>$x->where('name','like','%'.$request->q.'%')->orWhere('email','like','%'.$request->q.'%')))
            ->latest()->paginate(15)->withQueryString();
        return view('admin.users.index',compact('users'));
    }

    public function storeStaff(Request $request)
    {
        $data=$request->validate([
            'name'=>['required','string','max:100'],
            'email'=>['required','email','unique:users,email'],
            'password'=>['required',Password::min(8)],
        ]);
        User::create($data+['role'=>'staff','status'=>'active']);
        return back()->with('success','Staff account created.');
    }

    public function toggle(User $user)
    {
        abort_if($user->role==='admin',403);
        $user->update(['status'=>$user->status==='active'?'inactive':'active']);
        return back()->with('success','Account status updated.');
    }
}
