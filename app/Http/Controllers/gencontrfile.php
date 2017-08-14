<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\premiumdetails;
use App\subscribermaster;
use App;
use Carbon\Carbon;
use App\filelocations;
use App\brmaster;
use Auth;

class gencontrfile extends Controller
{
     public function index()
    {
         $existingfiles=premiumdetails::whereNotNull('contr_file_name')->select('contr_file_name')->get()->unique('contr_file_name');
      return view ('contrfilegen',['existingfiles'=>$existingfiles]);
    }
  
  public function newgenerate()
  {
    $pendingrec=premiumdetails::where('paid_status','Y')->whereNull('contr_file_name')->get();
    if(count($pendingrec)>0)
    {
      $filelocation=filelocations::where('file_type','contrfile')->get();
      if(count($filelocation)!=1)
         return redirect('gencontrfile')->with('message','Save File location not defined');
    $filelocation=$filelocation[0]['location'];
    $nlooregno=brmaster::first()->nloo_reg_no;
    $lineno=3;
    $out="";
    $recno=1;
    $fileseqno=(premiumdetails::where('contr_file_dt',Carbon::today()->toDateString())->count())+1;
    $filename="CONTR-".Carbon::today()->toDateString()."-".$fileseqno.".txt";
    $nlcclist=\DB::select("select a.nlcc_reg_no,count(*) as cnt,sum(b.premium_amt) as totcontramt,sum(b.penalty_amt) as totpenamt 
                           from subscribermaster a,premiumdetails b
                           where a.pran_no=b.pran_no and b.paid_status='Y' and b.contr_file_name is null
                           group by a.nlcc_reg_no");
      $nlccno=1;
      $totalpenaltyamt=0;
      $totalpremiumamt=0;
      $totalreccnt=0;

    foreach($nlcclist as $nlcc)
    {
      $out=$out.str_pad($lineno,9,"0",STR_PAD_LEFT)."^DH^000000001^".str_pad($nlccno,9,"0",STR_PAD_LEFT)."^".$nlcc->nlcc_reg_no."^".
            str_pad($nlcc->cnt,9,"0",STR_PAD_LEFT)."^".number_format((float)$nlcc->totpenamt,2,'.','')."^".number_format((float)$nlcc->totcontramt,2,'.','')."^^\r\n";
      $indivlist=\DB::select("select b.premium_mth,b.premium_yr,b.premium_amt,b.penalty_amt, b.pran_no,a.pay_freq
                              from subscribermaster a,premiumdetails b
                              where a.pran_no=b.pran_no and b.paid_status='Y' and b.contr_file_name is null 
                              and a.nlcc_reg_no=?",[$nlcc->nlcc_reg_no]);
      $subsno=1;
      $lineno++;
      foreach($indivlist as $indivrec)
      {
        if($indivrec->pay_freq=='Q'||$indivrec->pay_freq=='H')
          if($indivrec->premium_mth >=1 && $indivrec->premium_mth <=3)
            $contriyear=($indivrec->premium_yr-1)."-".$indivrec->premium_yr;
          else
            $contriyear=$indivrec->premium_yr."-".($indivrec->premium_yr+1);
        else
          $contriyear=$indivrec->premium_yr;
		  if($indivrec->pay_freq=='Q')
		  {
		     if($indivrec->premium_mth>=4 && $indivrec->premium_mth<=6)
			   $contrifor='Q1';
			 if($indivrec->premium_mth>=7 && $indivrec->premium_mth<=9)
			   $contrifor='Q2';
			if($indivrec->premium_mth>=10 && $indivrec->premium_mth<=12)
			   $contrifor='Q3';
			if($indivrec->premium_mth>=1 && $indivrec->premium_mth<=3)
			   $contrifor='Q4';			   
		  }
		  if($indivrec->pay_freq=='H')
		  {
		   if($indivrec->premium_mth>=4 && $indivrec->premium_mth<=9)
			   $contrifor='H1';
			 if($indivrec->premium_mth>=10 && $indivrec->premium_mth<=3)
			   $contrifor='H2';
		  }
		  if($indivrec->pay_freq=='M')
		    $contrifor=$indivrec->premium_mth;
        $out=$out.str_pad($lineno,9,"0",STR_PAD_LEFT)."^SD^000000001^".str_pad($nlccno,9,"0",STR_PAD_LEFT)."^".str_pad($subsno,9,"0",STR_PAD_LEFT).
             "^".$indivrec->pran_no."^".number_format((float)$indivrec->penalty_amt,2,'.','')."^".number_format((float)$indivrec->premium_amt,2,'.','').
			 "^^".number_format((float)($indivrec->penalty_amt+$indivrec->premium_amt),2,'.','').
             "^".($indivrec->pay_freq=='M'?'C':$indivrec->pay_freq)."^".str_pad($contrifor,2,"0",STR_PAD_LEFT)."^".
             $contriyear."^^^^\r\n";
        $subsno++;
		$lineno++;
      }
        $nlccno++;
		
      $totalpenaltyamt=$totalpenaltyamt+$nlcc->totpenamt;
      $totalpremiumamt=$totalpremiumamt+$nlcc->totcontramt;
      $totalreccnt=$totalreccnt+$nlcc->cnt;
    }
      $nlccno=$nlccno-1;
    $grandtotal=$totalpremiumamt+$totalpenaltyamt;
    $out="000000002^BH^000000001^R^".$nlooregno."^".Carbon::today()->format('dmY')."^".$nlooregno.Carbon::today()->format('Ymd').str_pad($fileseqno,5,"0",STR_PAD_LEFT).
         "^^".str_pad($nlccno,9,"0",STR_PAD_LEFT)."^".str_pad($totalreccnt,9,"0",STR_PAD_LEFT)."^".number_format((float)$totalpenaltyamt,2,'.','').
		 "^".number_format((float)$totalpremiumamt,2,'.','')."^^".number_format((float)$grandtotal,2,'.','')."^"."\r\n".$out;
    $out="000000001^FH^A^".$nlooregno."^000000001^^^^^^^"."\r\n".$out;
      
    \DB::beginTransaction();
    $bytes_written = file_put_contents($filelocation."/".$filename, $out);
     if($bytes_written==FALSE)
        return redirect('gencontrfile')->with('message','Error Writing to file');

    foreach($pendingrec as $rec)
    {
      $prem=premiumdetails::find($rec['id']);
      $prem->contr_file_name=$filename;
      $prem->contr_file_dt=Carbon::today()->toDateString();
      $prem->contr_file_gen_by=Auth::user()->username;
      $prem->save();
    }
      
    \DB::commit();
  //  $response = response($out, 200, [
  //  'Content-Type' => 'application/text',
  //  'Content-Disposition' => 'attachment; filename="'.$filename.'"',
  //     ]);
    return response()->download($filelocation."/".$filename);
    }
    else
      return redirect('gencontrfile')->with('message','No Pending Records');
  }
	
	 public function regenerate(Request $request)
  {
    $filename=$request->get('rfname');
    
    $filelist=premiumdetails::where('contr_file_name',$filename)->get();
    if(count($filelist)==0)
      return redirect('gencontrfile')->with('message','Invalid File Name');
     $filelocation=filelocations::where('file_type','contrfile')->get();
      if(count($filelocation)!=1)
         return redirect('gencontrfile')->with('message','Save File location not defined');
    
      $filelocation=$filelocation[0]['location'];
     if(file_exists($filelocation."/".$filename)==FALSE)
       return redirect('gencontrfile')->with('message','File not found.Please contact administrator');
     return response()->download($filelocation."/".$filename);
    
  }
	
}
