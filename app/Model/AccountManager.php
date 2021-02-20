<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;

class AccountManager extends Model
{
    protected $table = "account_manager";
    use SoftDeletes;

    /**
     * Get the pass.
     *
     * @param  string  $value
     * @return string
     */
    public function getPassAttribute($pass)
    {
        // decrypt password before retrieve
        return Crypt::decryptString($pass);
    }

    /**
     * Set the pass.
     *
     * @param  string  $value
     * @return void
     */
    public function setPassAttribute($pass)
    {
        $this->attributes['pass'] = Crypt::encryptString($pass);
    }
}
