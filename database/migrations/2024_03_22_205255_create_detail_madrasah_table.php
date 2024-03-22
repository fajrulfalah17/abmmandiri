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
        Schema::create('detail_madrasah', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('madrasah_id');

            $table->string('kamad')->nullable();
            $table->string('nip')->nullable();
            $table->string('telepon_kamad')->nullable();

            $table->string('op_satu')->nullable();
            $table->string('telepon_op_satu')->nullable();
            $table->string('op_dua')->nullable();
            $table->string('telepon_op_dua')->nullable();
            $table->string('teknisi')->nullable();
            $table->string('telepon_teknisi')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_madrasah');
    }
};
