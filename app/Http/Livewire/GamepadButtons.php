<?php

namespace App\Http\Livewire;

use App\Models\Gamepad;
use App\Models\Queue;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class GamepadButtons extends Component
{

    public $queue;
    public $button;
    protected $rules = [
        'button' => 'required',
        'queue' => 'required|integer',
    ];

    public function createButton(){
        $queue = Queue::find($this->queue);
        $gamepad = Gamepad::where('user_id', Auth::id())->where('queue_id', $this->queue)->first();
        $button = Gamepad::where('user_id', Auth::id())->where('button', $this->button)->first();
        if($gamepad){
            session()->flash('message', 'Essa fila já está cadastrada em outro botão');
        }
        else if($button){
            session()->flash('message', 'Esse botão já está vinculado em outra fila');
        }
        else{
            $gamepad = new Gamepad();
            $gamepad->button = $this->button;
            $gamepad->user_id = Auth::id();
            $gamepad->queue_id = $queue->id;
            $gamepad->save();
        }

    }
    public function delete(Gamepad $gamepad){
        $gamepad->delete();
    }
    public function render()
    {
        $queues = Auth::user()->queues->sortBy('name');
        $gamepads = Auth::user()->gamepads->sortBy('button');
        return view('livewire.gamepad-buttons', compact('queues', 'gamepads'))->layout('layouts.gamepad-buttons');
    }
}
