<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */


    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    protected $oauth_user;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware($this->guestMiddleware(), ['except' => 'logout']);
        $this->oauth_user = session('wechat.oauth_user');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    /*
    protected function validator(array $data)
    {
        return Validator::make($data, [
            //'name' => 'required|max:255',
            //'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }
    */

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */

    /*
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
*/



    public function register(){
        $name = $this->oauth_user->name;
        $avatar = $this->oauth_user->avatar;
        //return view('user.register',compact('name','avatar'));
    }

    public function create(){

        User::create([
            'open_id' => $this->oauth_user->id,
            'name' => $this->oauth_user->name,
            'avatar' => $this->oauth_user->avatar,
            'age' => 30,
        ]);
    }


    public function nologin(){

        if (User::where('open_id',$this->oauth_user->id)->count() == 0 ){
            return redirect('register');
        }
        else{
            $user = User::where('open_id',$this->oauth_user->id)->firstOrFail();

            if ($user->name != $this->oauth_user->name  ){
                $user->name = $this->oauth_user->name;
                $user->save();
            }

            Auth::login($user);
            return redirect()->intended('/topic');
        }

    }

    public function login(){
        if(User::where('open_id',$this->oauth_user->id)->count() == 0 ){
            $this->create();
        }
        $user = User::where('open_id',$this->oauth_user->id)->firstOrFail();

        if ($user->name != $this->oauth_user->name  ){
            $user->name = $this->oauth_user->name;
            $user->save();
        }

        Auth::login($user);
        return redirect()->intended('/home');
    }
}
