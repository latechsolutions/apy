<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class premiumhistory extends Model
{
  protected $table='premiumhistory';
  public $timestamps=false;
  protected $fillable=array('pran_no','pen_amt','prem_amt','pay_freq','from_dt','to_dt','ent_dt');
  
}
