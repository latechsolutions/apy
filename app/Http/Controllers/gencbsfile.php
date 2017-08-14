<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\subscribermaster;
use App\premiumdetails;
use App\cbsfiledetails;
use App\filelocations;
use Carbon\Carbon;
use Auth;


class gencbsfile extends Controller
{
    public function index()
    {
         $existingfiles=cbsfiledetails::whereNotNull('cbs_file_name')
                           ->orderBy('cbs_file_gen_dt','desc')->get()->unique('cbs_file_name');
      return view ('cbsfilegen',['existingfiles'=>$existingfiles]);
    }
  public function newgenerate()
  {
     $filelocation=filelocations::where('file_type','cbsfile')->get();
      if(count($filelocation)!=1)
         return redirect('gencbsfile')->with('message','Save File location not defined');
      $filelocation=$filelocation[0]['location'];
    $response=cbsfiledetails::where('response_loaded','N')->count();
    if($response>0)
      return redirect('gencbsfile')->with('message','Response Files not loaded for earlier files');
    $filedt=Carbon::today()->toDateString();
    $user=Auth::user()->username;
      $fileseqno=(cbsfiledetails::where('cbs_file_gen_dt',$filedt)->get()->unique('cbs_file_name')->count())+1;
    $filename="CBSFILE_".Carbon::today()->toDateString()."_".$fileseqno.".txt";
    \DB::beginTransaction();
    /*
    \DB::insert("insert cbsfiledetails (premium_id,status)
SELECT b.id,'N' FROM subscribermaster a,`premiumdetails` b
where a.pran_no=b.pran_no
and b.paid_status='N'
and b.premium_yr=(select min(premium_yr) from premiumdetails where pran_no=b.pran_no and paid_status ='N')
and b.premium_mth=(select min(premium_mth) from premiumdetails where pran_no=b.pran_no and paid_status ='N'
                  and premium_yr=(select min(premium_yr) from premiumdetails where pran_no=b.pran_no and paid_status ='N'))
and not exists (select 1 from cbsfiledetails where premium_id=b.id)");
*/
  
    \DB::insert("insert cbsfiledetails (premium_id,status)
    select a.id,'N' from premiumdetails a,(
select pran_no,min(convert(concat(premium_yr,'-',repeat('0',2-length(premium_mth)),premium_mth,'-01'),date)) as mindate
from premiumdetails where paid_status in ('N','E') group by pran_no) b
where a.pran_no=b.pran_no and a.premium_yr=year(b.mindate) and a.premium_mth=month(b.mindate)
    and not exists (select 1 from cbsfiledetails where premium_id=a.id)");
    \DB::update("update cbsfiledetails,(select @id :=0) a set status='N',cbs_file_name=?,cbs_file_gen_dt=?,cbs_file_gen_by=?,
                 response_loaded='N',sno=(@id := @id + 1) where status='E' or (cbs_file_name is null and status='N')",
                [$filename,$filedt,$user]);
    $cbsdetails=\DB::select("select 5001 as brcd,sno,'D' as debit,b.sub_ac_no as ac,
    concat(c.pran_no,'_',c.premium_mth,'_',c.premium_yr) narration,c.premium_amt+c.penalty_amt as amt
from cbsfiledetails a,subscribermaster b,premiumdetails c
where a.premium_id=c.id
and b.pran_no=c.pran_no
and a.status='N' and a.cbs_file_name is not null");
    if(count($cbsdetails)==0)
    {
       \DB::rollBack();
        return redirect('gencbsfile')->with('message','No Pending Records');
    }
    $out="";
    foreach($cbsdetails as $cbsdetail)
    {
      $out=$out.$cbsdetail->brcd."|".$cbsdetail->sno."|".$cbsdetail->debit."|".$cbsdetail->ac."|".
         $cbsdetail->narration."|".$cbsdetail->amt."\r\n";
    }
    $bytes_written = file_put_contents($filelocation."/".$filename, $out);
     if($bytes_written==FALSE)
     {
       \DB::rollBack();
        return redirect('gencbsfile')->with('message','Error Writing to file');
     }
    \DB::commit();
    
     return response()->download($filelocation."/".$filename);
  }
  
    public function regenerate(Request $request)
  {
    $filename=$request->get('rfname');
    
    $pranlist=cbsfiledetails::where('cbs_file_name',$filename)->get();
    if(count($pranlist)==0)
      return redirect('gencbsfile')->with('message','Invalid File Name');
     $filelocation=filelocations::where('file_type','cbsfile')->get();
      if(count($filelocation)!=1)
         return redirect('gencbsfile')->with('message','Save File location not defined');
    
      $filelocation=$filelocation[0]['location'];
     if(file_exists($filelocation."/".$filename)==FALSE)
       return redirect('gencbsfile')->with('message','File not found.Please contact administrator');
     return response()->download($filelocation."/".$filename);
    
  }
  
  public function uploadresponse(Request $request)
  {
     $filelocation=filelocations::where('file_type','cbsrespfile')->get();
      if(count($filelocation)!=1)
         return redirect('gencbsfile')->with('message','Save File location not defined');
    $filelocation=$filelocation[0]['location'];
      $file = $request->file('respfile');
     $filename=$file->getClientOriginalName();
    $tempfilename=explode('.',$filename)[0];
    $tempfilename=substr($tempfilename,0,strrpos($tempfilename,'_')).".".$file->getClientOriginalExtension();
    $fileexists=cbsfiledetails::where('cbs_file_name',$tempfilename)->where('response_loaded','N')->count();
    
    if($fileexists==0)
       return redirect('gencbsfile')->with('message','Original File not available / Response already loaded.');
    $file->move($filelocation."/",$file->getClientOriginalName());
    $filepath=$filelocation."/".$file->getClientOriginalName();
    $fileptr=fopen($filepath,"r");
    $todaydt=Carbon::today()->toDateString();
      \DB::beginTransaction();
    while(($line=fgets($fileptr))!=FALSE)
    {
        $temp=explode("|",$line);
        $sno=(int)$temp[0];
        $status=$temp[7];
        if($status=='O')
        {
          $cbsfiledetails=cbsfiledetails::where('sno',$sno)->where('cbs_file_name',$tempfilename)->first();
          $cbsfiledetails->status='Y';
          $cbsfiledetails->response_loaded='Y'; 
          $cbsfiledetails->save();
          premiumdetails::where('id',$cbsfiledetails->premium_id)->update(['paid_status'=>'Y','paid_dt'=>$todaydt]);
          
        }
        if($status=='E') 
        {
           cbsfiledetails::where('sno',$sno)->where('cbs_file_name',$tempfilename)->update(['status'=>'E','response_loaded'=>'Y']); 
        }
        
    }
    \DB::commit();
    return redirect('gencbsfile')->with('message','Response marked Successfully');
  }
}
