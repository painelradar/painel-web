<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'minNum',
        'maxNum',
        'initial'
    ];

    public function printNumber($coop, $pa)
    {
        $numbers = Number::all();

        if ($numbers->where('queue_id', $this->id)->count() == 0) {
            $integerNumber = intval($this->minNum);
        } else {
            $numberTemp = Number::where('queue_id', $this->id)->orderBy('id', 'desc')->first();
            $integer = $numberTemp->integerNumber;
            if ($integer > $this->maxNum) {
                $integer = $this->minNum;
            } else {
                $integer += 1;
            }
            $integerNumber = $integer;
        }

        $stringNumber = $integerNumber;
        $zeros = 0;
        if ($integerNumber <= 99) {
            $zeros = 1;
            if ($integerNumber <= 9) {
                $zeros = 2;
            }
            if ($integerNumber > 99) {
                $zeros = 3;
            }
        }
        $stringZero = "";

        for ($i = 0; $i < $zeros; $i++) {
            $stringZero .= "0";
        }
        $stringNumber = $this->initial . $stringZero . $integerNumber;
        return $stringNumber;
    }

    public function printNumberGamepad($coop, $pa)
    {
        $numbers = Number::all();

        if ($numbers->where('queue_id', $this->id)->count() == 0) {
            $integerNumber = intval($this->minNum);
        } else {
            $numberTemp = Number::where('queue_id', $this->id)->orderBy('id', 'desc')->first();
            $integer = $numberTemp->integerNumber;
            if ($integer > $this->maxNum) {
                $integer = $this->minNum;
            } else {
                $integer += 1;
            }
            $integerNumber = $integer;
        }

        $stringNumber = $integerNumber;
        $zeros = 0;
        if ($integerNumber <= 99) {
            $zeros = 1;
            if ($integerNumber <= 9) {
                $zeros = 2;
            }
            if ($integerNumber > 99) {
                $zeros = 3;
            }
        }
        $stringZero = "";

        for ($i = 0; $i < $zeros; $i++) {
            $stringZero .= "0";
        }
        $stringNumber = $this->initial . $stringZero . $integerNumber;

        Number::create([
            'integerNumber' => $integerNumber,
            'stringNumber' => $stringNumber,
            'status' => 'WAITING',
            'queue_id' => $this->id,
            'coop' => $coop,
            'pa' => $pa
        ]);

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
}
