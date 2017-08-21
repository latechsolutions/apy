<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\Jobs\calculatepremium;
use Carbon\Carbon;
use App\subscribermaster;
use App\premiumdetails;
use App\jobstatus;
use App\premiumhistory;

class dedpremium extends Controller
{
    public function index()
    {
      return view('dedpremium');
    }
  

  public function calculatepremium()
  {
     $user=Auth::user()->username;
   //$this-> handle();
    $jobid=$this->dispatch(new calculatepremium($user));
    return json_encode(['jobid'=>$jobid]);
  }
  
  public function status($jobid)
  {
		
    $jobstatus=jobstatus::where('job_id',$jobid)->get();
    return json_encode(['comppercent'=>$jobstatus[0]['comp_percent']]);
		
  }
  
  public function getjobid()
  {
    $jobstatus=jobstatus::where('status','running')->get();
    if(count($jobstatus)>0)
      return json_encode(['status'=>'running','jobid'=>$jobstatus[0]['job_id']]);
    else
      return json_encode(['status'=>'NA']);
  }
  
  
  
	
	private function getpenaltyamt($premamt,$startdt,$enddt,$payfreq)
   {
   	$penaltyamt=0;
   	$penaltyamt=floor($premamt/100)*1+($premamt%100==0?0:1);
   	$mthsidff=$enddt->diffInMonths($startdt);
   	if($payfreq=='M')
   	$penaltyamt=$penaltyamt*$mthsidff;
   	if($payfreq=='Q')
   	$penaltyamt=$penaltyamt*(floor($mthsidff/3)+($mthsidff%3==0?0:1));
   	if($payfreq=='H')
   	$penaltyamt=$penaltyamt*(floor($mthsidff/6)+($mthsidff%6==0?0:1));
   	return $penaltyamt;
   }
   
   public function handle()
   {
   	$jobid=$this->job->getJobId();
   	$job=jobstatus::create(['job_id'=>$jobid,'job_type'=>'calcprem','status'=>'running','comp_percent'=>'0%']);
   	$todaydt=Carbon::today();
   	$acpranlist=subscribermaster::where('status','AC')->get();
   	$totalcnt=count($acpranlist);
   	$i=1;
   	foreach($acpranlist as $acpran)
   	{
			
  $job->comp_percent=($i/$totalcnt)*100;
  $job->save();
 $appldt=Carbon::createFromFormat('Y-m-d',$acpran->appl_dt)->startOfDay();
 $todaydt=Carbon::today()->startOfDay();
 $pranno=$acpran->pran_no;
 $startdt=$appldt->copy();
 while($startdt->lte($todaydt))
 {
 	$premiumrec=premiumhistory::where('pran_no',$pranno)
 	->whereRaw('date(\''.$startdt->copy()->toDateString().'\') between from_dt and to_dt')->first();
 	
 	if(count($premiumrec)==1)
 	{
    $fromdt=Carbon::createFromFormat('Y-m-d',$premiumrec->from_dt)->startOfDay();
    $todt=Carbon::createFromFormat('Y-m-d',$premiumrec->to_dt)->startOfDay();
    if($todaydt->between($fromdt,$todt))
    $enddt=$todaydt->copy()->modify('last day of this month');
    else
    $enddt=$todt->copy();
    $payfreq=$premiumrec->pay_freq;
    $premamt=$premiumrec->prem_amt;
		$startdt=$fromdt->copy();
    while($startdt->lte($enddt))
    {
    	$penaltyamt=0;
    	if($payfreq=='M')
    	{
  $premmth=$startdt->month;
  $premyr=$startdt->year;
    	}
    	if($payfreq=='Q')
    	{
  $premmth=$startdt->copy()->addMonths(2)->month;
  $premyr=$startdt->copy()->addMonths(2)->year;
    	}
    	if($payfreq=='H')
    	{
  $premmth=$startdt->copy()->addMonths(5)->month;
  $premyr=$startdt->copy()->addMonths(5)->year;
    	}
    	$premiumdet=premiumdetails::where('pran_no',$pranno)
    	->where('premium_mth',$premmth)
    	->where('premium_yr',$premyr)
    	->get();
      if($startdt->copy()->modify('last day of this month')->lt($todaydt) && 
  	!($todaydt->between($appldt->copy()->modify('first day of this month'),$appldt->copy()->modify('last day of this month'))))
          {
     $penaltyamt=$this->getpenaltyamt($premamt,$startdt,$todaydt->copy()->modify('first day of this month'),
     $payfreq);
          }
    	if(count($premiumdet)==1)
    	{
  if($premiumdet[0]['paid_status']=='N')
  {
    premiumdetails::where('pran_no',$pranno)
     ->where('premium_mth',$premmth)
     ->where('premium_yr',$premyr)
     ->update(['penalty_amt'=>$penaltyamt]); 
  	
  }
    	}
              if(count($premiumdet)==0)
              {
                  premiumdetails::create(['run_dt'=>$todaydt,'premium_mth'=>$premmth,'premium_yr'=>$premyr,
    'premium_amt'=>$premamt,'penalty_amt'=>$penaltyamt,'paid_status'=>'N','pran_no'=>$pranno,
    'prem_ded_by'=>$this->user]);

              }
     if($payfreq=='M')
 $startdt->addMonths(1);
 if($payfreq=='Q')
 $startdt->addMonths(3);
 if($payfreq=='H')
 $startdt->addMonths(6); 
    }
 	}
 }
      $i++;
   	}
   $job->status='completed';$job->comp_percent="100%";
   $job->save();
	}

  
}
