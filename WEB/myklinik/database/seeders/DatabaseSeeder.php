<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
         * Author: AlexistDev
         * Email: Alexistdev@gmail.com
         * Phone: 082371408678
         * Github: https://github.com/alexistdev
         */

    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            KategoriObatSeeder::class,
            GolonganObatSeeder::class,
            UserSeeder::class,
            KaryawansSeeder::class,
            PoliklinikSeeder::class,
            DokterSeeder::class,
        ]);
    }
}
