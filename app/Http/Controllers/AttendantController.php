<?php

namespace App\Http\Controllers;

use App\Models\Attendant;
use App\Models\Queue;
use App\Models\QueueAttendant;
use App\Models\QueueUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AttendantController extends Controller
{
    public function register($name)
    {
        $panel = User::where('name', $name)->first();
        $queues = $panel->queues;
        return view('user.register', compact('queues', 'panel'));
    }

    public function login()
    {
        return view('user.login');
    }
    public function auth(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('attendant')->attempt($credentials)) {
            Auth::shouldUse('attendant');
            return redirect()->route('client.home');
        }
        return back()->withErrors([
            'email' => 'Email ou senha incorretos!',
        ])->onlyInput('email');
    }
    public function edit($id)
    {
        $attendant = Attendant::find($id);
        $queues = $attendant->queues->sortBy('name');

        return view('user.edit', compact('attendant', 'queues'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'queues_array' => ['required', 'array'],
            'table_number' => ['required', 'string', 'max:2'],
        ]);
        $attendant = Attendant::find($id);
        if (intval($request->table_number) < 10) {
            $request->table_number = sprintf("%02s", $request->table_number);
        }
        $attendant->table_number = $request->table_number;
        $attendant->update();
        $attendant->queues()->sync($request->queues_array, $attendant->id);

        return redirect()->route('client.home');
    }
    public function store(Request $request, $id)
    {

        $messages = [
            'required' => 'Esse campo é obrigatório!',
            'unique' => 'Esse email já está cadastrado no sistema!',
            'confirmed' => 'As senhas não conferem!',
            'min' => 'A senha deve ter no mínimo :min caracteres!',
            'max' => 'O nome deve ter no máximo :max caracteres!',
        ];
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:attendants'],
            'password' => ['required', Password::min(8), 'confirmed'],
            'table_number' => ['required', 'string', 'max:2'],
            'queues_array' => ['required', 'array'],
        ], $messages);

        if (intval($request->table_number) < 10) {
            $request['table_number'] = sprintf("%02s", $request->table_number);
        }
        $panel = User::find($id);
        $attendant = Attendant::create([
            'name' => $request->name,
            'email' => $request->email,
            'table_number' => $request->table_number,
            'password' => Hash::make($request->password),
            'user_id' => $panel->id,
        ]);

        foreach ($request->queues_array as $id) {
            QueueAttendant::create([
                'attendant_id' => $attendant->id,
                'queue_id' => $id,
            ]);
        }
        if (Auth::guard('attendant')->attempt($request->only('email', 'password'))) {
            Auth::shouldUse('attendant');
            return redirect()->route('client.home');
        }

        return redirect()->route('client.home');
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('user.login');
    }
}
