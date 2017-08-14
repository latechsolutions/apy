<?php

namespace App\Http\Controllers\utils;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Carbon\Carbon;
use App\subscribermaster;

class getcbsdetails extends Controller
{
    public function index($op,$param1=null,$param2=null,$param3=null)
    {
      $client=new Client();
      if($op=="cid")
      {
        $acno=$param1;
        $url='http://10.249.4.26:88/apyservice/apyservice.asp?op=cid&acno='.$acno;
        $response=$client->get($url);
     
        
       // $json = '{"cid":"2104483","maristat":"S","sponame":"NA","crop":"Y","subname":"subname","dob":"19860926","sex":"M","ftname":"BALAMURUGAN","custstatus":"#","clearbal":"11647.55","acstatus":"#","doorno":"3/499","bldgname":"CHIDAMBARAM NAGAR,","stname":"SATTUR 626203","division":" ","cttnvil":"VNR","location":"S","district":"VIRUDHUNAGAR","pin":"626203","mobile":"9894513433","email":""}';

     //   var_dump(json_decode($json));
      //  var_dump( json_decode ($response->getBody()));
      
        $d=json_decode($response->getBody(),true);
        
        if($d['status']=="error")
           return json_encode($d);
        $existrec=subscribermaster::where('sub_ac_no',$acno)->get();
        if(count($existrec)>0)
          return json_encode(['status'=>'error','errormsg'=>'A/c No. already registered']);
        
        $newaddr=$d['doorno'].' '.$d['bldgname'].' '.$d['stname'].' '.$d['cttnvil'];
        if(strlen($newaddr)>90)
          $newaddr=substr($newaddr,0,90);
        $d["address"]=trim($newaddr);
        $d["age"]=Carbon::today()->diffInYears(Carbon::createFromFormat('Ymd',$d['dob']));
        
        $data=array('status'=>'success','data'=>$d);
        //var_dump( $data);
        $data=json_encode($data);
        echo $data;
        
      }
    }
}
