<?php

namespace App\Http\Controllers;

use App\Rules\StrengthPassword;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(){
        $user = auth()->user()->load('social_account');
        return view('profile.index')->with(compact('user'));
    }

    public function update(Request $request){
        $this->validate($request, [
            'password' => ['confirmed', new StrengthPassword]
            ]);
        $user = auth()->user();
        $user->password = bcrypt($request->get('password'));
        $user->save();
        return back()->with('message', ['type'=>'success', 'text'=>'Contraseña actualizada con éxito']);
    }
}
