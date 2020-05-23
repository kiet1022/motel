<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyCost extends Model
{
    protected $table="daily_costs";
    use SoftDeletes;

    public function whoPay() {
        return $this->belongsTo('App\Model\User','payer','id');
    }
}
