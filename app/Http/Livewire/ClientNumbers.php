<?php

namespace App\Http\Livewire;

use App\Models\Number;
use App\Models\Queue;
use App\Models\QueueToCall;
use App\Models\ServiceReport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ClientNumbers extends Component
{


    public function callNext(Queue $queue)
    {
        if ($queue->numbers->count() != 0) {
            $number = Number::where('status', 'WAITING')->where('queue_id', $queue->id)->first();
            if (!$number) {
                return redirect()->back();
            }
            if ($number->status == "IN_SERVICE") {
                return redirect()->back();
            }
            $number->status =  "IN_SERVICE";
            $updated = new Carbon($number->updated_at);
            $minutes = $updated->diffInMinutes(Carbon::now());
            ServiceReport::create([
                'stringNumber' => $number->stringNumber,
                'queue' => $number->queue->name,
                'attendant' => Auth::user()->name,
                'action' => 'CALL',
                'time' => $minutes,
            ]);
            $number->update();
            QueueToCall::create([
                'stringNumber' => $number->stringNumber,
                'queue' => $number->queue->name,
                'number' => $number->integerNumber,
                'table_number' => Auth::user()->table_number,
            ]);
            $user = Auth::user();
            $user->in_atend = true;
            $user->number_id = $number->id;
            $user->save();
            return redirect()->route('number.actions', $number->id);
        }
    }
    public function call(Number $number)
    {
        if ($number->status == "IN_SERVICE") {
            return redirect()->back();
        }
        $number->status =  "IN_SERVICE";
        $updated = new Carbon($number->updated_at);
        $minutes = $updated->diffInMinutes(Carbon::now());
        ServiceReport::create([
            'stringNumber' => $number->stringNumber,
            'queue' => $number->queue->name,
            'attendant' => Auth::user()->name,
            'action' => 'CALL',
            'time' => $minutes,
        ]);
        $number->update();
        QueueToCall::create([
            'stringNumber' => $number->stringNumber,
            'queue' => $number->queue->name,
            'queue_id' => $number->queue_id,
            'number' => $number->integerNumber,
            'table_number' => Auth::user()->table_number,
        ]);
        $user = Auth::user();
        $user->in_atend = true;
        $user->number_id = $number->id;
        $user->save();
        return redirect()->route('number.actions', $number->id);
    }
    public function verifyService()
    {
        if (Auth::user()->in_atend and Auth::user()->number_id != null) {
            session()->flash('message', 'Você já está atendendo uma senha, precisa concluir o atendimento antes de iniciar outro.');
            return redirect()->route('number.actions', Auth::user()->number_id);
        }
    }
    public function render()
    {


        $queues = Auth::user()->queues->sortBy('name');
        $absents = Number::whereIn('queue_id', $queues->pluck('id'))->where('status', 'ABSENT')->orderBy('id', 'desc')->take(5)->get();
        $numbers = Number::whereIn('queue_id', $queues->pluck('id'))
                    ->where('status', 'WAITING')
                    ->where('coop', Auth::user()->coop)
                    ->where('pa', Auth::user()->pa)
                    ->orderBy('updated_at', 'asc')->get();
        return view('livewire.client-numbers', compact('queues', 'numbers', 'absents'))->layout('layouts.client-numbers');
    }
}
