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
        $updated = new Carbon($number->updated_at);
        $minutes = $updated->diffInMinutes(Carbon::now());
        $serviceReport = new ServiceReport();
        $serviceReport->newServiceReport($queue, $number, $minutes,  'ROUTE');
        $number->queue_id = $queue->id;
        $number->update();
        $attendant = Auth::user();
        $attendant->in_atend = false;
        $attendant->number_id = null;
        $attendant->save();
        return redirect()->route('client.home');
    }
    public function absent(Number $number)
    {
        $updated = new Carbon($number->updated_at);
        $minutes = $updated->diffInMinutes(Carbon::now());
        $serviceReport = new ServiceReport();
        $serviceReport->newServiceReport($number->queue, $number, $minutes, 'ABSENT');
        $number->status = "ABSENT";
        $number->update();
        $attendant = Auth::user();
        $attendant->in_atend = false;
        $attendant->number_id = null;
        $attendant->save();
        return redirect()->route('client.home');
    }
    public function conclude(Number $number)
    {
        $updated = new Carbon($number->updated_at);
        $minutes = $updated->diffInMinutes(Carbon::now());
        $serviceReport = new ServiceReport();
        $serviceReport->newServiceReport($number->queue, $number, $minutes, 'CONCLUDE');
        $number->status = "FINISHED";
        $number->update();
        $attendant = Auth::user();
        $attendant->in_atend = false;
        $attendant->number_id = null;
        $attendant->save();
        return redirect()->route('client.home');
    }
    public function mount($id)
    {
        $this->number = Number::find($id);
    }
    public function repeat(Number $number)
    {
        if (QueueToCall::where('stringNumber', $number->stringNumber)->where('user_id', Auth::user()->user_id)->count() == 0) {
            $number->status =  "IN_SERVICE";
            $updated = new Carbon($number->updated_at);
            $minutes = $updated->diffInMinutes(Carbon::now());
            $serviceReport = new ServiceReport();
            $serviceReport->newServiceReport($number->queue, $number, $minutes, 'REPEAT');
            $number->update();
            $queueToCall = new QueueToCall();
            $queueToCall->newNumberToCall($number);
        }
    }

    public function verifyAction()
    {
        return redirect()->route('client.home');
    }
    public function render()
    {
        if (Auth::user()->in_atend == 0) {
            $this->verifyAction();
        }
        $user = Auth::user()->user;
        $queues = $user->queues->sortBy('name');
        $number = $this->number;
        return view('livewire.action-service', compact('queues', 'number'))->layout('layouts.action-service');;
    }
}
