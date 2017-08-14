<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class premiumdetails extends Model
{
  protected $table='premiumdetails';
  public $timestamps=false;
  protected $fillable=array('run_dt','premium_mth','premium_yr','premium_amt','penalty_amt','paid_status','paid_dt',
                            'pran_no','contr_file_name','contr_file_dt','prem_ded_by','contr_file_gen_by');
  
}
