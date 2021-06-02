<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider($provider = 'google')
    {
        if(!config("services.$provider")) abort('404');
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider = 'google')
    {
        if(!config("services.$provider")) abort('404');

        $user = Socialite::driver($provider)->user();
        // dd((User::select()->where('email', '=', $user->email)->first()));
        if(User::select()->where('email', '=', $user->email)->first()){
            return $this->loginRedirect(User::select()->where('email', '=', $user->email)->first());
        } else {
            $user = User::create([
                'name' => $user->name,
                'nickname' => Str::of($user->name)->explode(' ')[0].'-'.Str::random(5),
                'email' => $user->email,
                'mailable' => false,
                'password' => bcrypt(Str::random(10)),
            ]);

            return $this->loginRedirect($user);
        }
    }

    private function loginRedirect($user)
    {
        Auth::login($user);
        return redirect()->to('/perfil/'.$user->nickname);
    }
}
