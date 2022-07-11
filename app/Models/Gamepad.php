<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gamepad extends Model
{
    use HasFactory;
    protected $fillable = ['button', 'user_id', 'queue_id'];

    public function queue(){
        return $this->belongsTo(Queue::class);
    }
    public function user()
    {
        return $this->BelongsTo(User::class);
    }
}
