<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class contributiondetails extends Model
{
  protected $table='contributiondetails';
  public $timestamps=false;
  protected $fillable=array('age','freq','pension_amt','premium_amt','corpus_amt','from_dt','to_dt');
  
}
