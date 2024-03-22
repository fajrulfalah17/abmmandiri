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
        Schema::create('mora_madrasah', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('madrasah_id');
            $table->enum('pas_tujuh_delapan_sembilan', ['KERTAS', 'LOKAL', 'MANDIRI', 'MAARIF'])->nullable();
            $table->enum('pat_sembilan', ['KERTAS', 'LOKAL', 'MANDIRI', 'MAARIF'])->nullable();
            $table->enum('am_sembilan', ['KERTAS', 'LOKAL', 'MANDIRI', 'MAARIF'])->nullable();
            $table->enum('pat_tujuh_delapan', ['KERTAS', 'LOKAL', 'MANDIRI', 'MAARIF'])->nullable();

            $table->string('user_cbt')->nullable();
            $table->string('password_cbt')->nullable();
            $table->string('link_hosting_mandiri')->nullable();
            $table->string('link_hosting_maarif')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mora_madrasah');
    }
};
