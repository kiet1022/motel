<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Installment extends Model
{
    protected $table="installment";
    protected $fillable = ['waiting_amout'];
    use SoftDeletes;

    public function whoPay() {
        return $this->belongsTo('App\Model\User','payer','id');
    }

    public function detail() {
        return $this->hasMany('App\Model\InstallmentDetail','installment_id','id');
    }
}
