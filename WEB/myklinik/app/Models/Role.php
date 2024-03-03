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

class Role extends Model
{

    protected $table = "roles";
    protected $guarded = ['name'];

    public function scopeKaryawan($query)
    {
        return $query->where('id', '!=', 1)->where('id', '!=', 2)->where('id', '!=', 6)->where('id', '!=', 4);
    }
}
