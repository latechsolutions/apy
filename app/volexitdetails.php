<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class volexitdetails extends Model
{
  protected $table='volexitdetails';
  public $timestamps=false;
  protected $fillable=array('pran_no','ifsc_cd','ac_no','mob_no','email_id','file_name','file_gen_dt',
                            'file_gen_by','closure_ent_by','closure_ent_dt');
  
}
