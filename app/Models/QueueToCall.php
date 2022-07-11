<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueueToCall extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'stringNumber',
        'table_number',
        'queue',
        'queue_id'
    ];
}
