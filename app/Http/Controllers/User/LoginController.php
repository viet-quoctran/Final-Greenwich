<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(){
        return view('admin.login');
    }
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }
    public function callbackGoogle(){
        try{
            $google_user = Socialite::driver('google')->user();
            $user = User::where('google_id',$google_user->getId())->first();

            if(!$user){
                $new_user = User::create([
                    'name'=>$google_user->getName(),
                    'email'=>$google_user->getEmail(),
                    'google_id'=>$google_user->getId(),

                ]);
                Auth::login($new_user);
                return redirect()->intended('welcome');
            }
            else{
                Auth::login($user);
                return redirect()->intended('welcome');
            }
        } catch(\Throwable $e){
            dd($e);
        }
    }
}
