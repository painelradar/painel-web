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
        $queues = $panel->queues->sortBy('name');

        return view('user.register', compact('queues', 'panel'));
    }

    public function login()
    {
        if (Auth::guard('attendant')->check()) {
            return redirect()->route('client.home');
        }
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
        $queues = User::find($attendant->user_id)->queues->sortBy('name');

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
    public function delete($email)
    {
        if (Attendant::where('email', $email)->exists()) {
            $attendant = Attendant::where('email', $email)->first();
            if (Auth::guard('web')->user()->id == $attendant->user_id) {
                foreach ($attendant->queues as $queue) {
                    QueueAttendant::where('attendant_id', $attendant->id)->where('queue_id', $queue->id)->delete();
                }
                $attendant->delete();
                return response()->json(['success' => 'Atendente excluido com sucesso!'], 200);
            }
            return response()->json(['error' => 'Você não tem permissão para excluir esse atendente!'], 403);
        }
        return response()->json(['error' => 'Atendente não encontrado!'], 404);
    }
    public function viewReset($email)
    {
        $attendant = Attendant::where('email', $email)->first();
        return view('user.reset-password', compact('attendant'));
    }

    public function resetPassword(Request $request)
    {
        $messages = [
            'required' => 'Esse campo é obrigatório!',
            'confirmed' => 'As senhas não conferem!',
            'min' => 'A senha deve ter no mínimo :min caracteres!',
        ];
        $request->validate([
            'password' => ['required', Password::min(8), 'confirmed'],
        ], $messages);
        $attendant = Attendant::where('email', $request->email)->first();
        $attendant->password = Hash::make($request->password);
        $attendant->update();
        return response()->json(['success' => 'Senha alterada com sucesso!'], 200);
    }
}
