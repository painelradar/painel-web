<?php

namespace App\Http\Livewire;

use App\Models\Attendant;
use App\Models\Number;
use App\Models\Queue;
use App\Models\QueueToCall;
use App\Models\ServiceReport;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ClientNumbers extends Component
{


    public function callNext(Queue $queue)
    {
        $panel = Auth::user()->user;

        if ($panel->numbers()->where('status', 'WAITING')->count() > 0) {

            $number = Number::where('queue_id', $queue->id)
                ->where('status', 'WAITING')
                ->where('user_id', Auth::user()->user_id)->first();
            if (!$number) {
                return redirect()->back();
            }
            if ($number->status == "IN_SERVICE") {
                return redirect()->back();
            }
            $number->status =  "IN_SERVICE";
            $updated = new Carbon($number->updated_at);
            $minutes = $updated->diffInMinutes(Carbon::now());
            $serviceReport = new ServiceReport();
            $serviceReport->newServiceReport($queue, $number, $minutes, 'CALL');
            $queueToCall = new QueueToCall();
            $queueToCall->newNumberToCall($number);
            $number->update();
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
        $serviceReport = new ServiceReport();
        $serviceReport->newServiceReport($number->queue, $number, $minutes, 'CALL');
        $queueToCall = new QueueToCall();
        $queueToCall->newNumberToCall($number);
        $number->update();
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
        $absents = Number::whereIn('queue_id', $queues->pluck('id'))
            ->where('status', 'ABSENT')
            ->where('user_id', Auth::user()->user_id)
            ->orderBy('id', 'desc')
            ->take(5)->get();

        $numbers = Number::whereIn('queue_id', $queues->pluck('id'))
            ->where('status', 'WAITING')
            ->where('user_id', Auth::user()->user_id)
            ->orderBy('updated_at', 'asc')->get();
        return view('livewire.client-numbers', compact('queues', 'numbers', 'absents'))->layout('layouts.client-numbers');
    }
}
