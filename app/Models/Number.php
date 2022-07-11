<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Number extends Model
{
    use HasFactory;

    protected $fillable = [
        'integerNumber',
        'stringNumber',
        'status',
        'queue_id',
        'coop',
        'pa'
    ];
    public function minutesWaiting()
    {
        $updated = new Carbon($this->updated_at);
        $minutes = $updated->diffInMinutes(Carbon::now());
        return $minutes;
    }
    public function queue()
    {
        return $this->belongsTo(Queue::class);
    }
}
