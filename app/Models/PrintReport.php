<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PrintReport extends Model
{
    use HasFactory;
    protected $fillable = [
        'stringNumber',
        'queue',
        'user_id'
    ];

    public function newPrintReport($queue, $stringNumber)
    {
        $this->stringNumber = $stringNumber;
        $this->queue = $queue->name;
        $this->user_id = Auth::guard('web')->user()->id;
        $this->save();
    }
}
