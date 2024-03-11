<?php
/*
 * Copyright (c) 2024.
 * Develop By: Alexsander Hendra Wijaya
 * Github: https://github.com/alexistdev
 * Phone : 0823-7140-8678
 * Email : Alexistdev@gmail.com
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rekam extends Model
{
    use SoftDeletes;

    protected $table = "rekams";

    protected $fillable = ['dokter_id','kode_rekam',
        'tekanan_darah','rate','suhu_badan',
        'berat_badan','tinggi_badan','keluhan_utama',
        'diagnosis','deskripsi_tindakan','created_by','status'];
}
