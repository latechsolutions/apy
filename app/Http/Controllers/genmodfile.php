<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use Session;
use App\modificationdetails;
use App\filelocations;
use App\brmaster;
use Carbon\Carbon;



class genmodfile extends Controller
{
   public function index($action)    
   {
     if($action=="penupdw")
     {
       $existingfiles=modificationdetails::where('mod_type','PENM')->whereNotNull('file_name')
                           ->orderBy('file_gen_dt','desc')->get()->unique('file_name');
     }
     elseif($action=="freqmod")
     {
        $existingfiles=modificationdetails::where('mod_type','FREQM')->whereNotNull('file_name')
                           ->orderBy('file_gen_dt','desc')->get()->unique('file_name');
     }
     elseif($action=="submod")
     {
        $existingfiles=modificationdetails::where('mod_type','SUBM')->whereNotNull('file_name')
                           ->orderBy('file_gen_dt','desc')->get()->unique('file_name');
     }
     else
     {
       echo "Invalid Usage";
       return;
     }
       return view ('modfilegen',['action'=>$action,'existingfiles'=>$existingfiles]);
   }
  
  public function action($action,$subaction,Request $request)
  {
    if($action=="penupdw")
    {
      if($subaction=="newgen")
        return $this->penupdwnewgen($action,$request);
      if($subaction=="regen")
        return $this->regenerate($action,$request);
    }
    if($action=="freqmod")
    {
      if($subaction=="newgen")
        return $this->freqmodnewgen($action,$request);
      if($subaction=="regen")
         return $this->regenerate($action,$request);
    }
    if($action=="submod")
    {
      if($subaction=="newgen")
        return $this->submodnewgen($action,$request);
      if($subaction=="regen")
        return $this->regenerate($action,$request);
    }
  }
  protected function penupdwnewgen($action,$request)
  {
   
    $pendingrec=modificationdetails::where('mod_type','PENM')->whereNull('file_name')->get();
    
    if(count($pendingrec)>0)
    {
      $filelocation=filelocations::where('file_type','submodfile')->get();
      if(count($filelocation)!=1)
         return redirect('genmodfile/'.$action)->with('message','Save File location not defined');
    $filelocation=$filelocation[0]['location'];
      
    $nlooregno=brmaster::first()->nloo_reg_no;
      $fileseqno=(modificationdetails::where('file_gen_dt',Carbon::today()->toDateString())->count())+1;
      $filename="SUBMOD-PENM-".Carbon::today()->toDateString()."-".$fileseqno.".xml";
      $out="<file xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"subMod_APY.xsd\">";
      $out=$out."<header><req-type>SUBMODF</req-type><req-date>".Carbon::today()->format('Y-m-d')."</req-date>";
      $out=$out."<no-of-records>".count($pendingrec)."</no-of-records><reg-no>".$nlooregno."</reg-no>";
      $out=$out."<entity-type>NLOO</entity-type><back-offc-ref-num>".$nlooregno.Carbon::today()->format('dmy').str_pad($fileseqno,2,"0",STR_PAD_LEFT)."</back-offc-ref-num>";
      $out=$out."<transaction-type>A</transaction-type></header>";
      foreach($pendingrec as $rec)
      {
        $out=$out."<req-dtl><pran>".$rec['pran_no']."</pran><cntr-dtl><pension-amt><new-amt>";
        $newpenamt=json_decode($rec->new_value)->pen_amt;
        $out=$out.$newpenamt."</new-amt><request-type>M</request-type></pension-amt></cntr-dtl></req-dtl>";
      }
      $out=$out."</file>";
   
    \DB::beginTransaction();
    $bytes_written = file_put_contents($filelocation."/".$filename, $out);
     if($bytes_written==FALSE)
        return redirect('genmodfile/'.$action)->with('message','Error Writing to file');

    foreach($pendingrec as $rec)
    {
      $prem=modificationdetails::find($rec['id']);
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
      return redirect('genmodfile/'.$action)->with('message','No Pending Records');
  }
  public function freqmodnewgen($action,$request)
  {
    $pendingrec=modificationdetails::where('mod_type','FREQM')->whereNull('file_name')->get();
    
    if(count($pendingrec)>0)
    {
      $filelocation=filelocations::where('file_type','submodfile')->get();
      if(count($filelocation)!=1)
         return redirect('genmodfile/'.$action)->with('message','Save File location not defined');
    $filelocation=$filelocation[0]['location'];
      
    $nlooregno=brmaster::first()->nloo_reg_no;
      $fileseqno=(modificationdetails::where('file_gen_dt',Carbon::today()->toDateString())->count())+1;
      $filename="SUBMOD-FREQM-".Carbon::today()->toDateString()."-".$fileseqno.".xml";
      $out="<file xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"subMod_APY.xsd\">";
      $out=$out."<header><req-type>SUBMODF</req-type><req-date>".Carbon::today()->format('Y-m-d')."</req-date>";
      $out=$out."<no-of-records>".count($pendingrec)."</no-of-records><reg-no>".$nlooregno."</reg-no>";
      $out=$out."<entity-type>NLOO</entity-type><back-offc-ref-num>".$nlooregno.Carbon::today()->format('dmy').str_pad($fileseqno,2,"0",STR_PAD_LEFT)."</back-offc-ref-num>";
      $out=$out."<transaction-type>A</transaction-type></header>";
      foreach($pendingrec as $rec)
      {
        $out=$out."<req-dtl><pran>".$rec['pran_no']."</pran><cntr-dtl><pension-amt><new-amt>";
        $newpenamt=json_decode($rec->new_value)->pay_freq;
        $out=$out.$newpenamt."</new-amt><request-type>M</request-type></pension-amt></cntr-dtl></req-dtl>";
      }
      $out=$out."</file>";
   
    \DB::beginTransaction();
    $bytes_written = file_put_contents($filelocation."/".$filename, $out);
     if($bytes_written==FALSE)
        return redirect('genmodfile/'.$action)->with('message','Error Writing to file');

    foreach($pendingrec as $rec)
    {
      $prem=modificationdetails::find($rec['id']);
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
      return redirect('genmodfile/'.$action)->with('message','No Pending Records');
  }
  public function submodnewgen($request)
  {}
  public function regenerate($action,$request)
  {
        $filename=$request->get('rfname');
    
    $filelist=modificationdetails::where('file_name',$filename)->get();
    if(count($filelist)==0)
      return redirect('genmodfile/'.$action)->with('message','Invalid File Name');
     $filelocation=filelocations::where('file_type','submodfile')->get();
      if(count($filelocation)!=1)
         return redirect('genmodfile/'.$action)->with('message','Save File location not defined');
    
      $filelocation=$filelocation[0]['location'];
     if(file_exists($filelocation."/".$filename)==FALSE)
       return redirect('genmodfile/'.$action)->with('message','File not found.Please contact administrator');
     return response()->download($filelocation."/".$filename);
  }
}
