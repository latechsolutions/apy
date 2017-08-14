<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\subscribermaster;
use App\volexitdetails;
use Session;
use Carbon\Carbon;


class volexit extends Controller
{
    public function index()
    {
      $brcode=Session::get('brcode');
      $pranlist=subscribermaster::where('status','AC')->where('brcode',$brcode)->paginate(3);
     return view('volexit',['pranlist'=>$pranlist]); 
    }
  
  public function getclosedetails($pranno)
  {
    $brcode=Session::get('brcode');
    $prandetails=subscribermaster::where('pran_no',$pranno)->where('status','AC')->where('brcode',$brcode)->first();
    if(count($prandetails)==0)
      return redirect('volexit')->with('message','Invalid Pranno');
    return view('volexitgetdetails',['pranno'=>$pranno]);
  }
  public function close(Request $request)
  {
    $rules=['ifsccd'=>'required|regex:/^[A-Z][A-Z0-9]{10}$/','acno'=>'required|regex:/^[5][0-9]{3}[0][1][0-9]{9}$/',
            'mobno'=>'required|regex:/^[7-9][0-9]{9}$/','emailid'=>'required|email|max:255'];
    $errormsg=['ifscd.*'=>'IFSC Code is mandatory and should be 11 characters',
               'acno.*'=>'CBS A/c No is mandatory and should be 15digits',
               'mobno.*'=>'Mobile No. is mandatory and should be a valid one',
               'emailid.*'=>'Email id is mandatory'];
    $this->validate($request,$rules,$errormsg);
        $brcode=Session::get('brcode');
    $pranno=$request->get('pranno');
    $prandetails=subscribermaster::where('pran_no',$pranno)->where('status','AC')->where('brcode',$brcode)->first();
    if(count($prandetails)==0)
      return back()->withInput()->withErrors(['errormsg'=>'Invalid Pranno']);
    $ifsccd=$request->get('ifsccd');
    $acno=$request->get('acno');
    $mobno=$request->get('mobno');
    $emailid=$request->get('emailid');
    $todaydt=Carbon::today()->toDateString();
    $user=Auth::user()->username;
    \DB::beginTransaction();
    $prandetails->status='CL';
    $prandetails->save();
    volexitdetails::create(['pran_no'=>$pranno,'ifsc_cd'=>$ifsccd,'ac_no'=>$acno,'mob_no'=>$mobno,'email_id'=>$emailid,
                           'closure_ent_by'=>$user,'closure_ent_dt'=>$todaydt]);
    \DB::commit();
    return redirect('volexit')->with('message','Pranno'.$pranno.' marked for closure sucessfully');
  }
}
