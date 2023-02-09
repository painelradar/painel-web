<?php

use App\Http\Controllers\AttendantController;
use App\Http\Controllers\GamepadController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UserController;
use App\Http\Livewire\ActionService;
use App\Http\Livewire\ClientNumbers;
use App\Http\Livewire\PrintNumbers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('usuario/registrar/{name}', [AttendantController::class, 'register'])->name('user.register');
Route::post('registrar/{id}', [AttendantController::class, 'store'])->name('user.store');
Route::get('usuario/entrar', [AttendantController::class, 'login'])->name('user.login');
Route::post('entrar', [AttendantController::class, 'auth'])->name('user.auth');

Route::get('painel/registrar', [UserController::class, 'register'])->name('panel.register');
Route::post('painel/registrar', [UserController::class, 'store'])->name('panel.store');
Route::post('painel/entrar', [UserController::class, 'auth'])->name('panel.auth');
Route::get('painel/entrar', [UserController::class, 'login'])->name('panel.login');
Route::get('resetar-contador', [PanelController::class, 'resetNumbers'])->name('panel.resetNumbers');

Route::middleware(['admin'])->group(function () {
    Route::get('alterar-senha/{email}', [AttendantController::class, 'viewReset'])->name('attendant.reset');
    Route::post('alterar-senha/{email}', [AttendantController::class, 'resetPassword'])->name('attendant.reset');
    Route::get('usuario/deletar/{email}', [AttendantController::class, 'delete'])->name('attendant.delete');
    Route::get('limpar', [PanelController::class, 'deleteNumbers']);
    Route::get('senhas', PrintNumbers::class)->name('print.numbers');
    Route::get('relatorio', [ReportsController::class, 'index'])->name('reports.index');
    Route::get('relatorio/gerar', [ReportsController::class, 'generateReport'])->name('reports.generate');


    Route::get('painel/chamar/{ids}', [PanelController::class, 'numberToCall'])->name('panel.numberToCall');
    Route::get('painel/imprimir/{id}', [PanelController::class, 'panelPrint'])->name('panel.print');

    Route::get('gamepads', [GamepadController::class, 'index'])->name('gamepad.index');
    Route::post('gamepads/criar', [GamepadController::class, 'createButton'])->name('gamepad.create');
    Route::delete('gamepads/deletar/{id}', [GamepadController::class, 'delete'])->name('gamepad.delete');

    Route::get('senhas', PrintNumbers::class)->name('print.numbers');

    Route::get('painel/{ids}', function () {
        return view('number.panel');
    })->name('panel');
    Route::get('painel/gamepad/{ids}', function () {
        $gamepads = Auth::guard('web')->user()->gamepads->sortBy('button');
        return view('number.panelWithPrinter', compact('gamepads'));
    });
    Route::get('limpa-senhas', [PanelController::class, 'deleteNumbers'])->name('panel.deleteNumbers');
});
Route::middleware(['attendant'])->group(function () {

    Route::get('cliente', ClientNumbers::class)->name('client.home');
    Route::get('cliente/acoes/{id}', ActionService::class)->name('number.actions');
    Route::get('usuario/atualizar/{id}', [AttendantController::class, 'edit'])->name('user.edit');
    Route::post('atualizar/{id}', [AttendantController::class, 'update'])->name('user.update');
    Route::get('usuario/sair', [AttendantController::class, 'logout'])->name('user.logout');
});
