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
        return view('user.register', compact('queues'));
    }
    public function registerPanel()
    {
        $queues = Queue::orderBy('name')->get();
        return view('panel.register', compact('queues'));
    }

    public function login()
    {
        return view('user.login');
    }
    public function loginPainel()
    {
        return view('panel.login');
    }
    public function edit($id)
    {
        $user = User::find($id);
        $queues = Queue::get();

        return view('user.edit', compact('user', 'queues'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'queues_array' => ['required', 'array'],
            'table_number' => ['required', 'string', 'max:2'],
        ]);
        $user = User::find($id);
        if (intval($request->table_number) < 10) {
            $request->table_number = sprintf("%02s", $request->table_number);
        }
        $user->table_number = $request->table_number;
        $user->update();
        $user->queues()->sync($request->queues_array, $user->id);

        return redirect()->route('client.home');
    }
    public function store(Request $request)
    {

        if($request->remember){
            $request->validate([
                'name' => ['required', 'string', 'unique:users', 'max:255'],
                'password' => ['required', Password::min(8), 'confirmed'],
                'cooperative' => ['required', 'string'],
                'pa' => ['required', 'string'],
            ]);
            $user = User::create([
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'admin' => $request->remember,
                'coop' => $request->cooperative,
                'pa' => $request->pa,
            ]);
            foreach ($request->queues_array as $id) {
                QueueUser::create([
                    'user_id' => $user->id,
                    'queue_id' => $id,
                ]);
            }
            Auth::login($user, $request->remember);
            return redirect()->route('print.numbers');
        }else{
            $messages = [
                'required' => 'Esse campo é obrigatório!',
                'unique' => 'Esse email já está cadastrado no sistema!',
                'confirmed' => 'As senhas não conferem!',
                'min' => 'A senha deve ter no mínimo :min caracteres!',
                'max' => 'O nome deve ter no máximo :max caracteres!',

            ];
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'cooperative' => ['required', 'string', 'max:10'],
                'pa' => ['required', 'string', 'max:10'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', Password::min(8), 'confirmed'],
                'table_number' => ['required', 'string', 'max:2'],
                'queues_array' => ['required', 'array'],
            ], $messages);
            if (intval($request->table_number) < 10) {
                $request->table_number = sprintf("%02s", $request->table_number);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'coop' => $request->cooperative,
                'pa' => $request->pa,
                'table_number' => $request->table_number,
                'password' => Hash::make($request->password),
                'admin' => $request->admin,
            ]);

            foreach ($request->queues_array as $id) {
                QueueUser::create([
                    'user_id' => $user->id,
                    'queue_id' => $id,
                ]);
            }
            Auth::login($user);
            return redirect()->route('client.home');
        }




    }

    public function auth(Request $request)
    {
        if($request->remember){
            $credentials = $request->validate([
                'name' => ['required', 'string'],
                'password' => ['required'],
            ]);
            if (Auth::attempt($credentials, $request->remember)) {
                $request->session()->regenerate();
                return redirect()->route('print.numbers');
            }else{
                return back()->withErrors([
                    'name' => 'As credenciais fornecidas não existem no sistema.',
                ])->onlyInput('name');
            }
        }else{
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                return redirect()->intended('cliente');
            }

            return back()->withErrors([
                'email' => 'As credenciais fornecidas não existem no sistema.',
            ])->onlyInput('email');
        }

    }
}
