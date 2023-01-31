<?php

namespace App\Http\Controllers;

use App\Models\Gamepad;
use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GamepadController extends Controller
{
    public function index()
    {
        $queues = Auth::user()->queues->sortBy('name');
        $gamepads = Auth::user()->gamepads;
        return view('panel.gamepad', compact('queues', 'gamepads'));
    }
    public function createButton(Request $request)
    {

        $queue = Queue::find($request->queue);
        $gamepad = Gamepad::where('user_id', Auth::id())->where('queue_id', $request->queue)->first();
        $button = Gamepad::where('user_id', Auth::id())->where('button', $request->button)->first();
        if (!$request->button) {
            session()->flash('message', 'O botão não pode ser vazio!');
        } else if ($gamepad) {
            if ($gamepad->button == $request->button) {
                session()->flash('message', 'Esse botão já está vinculado a essa fila');
            } else {
                session()->flash('message', 'Essa fila já está cadastrada em outro botão');
            }
        } else if ($button) {
            session()->flash('message', 'Esse botão já está vinculado em outra fila');
        } else {
            $gamepad = new Gamepad();
            $gamepad->button = $request->button;
            $gamepad->user_id = Auth::id();
            $gamepad->queue_id = $queue->id;
            $gamepad->save();
        }
        return redirect()->route('gamepad.index');
    }

    public function delete($id)
    {
        $gamepad = Gamepad::find($id);
        $gamepad->delete();
        return redirect()->route('gamepad.index');
    }
}
