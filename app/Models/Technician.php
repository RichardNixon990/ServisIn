<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Technician extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $guarded = [];

public function user(){
    return $this->belongsTo(User::class, 'user_id');
}

        public function orders(){
        return $this->hasMany(Order::class, 'technician_id');
    }

    public function ratings(){
        return $this->hasMany(Rating::class, 'technician_id');
    }
}
