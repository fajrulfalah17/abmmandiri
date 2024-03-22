<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoraMadrasah extends Model
{
    use HasFactory;

    protected $table = 'mora_madrasah';

    protected $guarded = [];

    public function madrasah()
    {
        return $this->belongsTo(User::class, 'madrasah_id', 'id');
    }
}
