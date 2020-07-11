<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Installment extends Model
{
    protected $table="installment";
    use SoftDeletes;

    public function whoPay() {
        return $this->belongsTo('App\Model\User','payer','id');
    }
}
