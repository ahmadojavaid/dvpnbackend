<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountStatus extends Model
{
    protected $table = "account_status";
    protected $guarded = [];

    protected $hidden = ['created_at', 'updated_at'];
}
