<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstallmentDetail extends Model
{
    protected $table="installment_details";
    use SoftDeletes;

    public function installment() {
        return $this->belongsTo('App\Model\Installment','installment_id','id');
    }
}
