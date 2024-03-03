<?php
/*
 * Copyright (c) 2024.
 * Develop By: Alexsander Hendra Wijaya
 * Github: https://github.com/alexistdev
 * Phone : 0823-7140-8678
 * Email : Alexistdev@gmail.com
 */

namespace Database\Seeders;

use App\Models\Poliklinik;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PoliklinikSeeder extends Seeder
{

    public function run(): void
    {
        $result = [];
        $temp1 = ["Dokter UMUM", "Spesialist THT", "Dokter ANAK"];
        $date = Carbon::now()->format('Y-m-d H:i:s');
        for ($i = 0; $i < count($temp1); $i++) {
            $temp2 = ['name' => $temp1[$i],'created_at' => $date,'updated_at' => $date];
            array_push($result, $temp2);
        }
        Poliklinik::insert($result);
    }
}
