<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rfid extends Model
{
    use HasFactory;

    protected $table = 'rfid';

    protected $fillable = [
        'rfid',
    ];
}
