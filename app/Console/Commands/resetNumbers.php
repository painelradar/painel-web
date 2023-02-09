<?php

namespace App\Console\Commands;

use App\Models\Number;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class resetNumbers extends Command
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
    protected $description = 'Reseta o contador de senhas.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        DB::table('attendants')->update(['in_atend' => false]);
        DB::table('attendants')->update(['number_id' => null]);
        $numbers = Number::all();
        foreach ($numbers as $number) {
            $number->delete();
        }
    }
}
