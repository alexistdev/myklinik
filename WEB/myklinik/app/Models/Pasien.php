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

class Pasien extends Model
{
    use SoftDeletes;

    protected $table = "pasiens";
    protected $fillable = ['kode_pasien','nama_lengkap','tanggal_lahir','tempat_lahir','sex','agama','pendidikan','phone','gol_darah','pekerjaan','alamat'];
}
