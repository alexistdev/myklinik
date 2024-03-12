<?php
/*
 * Copyright (c) 2024.
 * Develop By: Alexsander Hendra Wijaya
 * Github: https://github.com/alexistdev
 * Phone : 0823-7140-8678
 * Email : Alexistdev@gmail.com
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Antrian extends Model
{
    use SoftDeletes;
    protected $fillable = ["rekam_id","nomor"];

    protected $table = "antrians";

    protected static function booted()
    {
        static::creating(function ($antrian) {
            $antrian->nomor = Antrian::autoGenerateNumber();
        });
    }

    public static function autoGenerateNumber(){
        $antrian = Antrian::where('created_at', '>=', Carbon::today())->orderBy('id','desc')->first();
        $nomor = 1;
        if($antrian != null){
            $nomor += $antrian->nomor;
        }
        return $nomor;
    }
}
