<?php
/*
 * Copyright (c) 2024.
 * Develop By: Alexsander Hendra Wijaya
 * Github: https://github.com/alexistdev
 * Phone : 0823-7140-8678
 * Email : Alexistdev@gmail.com
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $this->call([
            ProdusenSeeder::class,
            PoliklinikSeeder::class,
            RoleSeeder::class,
            KategoriObatSeeder::class,
            GolonganObatSeeder::class,
            UserSeeder::class,
            KaryawansSeeder::class,
            DokterSeeder::class,
        ]);
    }
}
