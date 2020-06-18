<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    protected $table="categories";
    use SoftDeletes;

    public function costs() {
        return $this->hasMany('App\Model\DailyCost','category','id');
    }
}
