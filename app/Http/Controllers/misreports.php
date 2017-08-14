<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\subscribermaster;
use App\premiumdetails;
use App\premiumhistory;
use App\contributiondetails;
use App\subfiledetails;
use App\cbsfiledetails;
use modificationdetails;
use Carbon\Carbon;
use Auth;
use Session;

class misreports extends Controller
{
      public function index($action)
    {
      $brcd=Session::get('brcode');
      if($action=="penupdw")
      {
        return view('misreports',['action'=>$action]);
      }
       if($action=="freqmod")
      {
        return view('misreports',['action'=>$action]);
      }
      echo "Unauthorized usage";
      return;
    }
}
