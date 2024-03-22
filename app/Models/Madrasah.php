<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Madrasah extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'madrasah';

    protected $guarded = [];

    public function users()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function details(){
        return $this->hasOne(DetailMadrasah::class, 'madrasah_id', 'id');
    }

    public function mora(){
        return $this->hasOne(MoraMadrasah::class, 'madrasah_id', 'id');
    }

    public function rdm(){
        return $this->hasOne(RdmMadrasah::class, 'madrasah_id', 'id');
    }
}
