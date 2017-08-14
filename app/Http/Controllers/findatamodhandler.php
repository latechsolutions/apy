<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\subscribermaster;
use App\premiumdetails;
use Carbon\Carbon;
use Session;
use App\modificationdetails;
use Auth;
use App\premiumhistory;

class findatamodhandler extends Controller
{
    public function index($action)
    {
      if($action=="penupdw")
      {
        return view('findatamod',['action'=>$action]);
      }
       if($action=="freqmod")
      {
        return view('findatamod',['action'=>$action]);
      }
      echo "Unauthorized usage";
      return;
    }
  
  public function penupdw(Request $request)
  {
    $rules=['pranno'=>'required|integer',
            'penamt'=>'required|in:1000,2000,3000,4000,5000',
            'contramt'=>'required|integer|min:1'];
    $messages=['pranno.*'=>'Pran No is mandatory and should be a number',
              'penamt.*'=>'Please select the pension amount',
              'contramt.*'=>'Contribution amount is mandatory and should be a number'];
    $this->validate($request,$rules,$messages);
    $brcode=Session::get('brcode');
    $pranno=$request->get('pranno');
    $newpenamt=$request->get('penamt');
    $contramt=$request->get('contramt');
    $todaydt=Carbon::today();
    $prandetails=subscribermaster::where('pran_no',$pranno)->where('status','AC')->where('brcode',$brcode)->first();
    if(count($prandetails)==0)
      return back()->withInput()->withErrors(['errormsg'=>'Invalid Pran Number']);
    if($prandetails->pen_amt==$newpenamt)
      return back()->withInput()->withErrors(['errormsg'=>'New Pension and Old Pension amount cannot be same']);
    $pendingprem=premiumdetails::where('pran_no',$pranno)->where('paid_status','N')->get();
    if(count($pendingprem)>0)
      return back()->withInput()->withErrors(['errormsg'=>'Pending Premium Exists.']);
    $pendingmod=modificationdetails::where('pran_no',$pranno)->where('response_uploaded','N')->get();
    if(count($pendingmod)>0)
      return back()->withInput()->withErrors(['errormsg'=>'Pending Modification Exists.']);
    if($todaydt->month!=4)
      return back()->withInput()->withErrors(['errormsg'=>'Modification can be done only during the month of april']);
    $completedmod=modificationdetails::where('pran_no',$pranno)->where('mod_type','PENM')->orderBy('mod_dt','DESC')->first();
    if(count($completedmod)>0)
      if(Carbon::createFromFormat('Y-m-d',$completedmod->mod_dt)->year==$todaydt->year)
        return back()->withInput()->withErrors(['errormsg'=>'Pension amount can be modified only one time for a year']);
    $oldvalue=json_encode($prandetails);
    $premiumhistory=premiumhistory::where('pran_no',$pranno)->where('to_dt','9999-12-31')->first();
    \DB::beginTransaction();
      $prandetails->pen_amt=$newpenamt;
      $prandetails->contr_amt=$contramt;
      $prandetails->save();
      $newvalue=json_encode($prandetails);
      modificationdetails::create(['pran_no'=>$pranno,'mod_type'=>'PENM','old_value'=>$oldvalue,'new_value'=>$newvalue,
                                   'mod_by'=>Auth::user()->username,'mod_dt'=>$todaydt->toDateString(),'response_uploaded'=>'N']);
      $premiumhistory->to_dt=$todaydt->copy()->subYear()->modify('last day of this month')->toDateString();
      $premiumhistory->save();
      premiumhistory::create(['pran_no'=>$pranno,'pen_amt'=>$newpenamt,'prem_amt'=>$contramt,'pay_freq'=>$prandetails->pay_freq,
                             'from_dt'=>$todaydt->copy()->modify('first day of this month')->toDateString(),
                             'to_dt'=>'9999-12-31','ent_dt'=>$todaydt->toDateString()]);
    \DB::commit();
      return redirect('findatamod/penupdw')->with('message','Pension amount changed for Pran No.'.$pranno.'successfully.');
  }
  
  
  public function freqmod(Request $request)
  {
     $rules=['pranno'=>'required|integer',
             'payfreq'=>'required|in:M,Q,H',
            'contramt'=>'required|integer|min:1'];
    $messages=['pranno.*'=>'Pran No is mandatory and should be a number',
              'payfreq.*'=>'Please select the payment frequency',
              'contramt.*'=>'Contribution amount is mandatory and should be a number'];
    $this->validate($request,$rules,$messages);
     $brcode=Session::get('brcode');
    $pranno=$request->get('pranno');
    $newpayfreq=$request->get('payfreq');
    $contramt=$request->get('contramt');
    $todaydt=Carbon::today();
    $prandetails=subscribermaster::where('pran_no',$pranno)->where('status','AC')->where('brcode',$brcode)->first();
    if(count($prandetails)==0)
      return back()->withInput()->withErrors(['errormsg'=>'Invalid Pran Number']);
    $oldpayfreq=$prandetails->pay_freq;
    if($oldpayfreq==$newpayfreq)
      return back()->withInput()->withErrors(['errormsg'=>'New Frequency and Old Frequency cannot be same']);
    $pendingmod=modificationdetails::where('pran_no',$pranno)->where('response_uploaded','N')->get();
    if(count($pendingmod)>0)
      return back()->withInput()->withErrors(['errormsg'=>'Pending Modification Exists.']);
    $pendingprem=premiumdetails::where('pran_no',$pranno)->where('paid_status','N')->get();
    if(count($pendingprem)>0)
      return back()->withInput()->withErrors(['errormsg'=>'Pending Premium Exists.']);
    $maxpaidyr=premiumdetails::where('pran_no',$pranno)->where('paid_status','Y')->max('premium_yr');
    $maxpaidmth=premiumdetails::where('pran_no',$pranno)->where('paid_status','Y')->where('premium_yr',$maxpaidyr)->max('premium_mth');
    $premiumhistory=premiumhistory::where('pran_no',$pranno)->where('to_dt','9999-12-31')->first();
    if($oldpayfreq=='M' && $newpayfreq=='Q')
     if($maxpaidmth!=12 && $maxpaidmth!=3 && $maxpaidmth!=6 && $maxpaidmth!=9)
       return back()->withInput()->withErrors(['errormsg'=>'Frequency cannot be changed to Quarterly when last paid month is'.$maxpaidmth]);
    if ($oldpayfreq=='M' && $newpayfreq=='H')
     if($maxpaidmth!=3 &&  $maxpaidmth!=9)
        return back()->withInput()->withErrors(['errormsg'=>'Frequency cannot be changed to Half-yearly when last paid month is'.$maxpaidmth]);
    if($oldpayfreq=='Q' && $newpayfreq=='M')
     if($maxpaidmth!=12 && $maxpaidmth!=3 && $maxpaidmth!=6 && $maxpaidmth!=9)
       return back()->withInput()->withErrors(['errormsg'=>'Frequency cannot be changed to Monthly when last paid month is'.$maxpaidmth]);
    if($oldpayfreq=='Q' && $newpayfreq=='H')
     if($maxpaidmth!=3 && $maxpaidmth!=9)
       return back()->withInput()->withErrors(['errormsg'=>'Frequency cannot be changed to Half-yearly when last paid month is'.$maxpaidmth]);
    if($oldpayfreq=='H' && $newpayfreq=='M')
     if($maxpaidmth!=3 && $maxpaidmth!=9)
       return back()->withInput()->withErrors(['errormsg'=>'Frequency cannot be changed to Monthly when last paid month is'.$maxpaidmth]);
    if($oldpayfreq=='H' && $newpayfreq=='Q')
     if($maxpaidmth!=3 && $maxpaidmth!=9)
       return back()->withInput()->withErrors(['errormsg'=>'Frequency cannot be changed to Quarterly when last paid month is'.$maxpaidmth]);
    
    \DB::beginTransaction();
      $prandetails->pay_freq=$newpayfreq;
      $prandetails->contr_amt=$contramt;
      $prandetails->save();
      $newvalue=json_encode($prandetails);
      modificationdetails::create(['pran_no'=>$pranno,'mod_type'=>'FREQM','old_value'=>$oldvalue,'new_value'=>$newvalue,
                                   'mod_by'=>Auth::user()->username,'mod_dt'=>$todaydt->toDateString(),'response_uploaded'=>'N']);
      $premiumhistory->to_dt=Carbon::createFromDate($maxpaidyr,$maxpaidmth,1)->modify('last day of this month')->toDateString();
      $premiumhistory->save();
      premiumhistory::create(['pran_no'=>$pranno,'pen_amt'=>$prandetails->pen_amt,'prem_amt'=>$contramt,'pay_freq'=>$newpayfreq,
                             'from_dt'=>Carbon::createFromDate($maxpaidyr,$maxpaidmth,1)->addMonth()->modify('first day of this month')->toDateString(),
                             'to_dt'=>'9999-12-31','ent_dt'=>$todaydt->toDateString()]);     
    \DB::commit();
    return redirect('findatamod/freqmod')->with('message','Payment frequency changed for Pran No.'.$pranno.'successfully.');
  }
}
