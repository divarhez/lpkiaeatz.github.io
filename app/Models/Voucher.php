<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'description', 'discount', 'type', 'is_active', 'expired_at'
    ];

    protected $dates = ['expired_at'];
}
