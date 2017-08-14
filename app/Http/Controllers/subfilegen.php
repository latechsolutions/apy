<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\subscribermaster;
use App\subfiledetails;
use Carbon\Carbon;
use Auth;
use App\filelocations;

class subfilegen extends Controller
{
    public function index()
    {
      $existingfiles=subfiledetails::all()->unique('file_name');
      $errorrec=subscribermaster::where('status','UP')->get();
      return view('subfilegen',['existingfiles'=>$existingfiles,'errorrec'=>$errorrec]);
    }
  
  public function newgenerate()
  {
    $pendingrec=subscribermaster::where('status','AP')->get();
    if(count($pendingrec)>0)
    {
      $filelocation=filelocations::where('file_type','subregfile')->get();
      if(count($filelocation)!=1)
         return redirect('subfilegen')->with('message','Save File location not defined');
      $filelocation=$filelocation[0]['location'];
    $lineno=2;
    $out="";
    $recno=1;
    $fileseqno=(subfiledetails::where('file_gen_dt',Carbon::today()->toDateString())->count())+1;
    $filename="PGB_SUBFILE_".Carbon::today()->toDateString()."_".$fileseqno.".txt";
    
    foreach($pendingrec as $rec)
    {
  
      $out=$out.str_pad($lineno,6,"0",STR_PAD_LEFT).'^FD^'.str_pad($recno,6,"0",STR_PAD_LEFT)."^".$rec['pran_no']."^^".$rec['title']
            ."^".$rec['sub_name']."^".$rec['sub_fth_name']."^".$rec['nlao_reg_no']."^".$rec['nlcc_reg_no']."^".
             $rec['sub_gender']."^".Carbon::createFromFormat('Y-m-d',$rec['sub_dob'])->format('mdY')."^^".
               $rec['sub_addr']."^".$rec['sub_addr_dt_tw_ct']."^".$rec['sub_addr_st_ut'].
             "^".$rec['sub_addr_ct']."^".$rec['sub_addr_pin']."^^^^".$rec['sub_mob_no']."^^".$rec['sub_sms_flag']."^".$rec['sub_marital_st']
             ."^".$rec['sub_spou_name']."^^^".$rec['sub_ac_no']."^".$rec['sub_bank_name']."^".$rec['sub_br_name']."^^".
              $rec['sub_ifsc_cd']."^^".$rec['swavalamban_flag']."^".$rec['oth_sschemes']."^".$rec['pen_amt']."^".
              $rec['contr_amt']."^".$rec['si_dt']."^".Carbon::createFromFormat('Y-m-d',$rec['appl_dt'])->format('mdY').
                "^".$rec['appl_place']."^".$rec['it_payer']."^".$rec['pay_freq']."\r\n";
      $lineno++;
      $out=$out.str_pad($lineno,6,"0",STR_PAD_LEFT)."^ND^1^1^".$rec['nom_name']."^".
           Carbon::createFromFormat('Y-m-d',$rec['nom_dob'])->format('mdY')."^^".$rec['nom_rel'].
           "^".$rec['nom_maj_min']."^".$rec['guard_name']."\r\n";
      $lineno++; $recno++;
    }
    $out="000001^FH^PRAN^A^".Carbon::today()->format('mdY')."^".str_pad($fileseqno,3,"0",STR_PAD_LEFT)."^".str_pad(count($pendingrec),6,"0",STR_PAD_LEFT)."\r\n".$out;
    $bytes_written = file_put_contents($filelocation."/".$filename, $out);
     if($bytes_written==FALSE)
        return redirect('subfilegen')->with('message','Error Writing to file');
      \DB::beginTransaction();
    foreach($pendingrec as $rec)
    {
      $sub=subscribermaster::find($rec['id']);
      $sub->status='UP';
      $sub->save();
      subfiledetails::create(['pran_no'=>$rec->pran_no,'file_name'=>$filename,'file_gen_dt'=>Carbon::today()->toDateString(),
                             'file_gen_by'=>Auth::user()->username]);
    }
      
    \DB::commit();
  //  $response = response($out, 200, [
  //  'Content-Type' => 'application/text',
  //  'Content-Disposition' => 'attachment; filename="'.$filename.'"',
  //     ]);
    return response()->download($filelocation."/".$filename);
    }
    else
      return redirect('subfilegen')->with('message','No Pending Records');
  }
  
  public function regenerate(Request $request)
  {
    $filename=$request->get('rfname');
    
    $pranlist=subfiledetails::where('file_name',$filename)->get();
    if(count($pranlist)==0)
      return redirect('subfilegen')->with('message','Invalid File Name');
     $filelocation=filelocations::where('file_type','subregfile')->get();
      if(count($filelocation)!=1)
         return redirect('subfilegen')->with('message','Save File location not defined');
    
      $filelocation=$filelocation[0]['location'];
     if(file_exists($filelocation."/".$filename)==FALSE)
       return redirect('subfilegen')->with('message','File not found.Please contact administrator');
     return response()->download($filelocation."/".$filename);
    
  }
  
  public function removerejected(Request $request)
  {
    $rejectlist=(array)$request->get('rejectpran');
    if(count($rejectlist)==0)
      return redirect('subfilegen');
    \DB::beginTransaction();
    foreach($rejectlist as $pran)
    {
      subscribermaster::where('pran_no',$pran)->update(['status'=>'ER']);
    }
    \DB::commit();
    return redirect('subfilegen')->with('message','Removed Successfully');
  }
  
  public function uploadresponse(Request $request)
  {
     $filelocation=filelocations::where('file_type','subrespfile')->get();
      if(count($filelocation)!=1)
         return redirect('subfilegen')->with('message','Save File location not defined');
    $filelocation=$filelocation[0]['location'];
      $file = $request->file('respfile');
     $filename=$file->getClientOriginalName();
      $file->move($filelocation."/",$file->getClientOriginalName());
    $filepath=$filelocation."/".$file->getClientOriginalName();
    $fileptr=fopen($filepath,"r");
    $cnt=1;
      \DB::beginTransaction();
    while(($line=fgets($fileptr))!=FALSE)
    {
      
      if($cnt!=1)
      {
        $pran=explode("^",$line)[1];
        subscribermaster::where('pran_no',$pran)->update(['status'=>'AC']);
      }
      $cnt++;
    }
    \DB::commit();
    return redirect('subfilegen')->with('message','Response marked Successfully');
  }
}
