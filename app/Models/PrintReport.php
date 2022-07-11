<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrintReport extends Model
{
    use HasFactory;
    protected $fillable = [
        'stringNumber',
        'queue'
    ];

    public function newPrintReport($queue, $stringNumber)
    {
        $report = new PrintReport();
        $report->stringNumber = $stringNumber;
        $report->queue = $queue->name;
        $report->save();
    }
}
