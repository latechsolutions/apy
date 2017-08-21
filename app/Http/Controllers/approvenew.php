<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session;
use App\subscribermaster;
use Auth;
use Carbon\Carbon;
use App\premiumhistory;

class approvenew extends Controller
{
    public function index()
    {
      $userbr=Session::get('brcode');
      $userid=Auth::user()->username;
      $pendingrec=subscribermaster::where('status','EN')
                                  ->where('brcode',$userbr)
                                  ->where('ent_by','!=',$userid)
                                  ->get();
      return view('approvenew')->with('pendingrec',$pendingrec);
    }
  
  public function approve($action,$pran)
  {
    if($action=="approve")
    {
     $userid=Auth::user()->username;
      $pendingrec=subscribermaster::where('pran_no',$pran)->where('status','EN')->first();
      $todaydt=Carbon::createFromFormat('Y-m-d',$pendingrec->appl_dt)->startOfDay();
      $payfreq=$pendingrec->pay_freq;
      if($payfreq=='M')
      $fromdt=$todaydt->modify('first day of this month')->toDateString();
      if($payfreq=='Q')
        $fromdt=$todaydt->subMonths(($todaydt->month%3)==0?3:($todaydt->month%3)==2?2:0)
                        ->modify('first day of this month')->toDateString();
      if($payfreq=='H')
      {
        if($todaydt->month==3 || $todaydt->month==9)
          $fromdt=$todaydt->subMonths(6)->modify('first day of this month')->toDateString();
        elseif($todaydt->month==4 || $todaydt->month==10)
          $fromdt=$todaydt->modify('first day of this month')->toDateString();
        elseif($todaydt->month==2)
          $fromdt=$todaydt->subMonths(5)->modify('first day of this month')->toDateString();
        elseif($todaydt->month==1)
          $fromdt=$todaydt->subMonths(4)->modify('first day of this month')->toDateString();
        elseif($todaydt->month==12)
          $fromdt=$todaydt->subMonths(3)->modify('first day of this month')->toDateString();
        elseif($todaydt->month==11)
          $fromdt=$todaydt->subMonths(2)->modify('first day of this month')->toDateString();
        elseif($todaydt->month==8)
          $fromdt=$todaydt->subMonths(5)->modify('first day of this month')->toDateString();
        elseif($todaydt->month==7)
          $fromdt=$todaydt->subMonths(4)->modify('first day of this month')->toDateString();
        elseif($todaydt->month==6)
          $fromdt=$todaydt->subMonths(2)->modify('first day of this month')->toDateString();
        elseif($todaydt->month==5)
          $fromdt=$todaydt->subMonths(1)->modify('first day of this month')->toDateString();
        else{}
        
        
      }
      \DB::beginTransaction();
      $pendingrec->status='AP';
      $pendingrec->app_by=$userid;
      $pendingrec->app_dt_time=Carbon::now();
      $pendingrec->save();
      premiumhistory::create(['pran_no'=>$pran,'pen_amt'=>$pendingrec->pen_amt,'prem_amt'=>$pendingrec->contr_amt,
                              'pay_freq'=>$payfreq,'from_dt'=>$fromdt,
                             'to_dt'=>'9999-12-31','ent_dt'=>Carbon::today()->toDateString()]);
      \DB::commit();
      
      echo json_encode(['status'=>'success']);
                  
    }
    if($action=="reject")
    {
     $userid=Auth::user()->username;
      $pendingrec=subscribermaster::where('pran_no',$pran)
                                    ->where('status','EN')
                                    ->update(['status'=>'CA','app_by'=>$userid,'app_dt_time'=>Carbon::now()]); 
      echo json_encode(['status'=>'success']);
    }
  }
}
