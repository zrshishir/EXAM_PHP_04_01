<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colleague extends Model
{
    use HasFactory;

    protected $fillable = ['office_name', 'office_address', 'office_phone', 'appointment_letter', 'colleague_name', 'colleague_mobile', 'colleague_address', 'photo'];
}
