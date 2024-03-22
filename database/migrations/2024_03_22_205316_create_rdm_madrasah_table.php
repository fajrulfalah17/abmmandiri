<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rdm_madrasah', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('madrasah_id');
            $table->enum('jenis_server_rdm', ['KERTAS', 'LOKAL', 'MANDIRI', 'MAARIF'])->nullable();
            $table->string('user_rdm')->nullable();
            $table->string('password_rdm')->nullable();
            $table->string('link_rdm_mandiri')->nullable();
            $table->string('link_rdm_maarif')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rdm_madrasah');
    }
};
