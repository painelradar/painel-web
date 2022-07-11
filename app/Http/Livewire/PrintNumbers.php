<?php

namespace App\Http\Livewire;

use App\Models\Number;
use App\Models\PrintReport;
use App\Models\Queue;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PrintNumbers extends Component
{

    public function createNumber(Queue $queue,$coop,$pa)
    {
        $number = Number::make();
        $numbers = Number::all();
        if ($numbers->where('queue_id', $queue->id)->count() == 0) {
            $number->integerNumber = intval($queue->minNum);
        } else {
            $numberTemp = Number::where('queue_id', $queue->id)->orderBy('id', 'desc')->first();
            $integer = $numberTemp->integerNumber;
            if ($integer > $queue->maxNum) {
                $integer = $queue->minNum;
            } else {
                $integer += 1;
            }
            $number->integerNumber = $integer;
        }
        $number->queue_id = $queue->id;
        $number->stringNumber = $number->integerNumber;
        $zeros = 0;
        if ($number->integerNumber <= 99) {
            $zeros = 1;
            if ($number->integerNumber <= 9) {
                $zeros = 2;
            }
            if ($number->integerNumber > 99) {
                $zeros = 3;
            }
        }
        $stringZero = "";

        for ($i = 0; $i < $zeros; $i++) {
            $stringZero .= "0";
        }
        $number->stringNumber = $queue->initial . $stringZero . $number->integerNumber;
        $number->status = "WAITING";
        $number->coop = $coop;
        $number->pa = $pa;
        $report = new PrintReport();
        $report->newPrintReport($queue, $number->stringNumber);
        $number->save();
    }
    public function render()
    {
        $queues = Auth::user()->queues->sortBy('id');
        return view('livewire.print-numbers', compact('queues'))->layout('layouts.print-numbers');
    }
}
