<?php

use App\Http\Controllers\PanelController;
use App\Http\Controllers\PanelUserController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UserController;
use App\Http\Livewire\ActionService;
use App\Http\Livewire\ClientNumbers;
use App\Http\Livewire\GamepadButtons;
use App\Http\Livewire\PrintNumbers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;




Route::get('usuario/registrar', [UserController::class, 'register'])->name('user.register');
Route::post('registrar', [UserController::class, 'store'])->name('user.store');
Route::get('usuario/entrar', [UserController::class, 'login'])->name('user.login');
Route::post('entrar', [UserController::class, 'auth'])->name('user.auth');

Route::get('painel/registrar', [UserController::class, 'registerPanel'])->name('panel.register');
Route::get('painel/entrar', [UserController::class, 'loginPainel'])->name('painel.login');
Route::post('registrar/painel', [UserController::class, 'store'])->name('panel.store');

Route::middleware(['admin', 'auth'])->group(function () {

    Route::get('senhas', PrintNumbers::class)->name('print.numbers');
    Route::get('relatorio', [ReportsController::class, 'index'])->name('reports.index');
    Route::get('relatorio/gerar', [ReportsController::class, 'generateReport'])->name('reports.generate');


    Route::get('painel/chamar/{ids}', [PanelController::class, 'numberToCall'])->name('panel.numberToCall');
    Route::get('painel/imprimir/{id}', [PanelController::class, 'panelPrint'])->name('panel.print');
    Route::get('gamepads', GamepadButtons::class)->name('gamepad.buttons');
    Route::get('senhas', PrintNumbers::class)->name('print.numbers');

    Route::get('painel/{ids}', function () {
    return view('number.panel');
        })->name('panel');
    Route::get('painel/gamepad/{ids}', function () {
        $gamepads = Auth::user()->gamepads->sortBy('button');
        return view('number.panelWithPrinter', compact('gamepads'));
    });
});
Route::middleware(['auth'])->group(function () {

    Route::get('cliente', ClientNumbers::class)->name('client.home');
    Route::get('cliente/acoes/{id}', ActionService::class)->name('number.actions');
    Route::get('usuario/atualizar/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('atualizar/{id}', [UserController::class, 'update'])->name('user.update');
    Route::get('usuario/sair', function () {
        Auth::logout();
        return redirect()->route('user.login');
    })->name('user.logout');
});
