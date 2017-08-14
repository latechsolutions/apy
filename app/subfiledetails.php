<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class subfiledetails extends Model
{
  protected $table='subfiledetails';
  public $timestamps=false;
  protected $fillable=array('pran_no','file_name','file_gen_dt','file_gen_by');
  
}
