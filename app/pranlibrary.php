<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pranlibrary extends Model
{
  protected $table='pranlibrary';
  public $timestamps=false;
  protected $fillable=array('pran_no','alloted','ent_dt');
  
}
