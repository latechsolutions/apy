<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\volexitdetails;
use App\filelocations;
use App\brmaster;
use Carbon\Carbon;
use Auth;


class genvolexitfile extends Controller
{
    public function index()
    {
         $existingfiles=volexitdetails::whereNotNull('file_name')->select('file_name')->get()->unique('file_name');
      return view ('volexitfilegen',['existingfiles'=>$existingfiles]);
    }
  
  public function newgenerate()
  {
     $pendingrec=volexitdetails::whereNull('file_name')->get();
    if(count($pendingrec)>0)
    {
      $filelocation=filelocations::where('file_type','volexitfile')->get();
      if(count($filelocation)!=1)
         return redirect('genvolexitfile')->with('message','Save File location not defined');
    $filelocation=$filelocation[0]['location'];
    $nlooregno=brmaster::first()->nloo_reg_no;
      $fileseqno=(volexitdetails::where('file_gen_dt',Carbon::today()->toDateString())->count())+1;
      $filename="VOLEXIT-".Carbon::today()->toDateString()."-".$fileseqno.".xml";
      $out="<file xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"exitWDR_APY.xsd\">";
      $out=$out."<header><req-type>EXITWDR</req-type><req-date>".Carbon::today()->format('Y-m-d')."</req-date>";
      $out=$out."<no-of-records>".count($pendingrec)."</no-of-records><reg-no>".$nlooregno."</reg-no>";
      $out=$out."<entity-type>NLOO</entity-type><back-offc-ref-num>".$nlooregno.Carbon::today()->format('dmy').str_pad($fileseqno,2,"0",STR_PAD_LEFT)."</back-offc-ref-num>";
      $out=$out."<transaction-type>A</transaction-type></header>";
      foreach($pendingrec as $rec)
      {
        $out=$out."<req-dtl><pran>".$rec['pran_no']."</pran><wdr-due-to>EN</wdr-due-to><wdr-type>P</wdr-type>";
        $out=$out."<share-to-wdr>100</share-to-wdr><share-to-annuity>0</share-to-annuity>";
        $out=$out."<exit-date>".Carbon::today()->format('Y-m-d')."</exit-date>";
        $out=$out."<subs-bank-dtls><bank-ifs-flag>Y</bank-ifs-flag>".
                   "<account-no>".$rec['ac_no']."</account-no><bank-ifs-code>".$rec['ifsc_cd']."</bank-ifs-code>".
                   "<sub-mob-no>".$rec['mob_no']."</sub-mob-no><sub-email>".$rec['email']."</sub-email></subs-bank-dtls>";
        $out=$out."<doc-check-list></doc-check-list>";
        $out=$out."</req-dtl>";
    
      }
      $out=$out."</file>";
   
    \DB::beginTransaction();
    $bytes_written = file_put_contents($filelocation."/".$filename, $out);
     if($bytes_written==FALSE)
        return redirect('genvolexitfile')->with('message','Error Writing to file');

    foreach($pendingrec as $rec)
    {
      $prem=volexitdetails::find($rec['id']);
      $prem->file_name=$filename;
      $prem->file_gen_dt=Carbon::today()->toDateString();
      $prem->file_gen_by=Auth::user()->username;
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
      return redirect('genvolexitfile')->with('message','No Pending Records');
  }
  
   public function regenerate(Request $request)
  {
    $filename=$request->get('rfname');
    
    $filelist=volexitdetails::where('file_name',$filename)->get();
    if(count($filelist)==0)
      return redirect('genvolexitfile')->with('message','Invalid File Name');
     $filelocation=filelocations::where('file_type','volexitfile')->get();
      if(count($filelocation)!=1)
         return redirect('genvolexitfile')->with('message','Save File location not defined');
    
      $filelocation=$filelocation[0]['location'];
     if(file_exists($filelocation."/".$filename)==FALSE)
       return redirect('genvolexitfile')->with('message','File not found.Please contact administrator');
     return response()->download($filelocation."/".$filename);
    
  }
}
