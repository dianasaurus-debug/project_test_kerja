<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function campus()
    {
        return $this->belongsTo('App\Models\Campus', 'campus_id');
    }
    public function rooms(){
        return $this->hasMany(Room::class, 'gedung_id');
    }
}
