<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class QueueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('queues')->insert([
            'name' => 'CAIXA',
            'id' => 1,
            'minNum' => 1,
            'maxNum' => 300,
            'initial' => 'CX',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),

        ]);
        DB::table('queues')->insert([
            'name' => 'CAIXA PREFERENCIAL',
            'id' => 3,
            'minNum' => 301,
            'maxNum' => 400,
            'initial' => 'CP',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('queues')->insert([
            'name' => 'CAIXA MAIS DE 80 ANOS',
            'id' => 5,
            'minNum' => 401,
            'maxNum' => 500,
            'initial' =>  'CM',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('queues')->insert([
            'name' => 'ATENDIMENTO',
            'id' => 2,
            'minNum' => 501,
            'maxNum' => 800,
            'initial' => 'AT',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('queues')->insert([
            'name' => 'ATENDIMENTO PREFERENCIAL',
            'id' => 4,
            'minNum' => 801,
            'maxNum' => 900,
            'initial' =>  'AP',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('queues')->insert([
            'name' => 'ATENDIMENTO MAIS DE 80 ANOS',
            'id' => 6,
            'minNum' => 901,
            'maxNum' => 999,
            'initial' => 'AM',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
