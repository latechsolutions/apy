<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class filelocations extends Model
{
  protected $table='filelocations';
  public $timestamps=false;
  protected $fillable=array('file_type','location');
  
}
