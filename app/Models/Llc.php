<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Plan;

class Llc extends Model
{
    protected $table = 'llc';
    protected $guarded = [];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
