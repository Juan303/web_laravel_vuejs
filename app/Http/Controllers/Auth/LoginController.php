<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Student;
use App\User;
use App\UserSocialAccount;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        session()->flush();
        return redirect('/login');
    }

    //SOCIALITE
    public function redirectToProvider(string $driver){
        return Socialite::driver($driver)->redirect();
    }

    public function handleProviderCallback(string $driver){
        if(!request()->has('code') || request()->has('denied')){
            session()->flash('message', ['type'=>'danger', 'text'=> __("Inicio de sesión cancelado")]);
            return redirect('login');
        }
        $socialUser = Socialite::driver($driver)->user();
        $user = null;
        $success = true;
        $email = $socialUser->email;
        $check = User::whereEmail($email)->first();
        if($check){
            $user = $check;
        }
        else{
            \DB::beginTransaction();
            try{
                $user = User::create([
                    'name' => $socialUser->name,
                    'email' => $email
                ]);
                UserSocialAccount::create([
                   'user_id' => $user->id,
                    'provider' => $driver,
                    'provider_uid' => $socialUser->id
                ]);
                Student::create([
                    'user_id' => $user->id
                ]);

            } catch (\Exception $exception){ //si llegamos aqui es que ha habido un problema (excepcion)
                $success = $exception->getMessage(); //guardamos el mensaje de la excepcion
                \DB::rollBack(); //hacemos un rollback en la BD para deshacer lo guardado
            }
        }
        if($success === true){
            \DB::commit();
            auth()->loginUsingId($user->id);
            return redirect(route('home'));
        }
        session()->flash('message', ['type' => 'danger', 'text'=>$success]);
        return redirect('login');
    }
}
