<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session;
use Auth;

class changepassword extends Controller
{
   public function index()
	{
	   return view('auth/changepass');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function changepass(Request $request)
	{
		if($request->has('password') && $request->has('password_confirmation'))
		{
		 $pass=$request->get('password');
		 $confirmpass=$request->get('password_confirmation');
		 if($pass!=$confirmpass)
		   return view('auth/changepass')->withErrors(array('errormsg'=>'Password and confirm password do not match'));
		 if(strlen($pass)<8)
		   return view('auth/changepass')->withErrors(array('errormsg'=>'Password should be min 8 characters length'));
		 
		 $userlogin=Auth::user();
		 
		    $userlogin->password=bcrypt($pass);
			$userlogin->save();
			return view('auth/changepass',array('succmsg'=>'Password changed successfully'));
		}
		else
		return view('auth/changepass')->withErrors(array('errormsg'=>'Please enter both password and confirm password'));
	}

}
