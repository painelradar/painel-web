<?php

namespace App\Http\Controllers;

use App\Models\Number;
use App\Models\PrintReport;
use App\Models\Queue;
use App\Models\ServiceReport;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }
    public function generateReport(Request $request)
    {
        $service_query = PrintReport::query();
        $datas = $request->all();

        $date_start = DateTime::createFromFormat('Y-m-d', $datas['date_start']);
        $date_end = DateTime::createFromFormat('Y-m-d', $datas['date_end']);

        // Filters reports based on received dates
        if ($date_start && $date_end) {
            $service_query->whereDate('created_at', '>=', $date_start);
            $service_query->whereDate('created_at', '<=', $date_end);
        }

        // Returns only reports for the dates specified in the form
        $queue_query = Queue::query();

        if ($date_start && $date_end) {
            $queue_query->whereDate('created_at', '>=', $date_start);
            $queue_query->whereDate('created_at', '<=', $date_end);
        }
        $queues = $queue_query->get();
        $queueNumbersCount = array();
        $queueTimeCalls = array();
        $queueCountCalls = array();
        foreach ($queues as $queue) {
            $temp = array($queue->name => $service_query->where('queue', $queue->name)->count());
            $queueNumbersCount = $queueNumbersCount + $temp;
            $queue->countCalls =
                ServiceReport::where('queue', $queue->name)->where('action', "CALL")
                ->whereDate('created_at', '>=', $date_start)
                ->whereDate('created_at', '<=', $date_end)->count();

            if ($queue->countCalls > 0) {
                $reports = ServiceReport::where('queue', $queue->name)->where('action', "CALL")
                    ->whereDate('created_at', '>=', $date_start)
                    ->whereDate('created_at', '<=', $date_end)->get();
                $sumTime = 0;
                foreach ($reports as $report) {
                    $sumTime += $report->time;
                }
                $queue->averageTime = $sumTime / $queue->countCalls;
                $temp = array($queue->name => $queue->countCalls);
                $queueCountCalls = $queueCountCalls + $temp;
                $temp = array($queue->name => $queue->averageTime);
                $queueTimeCalls = $queueTimeCalls + $temp;
            } else {
                $temp = array($queue->name => 0);
                $queueCountCalls = $queueCountCalls + $temp;
                $queueTimeCalls = $queueTimeCalls + $temp;
            }
        }
        $users = User::all();
        $userCalls = array();
        $userAverage = array();
        foreach ($users as $user) {
            $user->countCalls = ServiceReport::where('attendant', $user->name)->where('action', "CALL")
                ->whereDate('created_at', '>=', $date_start)
                ->whereDate('created_at', '<=', $date_end)->count();
            if ($user->countCalls > 0) {
                $reports = ServiceReport::where('attendant', $user->name)
                    ->where('action', "CALL")
                    ->whereDate('created_at', '>=', $date_start)
                    ->whereDate('created_at', '<=', $date_end)
                    ->get();
                $sumTime = 0;
                foreach ($reports as $report) {
                    $sumTime += $report->time;
                }
                $user->averageTime = round($sumTime / $user->countCalls);
                $reports = ServiceReport::where('attendant', $user->name)
                    ->where('action', "CONCLUDE")
                    ->whereDate('created_at', '>=', $date_start)
                    ->whereDate('created_at', '<=', $date_end)
                    ->get();
                $sumTime = 0;
                foreach ($reports as $report) {
                    $sumTime += $report->time;
                }
                $user->timeService = $sumTime / $user->countCalls;
                $temp = array($user->name => $user->timeService);
                $userAverage = $userAverage + $temp;
                $temp = array($user->name => $user->averageTime);
                $userCalls = $userCalls + $temp;
            } else {
                $temp = array($user->name => 0);
                $userAverage = $userAverage + $temp;
                $temp = array($user->name => 0);
                $userCalls = $userCalls + $temp;
            }
        }
        return view('reports.chart', compact('userCalls', 'userAverage', 'queueTimeCalls', 'queueCountCalls', 'queueNumbersCount'));
    }
}
