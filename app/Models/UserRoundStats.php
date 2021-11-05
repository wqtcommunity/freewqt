<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRoundStats extends Model
{
    use HasFactory;
    public $incrementing = false;

    protected $primaryKey = ['round_id', 'user_id'];
    protected $guarded = [];
}
