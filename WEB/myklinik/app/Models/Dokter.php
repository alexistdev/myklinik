<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dokter extends Model
{
    /**
         * Author: AlexistDev
         * Email: Alexistdev@gmail.com
         * Phone: 082371408678
         * Github: https://github.com/alexistdev
         */
    use SoftDeletes;

    protected $table = "dokters";

    protected $fillable = ["karyawan_id","poliklinik_id","no_izin"];

    public function poli()
    {
        return $this->belongsTo(Poliklinik::class,'poliklinik_id','id');
    }
}
