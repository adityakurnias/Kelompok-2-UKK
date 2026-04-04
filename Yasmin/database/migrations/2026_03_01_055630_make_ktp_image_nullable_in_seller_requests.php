<?php
// database/migrations/xxxx_make_ktp_image_nullable_in_seller_requests.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('seller_requests', function (Blueprint $table) {
            $table->string('ktp_image')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('seller_requests', function (Blueprint $table) {
            $table->string('ktp_image')->nullable(false)->change();
        });
    }
};