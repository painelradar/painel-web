<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use App\Models\QueueUser;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{

    public function register()
    {
        $queues = Queue::orderBy('name')->get();
        return view('panel.register', compact('queues'));
    }
    public function login()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('print.numbers');
        }
        return view('panel.login');
    }
    public function store(Request $request)
    {
        $messages = [
            'required' => 'Esse campo é obrigatório!',
            'confirmed' => 'As senhas não conferem!',
            'min' => 'A senha deve ter no mínimo :min caracteres!',
            'max' => 'O nome deve ter no máximo :max caracteres!',
        ];

        $request->validate([
            'name' => ['required', 'string', 'unique:users', 'max:255'],
            'password' => ['required', Password::min(8), 'confirmed'],
        ], $messages);
        $user = User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'admin' => $request->remember,
        ]);
        foreach ($request->queues_array as $id) {
            QueueUser::create([
                'user_id' => $user->id,
                'queue_id' => $id,
            ]);
        }

        Auth::guard('web')->login($user, $request->remember);
        return redirect()->route('print.numbers');
    }

    public function auth(Request $request)
    {
        if ($request->remember) {
            $messages = [
                'required' => 'Esse campo é obrigatório!',
                'confirmed' => 'As senhas não conferem!',
                'min' => ':attribute deve ter no mínimo :min caracteres!',
                'max' => ':attribute deve ter no máximo :max caracteres!',
            ];
            $credentials = $request->validate([
                'name' => ['required', 'string'],
                'password' => ['required'],
            ], $messages);
            if (Auth::guard('web')->attempt($credentials, $request->remember)) {
                $request->session()->regenerate();
                return redirect()->route('print.numbers');
            } else {
                return back()->withErrors([
                    'name' => 'As credenciais fornecidas não existem no sistema.',
                ])->onlyInput('name');
            }
        } else {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (Auth::guard('web')->attempt($credentials)) {
                $request->session()->regenerate();

                return redirect()->intended('cliente');
            }

            return back()->withErrors([
                'email' => 'As credenciais fornecidas não existem no sistema.',
            ])->onlyInput('email');
        }
    }
}
