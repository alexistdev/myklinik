<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Karyawans extends Model
{
    /**
         * Author: AlexistDev
         * Email: Alexistdev@gmail.com
         * Phone: 082371408678
         * Github: https://github.com/alexistdev
         */

    use SoftDeletes;

    protected $table = "karyawans";

    protected $fillable = ["user_id","nip","alamat","phone","sex","tanggal_bergabung","status"];
}