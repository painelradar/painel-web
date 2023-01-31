<?php

namespace App\Http\Controllers;

use App\Models\Number;
use App\Models\Queue;
use App\Models\QueueToCall;

use Illuminate\Support\Facades\Auth;

class PanelController extends Controller
{
    public function panelPrint($id)
    {
        $panel = Auth::guard('web')->user();
        $queue = $panel->queues->where('id', $id)->first();
        $stringNumber = $queue->printNumber();
        return $stringNumber;
    }
    public function numberToCall($ids)
    {
        $ids = explode(',', $ids);

        if (QueueToCall::whereIn('queue_id', $ids)->where('user_id', Auth::guard('web')->id())->count() > 0) {
            $number = QueueToCall::whereIn('queue_id', $ids)->where('user_id', Auth::guard('web')->id())->first();
            QueueToCall::whereIn('queue_id', $ids)->where('user_id', Auth::guard('web')->id())->first()->delete();

            return json_encode($number);
        } else {
            $number = null;
            return json_encode($number);
        }
    }
    public function deleteNumbers()
    {
        Number::all()->each(function ($number) {
            $number->delete();
        });
    }
}
