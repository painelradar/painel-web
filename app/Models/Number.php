<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Number extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'integerNumber',
        'stringNumber',
        'status',
        'queue_id',
        'user_id',
    ];
    public function minutesWaiting()
    {
        $updated = new Carbon($this->updated_at);
        $minutes = $updated->diffInMinutes(Carbon::now());
        return $minutes;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function queue()
    {
        return $this->belongsTo(Queue::class);
    }
    public function serviceReport()
    {
        return $this->hasMany(ServiceReport::class);
    }
}
