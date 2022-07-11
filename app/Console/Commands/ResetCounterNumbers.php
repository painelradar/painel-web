<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetCounterNumbers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:numbers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset counter number';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::table('users')->update(['in_atend' => false]);
        DB::table('users')->update(['number_id' => null]);
        DB::table('numbers')->delete();
    }
}
