<?php

namespace Database\Seeders;

use App\Models\Dokter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DokterSeeder extends Seeder
{
    /**
         * Author: AlexistDev
         * Email: Alexistdev@gmail.com
         * Phone: 082371408678
         * Github: https://github.com/alexistdev
         */

    public function run(): void
    {
        $date = Carbon::now()->format('Y-m-d H:i:s');
        $dokter = [
            [
                "karyawan_id" => 2,
                "poliklinik_id" => 1,
                "no_izin" => "22323232323",
                "created_at" => $date,
                "updated_at" => $date,
            ]
        ];
        Dokter::insert($dokter);
    }
}
