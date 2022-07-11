<?php

namespace App\Http\Livewire;

use App\Models\Number;
use App\Models\Queue;
use App\Models\QueueToCall;
use App\Models\ServiceReport;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ActionService extends Component
{
    public $number;
    public $selectedQueue;
    public function route(Number $number, Queue $queue)
    {

        $number->status = "WAITING";
        $queue = Queue::where('id', $queue->id)->first();
        $updated = new Carbon($number->updated_at);
        $minutes = $updated->diffInMinutes(Carbon::now());
        ServiceReport::create([
            'stringNumber' => $number->stringNumber,
            'queue' => $number->queue->name,
            'attendant' => Auth::user()->name,
            'action' => 'CONCLUDE',
            'time' => $minutes,
        ]);
        $number->queue_id = $queue->id;
        $number->update();
        $user = Auth::user();
        $user->in_atend = false;
        $user->number_id = null;
        $user->save();
        return redirect()->route('client.home');
    }
    public function absent(Number $number)
    {
        $updated = new Carbon($number->updated_at);
        $minutes = $updated->diffInMinutes(Carbon::now());
        ServiceReport::create([
            'stringNumber' => $number->stringNumber,
            'queue' => $number->queue->name,
            'attendant' => Auth::user()->name,
            'action' => 'ABSENT',
            'time' => $minutes,
        ]);
        $number->status = "ABSENT";
        $number->update();
        $user = Auth::user();
        $user->in_atend = false;
        $user->number_id = null;
        $user->save();
        return redirect()->route('client.home');
    }
    public function conclude(Number $number)
    {
        $updated = new Carbon($number->updated_at);
        $minutes = $updated->diffInMinutes(Carbon::now());
        ServiceReport::create([
            'stringNumber' => $number->stringNumber,
            'queue' => $number->queue->name,
            'attendant' => Auth::user()->name,
            'action' => 'CONCLUDE',
            'time' => $minutes,
        ]);
        $number->status = "FINISHED";
        $number->update();
        $user = Auth::user();
        $user->in_atend = false;
        $user->number_id = null;
        $user->save();
        return redirect()->route('client.home');
    }
    public function mount($id)
    {
        $this->number = Number::find($id);
    }
    public function repeat(Number $number)
    {
        if (QueueToCall::where('stringNumber', $number->stringNumber)->count() == 0) {
            $number->status =  "IN_SERVICE";
            $updated = new Carbon($number->updated_at);
            $minutes = $updated->diffInMinutes(Carbon::now());
            ServiceReport::create([
                'stringNumber' => $number->stringNumber,
                'queue' => $number->queue->name,
                'attendant' => Auth::user()->name,
                'action' => 'REPEAT',
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
        }
    }
    public function render()
    {
        $queues = Queue::all();
        $number = $this->number;
        return view('livewire.action-service', compact('queues', 'number'))->layout('layouts.action-service');;
    }
}
