<?php

namespace App\Http\Livewire;

use App\Models\Number;
use App\Models\PrintReport;
use App\Models\Queue;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PrintNumbers extends Component
{
    public function refresh()
    {
        $this->render();
    }

    public function render()
    {
        $queues = Auth::guard('web')->user()->queues->sortBy('id');
        return view('livewire.print-numbers', compact('queues'))->layout('layouts.print-numbers');
    }
}
