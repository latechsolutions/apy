<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class brmaster extends Model
{
  protected $table='brmaster';
  public $timestamps=false;
  protected $fillable=array('br_code','br_name','nlao_reg_no','nlcc_reg_no','micr_code','ifsc_code','nloo_reg_no');
  
}
