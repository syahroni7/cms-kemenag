<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{

    public function updateProfile(Request $request)
    {
        $data = $request->input();

        $validator = Validator::make($request->all(), [
            'no_hp' => 'required|numeric|min:10',
            'email' => 'required|email',
            'username' => 'required',
            'name' => 'required'
        ], [
            'no_hp.required' => 'No HP tidak boleh Kosong',
            'no_hp.numeric' => 'No HP harus nomor saja',
            'no_hp.min' => 'No HP harus lebih dari 10 digit',
        ]);

        if ($validator->fails()) {
            //Not okay
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
                
        } else {

            $user = Auth::user();
            $user->no_hp = $data['no_hp'];
            $user->email = $data['email'];
            $user->username = $data['username'];
            $user->name = $data['name'];
            $user->profile_photo = $data['profile_photo'];
            $user->save();

            return redirect()->back();
        }
    }


    public function index(){
        $user = Auth::user();
        return view('admin.profile.index', [
            'user' => $user
        ]);
    }
}
