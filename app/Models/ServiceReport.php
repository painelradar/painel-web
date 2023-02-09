<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ServiceReport extends Model
{
    use HasFactory;
    protected $fillable = [
        'number_id',
        'queue_id',
        'attendant_id',
        'time',
        'action',
    ];

    public function newServiceReport($queue, $number, $minutes, $action)
    {
        $this->number_id = $number->id;
        $this->action = $action;
        $this->time = $minutes;
        $this->queue_id = $queue->id;
        $this->attendant_id = Auth::user()->id;
        $this->save();
    }
    public function queue()
    {
        return $this->belongsTo(Queue::class);
    }
    public function attendant()
    {
        return $this->belongsTo(Attendant::class);
    }
}
