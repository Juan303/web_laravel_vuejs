<?php

namespace App\Http\Controllers;

use App\Role;
use App\Teacher;
use Illuminate\Http\Request;

class SolicitudeController extends Controller
{
    public function teacher(){
        $user = auth()->user();
        $success = true;
        if(! $user->teacher){
            try{
                \DB::beginTransaction();
                $user->role_id = Role::TEACHER;
                Teacher::create([
                   'user_id' => $user->id
                ]);
            }catch(\Exception $exception){
                \DB::rollBack();
                $success = $exception->getMessage();
            }
            if($success === true){
                \DB::commit();
                auth()->logout();
                auth()->loginUsingId($user->id);
                return back()->with('message', ['type'=>'success', 'text'=> __('Felicidades, ya eres instructor de la plataforma')]);
            }
            return back()->with('message', ['type'=>'danger', 'text'=> $success]);
        }
        else{
            return back()->with('message', ['type'=>'danger', 'text'=> __('Algo ha fallado')]);
        }
    }
}
