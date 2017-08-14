<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class modificationdetails extends Model
{
  protected $table='modificationdetails';
  public $timestamps=false;
  protected $fillable=array('pran_no','mod_type','old_value','new_value','mod_by','mod_dt','file_name',
                           'file_gen_dt','file_gen_by','response_uploaded');
  
}
