<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ServiceReport extends Model
{
    use HasFactory;
    protected $fillable = [
        'stringNumber',
        'queue',
        'attendant',
        'time',
        'action',
    ];

    public function newServiceReport($queue, $stringNumber)
    {
        $report = new ServiceReport();
        $report->stringNumber = $stringNumber;
        $report->queue = $queue->name;
        $report->attendant = Auth::user()->name;
        $report->save();
    }
}
