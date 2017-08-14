<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\subscribermaster;
use App\premiumdetails;
use Carbon\Carbon;
use App\jobstatus;

class calculatepremium extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    protected $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user=$user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
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
        $appldt=Carbon::createFromFormat('Y-m-d',$acpran->appl_dt);
        $pranno=$acpran->pran_no;
        $premamt=$acpran->contr_amt;
        $payfreq=$acpran->pay_freq;
        $startdt=$appldt->copy()->modify('first day of this month')->startOfDay();
        $enddt=$todaydt->copy()->modify('first day of this month')->startOfDay();
        
        while($startdt->lte($enddt))
        {
          $penaltyamt=0;
   
          $premiumdet=premiumdetails::where('pran_no',$pranno)
                                    ->where('premium_mth',$startdt->month)
                                    ->where('premium_yr',$startdt->year)
                                    ->get();
          
          if(count($premiumdet)==1)
          {
            if($premiumdet[0]['paid_status']=='N')
            {
              //calculate penalty in the following if
            if($startdt->lt($enddt))
            {
              $penaltyamt=$this->getpenaltyamt($premamt,$startdt,$enddt,$payfreq);
               premiumdetails::where('pran_no',$pranno)
                                    ->where('premium_mth',$startdt->month)
                                    ->where('premium_yr',$startdt->year)
                                    ->update(['penalty_amt'=>$penaltyamt]); 
            }
            }
          }
          if(count($premiumdet)==0)
          {
            
            if($startdt->lt($enddt))
            {
              $penaltyamt=$this->getpenaltyamt($premamt,$startdt,$enddt,$payfreq);
              premiumdetails::create(['run_dt'=>$todaydt,'premium_mth'=>$startdt->month,'premium_yr'=>$startdt->year,
                                     'premium_amt'=>$premamt,'penalty_amt'=>$penaltyamt,'paid_status'=>'N','pran_no'=>$pranno,
                                     'prem_ded_by'=>$this->user]);
            }
            if($startdt->eq($enddt))
            {
              
              premiumdetails::create(['run_dt'=>$todaydt,'premium_mth'=>$startdt->month,'premium_yr'=>$startdt->year,
                                     'premium_amt'=>$premamt,'penalty_amt'=>$penaltyamt,'paid_status'=>'N','pran_no'=>$pranno,
                                     'prem_ded_by'=>$this->user]); 
            }
          }
          if($payfreq=='M')
            $startdt->addMonths(1);
          if($payfreq=='Q')
            $startdt->addMonths(3);
          if($payfreq=='H')
            $startdt->addMonths(6);
     
        }
     $i++;
      }
      $job->status='completed';$job->comp_percent="100%";
      $job->save();
    }
}
