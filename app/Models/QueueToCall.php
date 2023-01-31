<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class QueueToCall extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'stringNumber',
        'table_number',
        'queue',
        'queue_id',
        'user_id'
    ];
    public function newNumberToCall($number)
    {
        $attendant = Auth::user();
        $this->number = $number->integerNumber;
        $this->stringNumber = $number->stringNumber;
        $this->table_number = $attendant->table_number;
        $this->queue = $number->queue->name;
        $this->queue_id = $number->queue->id;
        $this->user_id = $attendant->user_id;
        $this->save();
    }
}
