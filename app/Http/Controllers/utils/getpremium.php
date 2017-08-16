<?php

namespace App\Http\Controllers\utils;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\contributiondetails;
use App\subscribermaster;
use Carbon\Carbon;

class getpremium extends Controller
{
    public function index ($param1,$param2,$param3)
    {
      $contributionrec=contributiondetails::where('age',$param1)->where('pension_amt',$param2)->where('freq',$param3)->get();
      if(count($contributionrec)==1)
        return json_encode(["status"=>"success","premium"=>$contributionrec[0]->premium_amt]);
      else
        return json_encode(["status"=>"error"]);
    }
  
  public function penupdw($newpenamt,$pran)
  {
    $prandetails=subscribermaster::where('pran_no',$pran)->where('status','AC')->first();
    if(count($prandetails)==0)
      return json_encode(["status"=>"error"]);
    $age=Carbon::createFromFormat('Y-m-d',$prandetails->appl_dt)
                    ->diffInYears(Carbon::createFromFormat('Y-m-d',$prandetails->sub_dob));
    $contributionrec=contributiondetails::where('pension_amt',$newpenamt)->where('freq',$prandetails->pay_freq)
                                          ->where('age',$age)->get();
     if(count($contributionrec)==1)
        return json_encode(["status"=>"success","premium"=>$contributionrec[0]->premium_amt]);
      else
        return json_encode(["status"=>"error"]);
  }
    public function freqmod($newpayfreq,$pran)
  {
    $prandetails=subscribermaster::where('pran_no',$pran)->where('status','AC')->first();
    if(count($prandetails)==0)
      return json_encode(["status"=>"error"]);
    $age=Carbon::createFromFormat('Y-m-d',$prandetails->appl_dt)
                    ->diffInYears(Carbon::createFromFormat('Y-m-d',$prandetails->sub_dob));
    $contributionrec=contributiondetails::where('pension_amt',$prandetails->pen_amt)->where('freq',$newpayfreq)
                                          ->where('age',$age)->get();
     if(count($contributionrec)==1)
        return json_encode(["status"=>"success","premium"=>$contributionrec[0]->premium_amt]);
      else
        return json_encode(["status"=>"error"]);
  }
}