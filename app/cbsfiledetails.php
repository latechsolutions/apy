<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cbsfiledetails extends Model
{
  protected $table='cbsfiledetails';
  public $timestamps=false;
  protected $fillable=array('premium_id','cbs_file_name','cbs_file_gen_dt','cbs_file_gen_by','status','response_loaded','sno');
  
}
