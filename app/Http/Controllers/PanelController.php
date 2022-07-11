<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\PrintReport;
use App\Models\Queue;
use App\Models\QueueToCall;

class PanelController extends Controller
{
    public function panelPrint($id)
    {
        $queue = Queue::find($id);
        $stringNumber = $queue->printNumberGamepad(Auth::user()->coop, Auth::user()->pa);
        PrintReport::create([
            'stringNumber' => $stringNumber,
            'queue' => $queue->name
        ]);
        return $stringNumber;
    }
    public function numberToCall($ids)
    {
        $ids = explode(',', $ids);

        if (QueueToCall::whereIn('queue_id', $ids)->count() > 0) {

            $number = QueueToCall::whereIn('queue_id', $ids)->first();
            QueueToCall::whereIn('queue_id', $ids)->first()->delete();

            return json_encode($number);
        } else {
            $number = null;
            return json_encode($number);
        }
    }
}
