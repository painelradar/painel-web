<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueueAttendant extends Model
{
    use HasFactory;

    protected $fillable = [
        'queue_id',
        'attendant_id'
    ];
}
