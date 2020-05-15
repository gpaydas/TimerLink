<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('oturumukapat');
    }

    public function giris_form()
    {
        return view('admin.login');
    }
    
    public function oturumukapat() 
    {  
        auth()->logout();
        request()->session()->flush();
        request()->session()->regenerate();
        return redirect()->route('anasayfa');
    }
    
    public function giris()
    {
 
        $customMessages = [
            'username.required' => 'İsim Alanı Boş Geçilemez.',
            'password.required' => 'Şifre Alanı Boş Geçilemez.'
        ];

        $this->validate(request(),
            [
                'username' => 'required',
                'password' => 'required'
            ],$customMessages
        );
        if (auth()->attempt(
            ['name' => request('username'), 'password' => request('password')]
            , request()->has('benihatirla')
        )) {

            request()->session()->regenerate();
            return redirect()->intended('/home');
        } else {
            $errors = ['email' => 'Hatalı Giriş'];
            return back()->withErrors($errors); /*Geldiğimiz Sayfaya Geri Döner */
        }
    }

}
