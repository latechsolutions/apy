<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class subscribermaster extends Model
{
  protected $table='subscribermaster';
  public $timestamps=false;
  protected $fillable=array('pran_no','title','sub_name','sub_fth_name','nlao_reg_no','nlcc_reg_no','sub_gender','sub_dob','sub_pan',
                            'sub_addr','sub_addr_dt_tw_ct','sub_addr_st_ut','sub_addr_ct','sub_addr_pin','sub_addr_loc','sub_addr_lmark',
                            'sub_tel_no','sub_mob_no','sub_email_id','sub_sms_flag','sub_marital_st','sub_spou_name','sp_spou_aadh_no',
                            'sub_ac_type','sub_ac_no','sub_bank_name','sub_br_name','sub_micr_cd','sub_ifsc_cd','sub_aadh_no',
                            'swavalamban_flag','oth_sschemes','it_payer','pen_amt','contr_amt','si_dt','appl_dt','appl_place',
                            'pay_freq','nom_name','nom_dob','nom_aadh_no','nom_rel','nom_maj_min','guard_name','ent_by','app_by',
                            'ent_dt_time','app_dt_time','status','brcode');
  
}
