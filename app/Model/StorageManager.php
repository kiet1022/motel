<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StorageManager extends Model
{
    protected $table="storage_manager";
    use SoftDeletes;
}
