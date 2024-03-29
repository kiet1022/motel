<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyCost extends Model
{
    protected $table = "daily_costs";
    use SoftDeletes;

    public function whoPay()
    {
        return $this->belongsTo('App\Model\User', 'payer', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Model\Category', 'category', 'id');
    }

    public function details()
    {
        return $this->hasMany('App\Model\DailyCostDetail', 'daily_cost_id', 'id');
    }
}
