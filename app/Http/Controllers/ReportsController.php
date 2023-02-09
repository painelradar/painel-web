<?php

namespace App\Http\Controllers;

use App\Models\PrintReport;
use App\Models\Queue;
use App\Models\ServiceReport;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }
    public function generateReport(Request $request)
    {
        $datas = $request->all();
        $date_start = DateTime::createFromFormat('Y-m-d', $datas['date_start']);
        $date_end = DateTime::createFromFormat('Y-m-d', $datas['date_end']);
        $user = Auth::guard('web')->user();

        $queues = $user->queues;
        $attendants = $user->attendants;
        $i = 0;
        foreach ($attendants as $attendant) {
            $i++;
            $attendant->name = explode(' ', $attendant->name)[0] . ' ' . explode(' ', $attendant->name)[1];
        }

        $ids_attendandts = $attendants->pluck('id');

        $services = DB::table('service_reports')->whereDate('created_at', '>=', $date_start)->whereDate('created_at', '<=', $date_end);
        $services = $services->whereIn('attendant_id', $ids_attendandts)->get();
        $prints = PrintReport::whereDate('created_at', '>=', $date_start)->whereDate('created_at', '<=', $date_end);
        $prints = $prints->whereIn('user_id', $ids_attendandts)->get();
        if ($services->count() == 0 && $prints->count() == 0) {
            return redirect()->back()->with('error', 'Não há dados para gerar o relatório');
        }
        $queueNumbersCount = array();
        $queueTimeCalls = array();
        $queueCountCalls = array();
        foreach ($queues as $key => $queue) {
            $queueNumbersCount = $queueNumbersCount + array($queue->name => $prints->where('queue', $queue->name)->count());
            $service_queue =  $services->where('queue_id', $queue->id);
            $queue->countCalls = $service_queue->where('action', "CALL")->count();



            if ($queue->countCalls > 0) {
                $reports = $service_queue->where('action', "CALL");
                $sumTime = 0;
                foreach ($reports as $report) {
                    $sumTime += $report->time;
                }
                $queue->averageTime = round($sumTime / $queue->countCalls);
                $temp = array($queue->name => $queue->averageTime);
                $queueTimeCalls = $queueTimeCalls + $temp;
                $temp = array($queue->name => $queue->countCalls);
                $queueCountCalls = $queueCountCalls + $temp;
            } else {
                $temp = array($queue->name => 0);
                $queueTimeCalls = $queueTimeCalls + $temp;
                $temp = array($queue->name => 0);
                $queueCountCalls = $queueCountCalls + $temp;
            }
        }
        $attendantCalls = array();
        $attendantAverage = array();
        foreach ($attendants as $attendant) {
            $reports = $services->where('attendant_id', $attendant->id);
            $attendant->countCalls = $services->where('attendant_id', $attendant->id)->where('action', 'CALL')->count();

            if ($attendant->countCalls > 0) {
                $calls = $services->where('attendant_id', $attendant->id)->where('action', "CALL");
                $concludes = $services->where('attendant_id', $attendant->id)->where('action', "CONCLUDE");
                $media = 0;

                foreach ($concludes as $key => $conclude) {
                    if ($conclude == $concludes->last()) {
                        break;
                    }
                    $time_conclude = new Carbon($conclude->created_at);
                    $time_call = new Carbon($calls[$key + 1]->created_at);
                    $media += $time_conclude->diffInMinutes($time_call);
                }

                $attendant->averageTime = $media / $attendant->countCalls;

                $concludes = $reports->where('action', "CONCLUDE");

                $sumTime = 0;
                foreach ($concludes as $report) {
                    $sumTime += $report->time;
                }
                $attendant->timeService = $sumTime / $attendant->countCalls;
                $temp = array($attendant->name => $attendant->timeService);
                $attendantAverage = $attendantAverage + $temp;
                $temp = array($attendant->name => $attendant->averageTime);
                $attendantCalls = $attendantCalls + $temp;
            } else {
                $temp = array($attendant->name => 0);
                $attendantAverage = $attendantAverage + $temp;
                $temp = array($attendant->name => 0);
                $attendantCalls = $attendantCalls + $temp;
            }
        }


        return view('reports.chart', compact('attendantCalls', 'attendantAverage', 'queueTimeCalls', 'queueCountCalls', 'queueNumbersCount'));
    }
}
