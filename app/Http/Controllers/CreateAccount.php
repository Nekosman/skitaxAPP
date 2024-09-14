<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAccount extends Controller
{
    public function creatingAccount(){
        return view('userlist.createacc');
       }
    
        public function CreateAccount(Request $request)
        {
            Validator::make($request->all(),[
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed'
            ])->validate();
    
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'type' => 'petugas', // Set default type as admin
                'is_approved' => false // Set default value for is_approved
            ]);
    
            return redirect()->route('userlist');
        }
}
