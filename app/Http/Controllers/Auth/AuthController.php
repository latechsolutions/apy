<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Auth;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Session;

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
    protected $redirectTo = '/home';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'alpha|required|max:15|unique:users',
            'name' => 'required|alpha|max:255',
            'password' => 'required|min:6|confirmed',
            'user_level'=>'required|digits_between:1,100',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'name' => $data['name'],
            'password' => bcrypt($data['password']),
        ]);
    }
  
  	public function login(Request $request)
	{
	
		$client=new Client();
		$this->validate($request,['username'=>'required|numeric|digits:5','password'=>'required'],
										['username.*'=>'Username is mandatory and should be the rollno','password.*'=>'Password is mandatory']);
			$url='http://59.99.240.178:88/apyservice/apyservice.asp?op=ud&uid='.$request->get('username');
        $response=$client->get($url);
				     $d=json_decode($response->getBody(),true);
        
        if($d['status']=="error")
				{
					return redirect()->back()->withInput()->withErrors(['message'=>$d['errormsg']]);
        }
		
		
	   if(Auth::attempt(['username'=>$request->get('username'),'password'=>$request->get('password')]))
	     {
				 Session::put('brcode',$d['brcode']);
			 return redirect()->intended($this->redirectTo);
		 }
		 else
		 {
		    return redirect()->back()->withInput()->withErrors(['message'=>'Invalid Username or Password']);
		 }
	}
}
