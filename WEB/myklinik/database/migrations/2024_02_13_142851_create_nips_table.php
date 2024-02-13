<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
         * Author: AlexistDev
         * Email: Alexistdev@gmail.com
         * Phone: 082371408678
         * Github: https://github.com/alexistdev
         */

    public function up(): void
    {
        Schema::create('nips', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('alamat');
            $table->string('phone');
            $table->string('sex','1');
            $table->date('tanggal_bergabung');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nips');
    }
};
