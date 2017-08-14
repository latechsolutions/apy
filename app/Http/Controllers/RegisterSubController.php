<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\contributiondetails;
use App\subscribermaster;
use App\pranlibrary;
use App\brmaster;
use Carbon\Carbon;
use Session;
use Auth;


class RegisterSubController extends Controller
{
      public function __construct()
    {
        $this->middleware('auth');
    }

  public function index()
  {
    return view('registersub');
  }
  
  public function registersub(Request $request)
  {
    
    $rules=['cbsacno_brcd'=>'required|regex:/^[5][0-9]{3}$/',
            'cbsacno_acno'=>'required|regex:/^[1-9][0-9]{0,8}$/',
            'custid'=>'required|numeric',
            'title'=>'required|in:shri,smt,kumari',
            'subname'=>'required|regex:/^[a-zA-Z][a-zA-z ]+$/|max:90',
            'fthname'=>'regex:/^[a-zA-Z][a-zA-z ]+$/',
            'subdob'=>'required|date_format:Ymd',
            'subage'=>'required|numeric|min:18|max:39',
            'gender'=>'required|in:M,F,T',
            'maristat'=>'required|in:Y,N',
            'addr'=>'required|regex:/^[a-zA-Z0-9][a-zA-z0-9\,\.\/\- ]+$/|max:90',
            'addrdist'=>'required|regex:/^[a-zA-Z][a-zA-z ]+$/|max:90',
            'addrstut'=>'required|in:29',
            'addrcty'=>'required|in:IN',
            'addrpin'=>'required|regex:/^[1-9][0-9]{5}$/',
            'sponame'=>'required_if:maristat,Y|regex:/^[a-zA-Z][a-zA-z ]+$/|max:90',
            'swavalam'=>'required|in:N',
            'otherssch'=>'required|in:N',
            'itpay'=>'required|in:Y,N',
            'nomname'=>'required|regex:/^[a-zA-Z][a-zA-z ]+$/|max:90',
            'nomdob'=>'required|date_format:Y-m-d',
            'nomrel'=>'required|alpha|max:30',
            'nomage'=>'required|numeric|max:100',
            'mobno'=>'required|regex:/^[7-9][0-9]{9}$/',
            'aadhaarno'=>'regex:/^[1-9][0-9]{11}$/',
            'penamt'=>'required|in:1000,2000,3000,4000,5000',
            'payfreq'=>'required|in:M,Q,H',
            'contriamt'=>'required|integer|min:1'
           ];
    $errormsg=['cbsacno_brcd.*'=>'Branch Code is mandatory and be numeric',
               'cbsacno_acno.*'=>'A/c No is mandatory and should be numeric',
               'custid.*'=>'Customer Id is mandatory and should be numeric',
               'title.*'=>'Title should be Shri,Smt or Kumari',
               'subname.*'=>'Name is mandatory and should contain only alphabets',
               'fthname.*'=>'Father Name is mandatory and should contain only alphabets',
               'subdob.*'=>'Date of birth should be a valid date',
               'subage.*'=>'Age should be between 18 and 39',
               'gender.*'=>'Gender Mandatory',
               'maristat.*'=>'Marital Status is mandatory',
               'addr.*'=>'Address is mandatory and should contain only alphabets',
               'addrdist.*'=>'District is mandatory and should contain only alphabets',
               'addrstut.*'=>'State/Union Territory is mandatory',
               'addrcty.*'=>'Country is mandatory',
               'addrpin.*'=>'Pincode is mandatory',
               'sponame.*'=>'Spouse Name is mandatory and should contain only alphabets',
               'swavalam.*'=>'Migration of Swavalamban Beneficiaries not possible',
               'otherssch.*'=>'Other Social Scheme Beneficiaries are not eligible',
               'itpay.*'=>'Please select whether paying IT',
               'nomname.*'=>'Nominee Name is mandatory and should contain only alphabets',
               'nomdob.*'=>'Nominee Date of Birth should be a valid date',
               'nomrel.*'=>'Nominee relation is mandatory',
               'nomage.*'=>'Nominee Age is mandatory and should be numeric',
               'mobno.*'=>'Mobile Number is mandatory',
               'penamt.*'=>'Pension Amount is Mandatory',
               'payfreq.*'=>'Premium Payment Frequency is mandatory',
               'contriamt.*'=>'Premium Amount is mandatory'
              ];

    $this->validate($request,$rules,$errormsg);
$brcd=Session::get('brcode');
$cbsacno_brcd=$request->get('cbsacno_brcd');
$cbsacno_acno=str_pad($request->get('cbsacno_acno'),9,"0",STR_PAD_LEFT);
$cbsacno=$cbsacno_brcd."01".$cbsacno_acno;
    
 if($brcd!=substr($cbsacno,0,4))
   return back()->withInput()->withErrors(['errormsg'=>'Scheme can be registered only for home branch customers']);
$pran_no=pranlibrary::where('allotted','N')->min('pran_no');
if($pran_no=="")  
   return back()->withInput()->withErrors(['errormsg'=>'Free Pran No. not available.Please populate pran library and try again']);
$title=$request->get('title');
$sub_name=$request->get('subname');
$sub_fth_name=$request->get('fthname');
$brdetails= brmaster::where('br_code',$brcd)->first();
if(count($brdetails)!=1)
     return back()->withInput()->withErrors(['errormsg'=>'Branch details not available in the master.']); 
$nlao_reg_no=$brdetails->nlao_reg_no;
$nlcc_reg_no=$brdetails->nlcc_reg_no;
$sub_gender=$request->get('gender');
$sub_dob=$request->get('subdob');
$sub_addr=$request->get('addr');
$sub_addr_dt_tw_ct=$request->get('addrdist');
$sub_addr_st_ut=$request->get('addrstut');
$sub_addr_ct=$request->get('addrcty');
$sub_addr_pin=$request->get('addrpin');
$sub_mob_no=$request->get('mobno');
$sub_sms_flag='Y';
$sub_marital_st=$request->get('maristat');
$sub_spou_name=($sub_marital_st=='N'?'':$request->get('sponame'));
$sub_ac_type=$request->get('');
$sub_ac_no=$cbsacno;
$sub_bank_name='PANDYAN GRAMA BANK';
$sub_br_name=$brdetails->br_name;
$sub_micr_cd=$brdetails->micr_code;
$sub_ifsc_cd=$brdetails->ifsc_code;
$swavalamban_flag='N';
$oth_sschemes='N';
$it_payer=$request->get('itpay');
$pen_amt=$request->get('penamt');
$contr_amt=$request->get('contriamt');
$pay_freq=$request->get('payfreq');
$appl_dt=Carbon::today()->toDateString();
$si_dt=Carbon::today()->day;
$appl_place=substr($sub_br_name,0,15);
$nom_name=$request->get('nomname');
$nom_dob=$request->get('nomdob');
$nom_rel=$request->get('nomrel');
$nom_age=$request->get('nomage');
$nom_maj_min=($nom_age>=18?'N':'Y');
$guard_name=($nom_maj_min=='N'?'':$request->get('guardname'));
if($nom_age<18 && $guard_name=='')
  return back()->withInput()->withErrors(['guardname'=>'Guardian Name is mandatory if nominee is minor']); 
if($sub_mob_no=="9999999999")
  return back()->withInput()->withErrors(['mobno'=>'Please enter a valid mobile no']);
    
\DB::beginTransaction();
    subscribermaster::create(['pran_no'=>$pran_no,'title'=>$title,'sub_name'=>$sub_name,'sub_fth_name'=>$sub_fth_name,
                             'nlao_reg_no'=>$nlao_reg_no,'nlcc_reg_no'=>$nlcc_reg_no,'sub_gender'=>$sub_gender,
                             'sub_dob'=>$sub_dob,'sub_addr'=>$sub_addr,'sub_addr_dt_tw_ct'=>$sub_addr_dt_tw_ct,
                             'sub_addr_st_ut'=>$sub_addr_st_ut,'sub_addr_ct'=>$sub_addr_ct,'sub_addr_pin'=>$sub_addr_pin,
                             'sub_mob_no'=>$sub_mob_no,'sub_sms_flag'=>$sub_sms_flag,'sub_marital_st'=>$sub_marital_st,
                             'sub_spou_name'=>$sub_spou_name,'sub_ac_type','sub_ac_no'=>$sub_ac_no,'sub_bank_name'=>$sub_bank_name,
                             'sub_br_name'=>$sub_br_name,'sub_micr_cd'=>$sub_micr_cd,'sub_ifsc_cd'=>$sub_ifsc_cd,
                             'swavalamban_flag'=>$swavalamban_flag,'oth_sschemes'=>$oth_sschemes,'it_payer'=>$it_payer,
                             'pen_amt'=>$pen_amt,'contr_amt'=>$contr_amt,'pay_freq'=>$pay_freq,'si_dt'=>$si_dt,'appl_dt'=>$appl_dt,
                             'appl_place'=>$appl_place,'nom_name'=>$nom_name,'nom_dob'=>$nom_dob,'nom_rel'=>$nom_rel,
                             'nom_maj_min'=>$nom_maj_min,'guard_name'=>$guard_name,'ent_by'=>Auth::user()->username,
                             'ent_dt_time'=>Carbon::now(),'status'=>'EN','brcode'=>$brcd]);
    pranlibrary::where('pran_no',$pran_no)->update(['allotted'=>'Y']);
\DB::commit();
 return redirect('registersub')->with('message','Successfully Registered. PRAN No='.$pran_no);
  }
}
