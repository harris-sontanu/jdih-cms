<?php

namespace Database\Seeders;

use App\Models\LegislationDownloadLog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LegislationDownloadLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LegislationDownloadLog::factory()->count(50)->create([
            'ipv4'  => DB::raw('INET_ATON("'.fake()->ipv4().'")'),
        ]);
    }
}
