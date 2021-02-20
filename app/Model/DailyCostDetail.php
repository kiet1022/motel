<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyCostDetail extends Model
{
    protected $table = "daily_costs_detail";
    use SoftDeletes;
}
