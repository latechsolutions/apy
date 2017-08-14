<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class jobstatus extends Model
{
  protected $table='jobstatus';
  public $timestamps=false;
  protected $fillable=array('job_id','job_type','job_params','status','comp_percent','error_msg');
  
}
