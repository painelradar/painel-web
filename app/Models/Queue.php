<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Queue extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'minNum',
        'maxNum',
        'initial',
    ];

    public function printNumber()
    {
        $numbers = Number::where('user_id', Auth::guard('web')->user()->id)->get();

        if ($numbers->where('queue_id', $this->id)->count() == 0) {
            $integerNumber = intval($this->minNum);
        } else {
            $numberTemp = Number::where('queue_id', $this->id)->orderBy('id', 'desc')->where('user_id', Auth::guard('web')->user()->id)->first();
            $integer = $numberTemp->integerNumber;
            if ($integer > $this->maxNum) {
                $integer = $this->minNum;
            } else {
                $integer += 1;
            }
            $integerNumber = $integer;
        }
        $stringNumber = $this->initial . str_pad($integer, 3, "0", STR_PAD_LEFT);
        Number::create([
            'integerNumber' => $integerNumber,
            'stringNumber' => $stringNumber,
            'status' => 'WAITING',
            'queue_id' => $this->id,
            'user_id' => Auth::guard('web')->user()->id,
        ]);
        $printReport = new PrintReport();
        $printReport->newPrintReport($this, $stringNumber);
        return $stringNumber;
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'queue_users');
    }
    public function numbers()
    {
        return $this->hasMany(Number::class);
    }
    public function services()
    {
        return $this->hasMany(ServiceReport::class);
    }
    public function attendants()
    {
        return $this->hasMany(Attendant::class, 'queue_attendants');
    }
}
