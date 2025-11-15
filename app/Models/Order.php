<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function technician(){
        return $this->belongsTo(technician::class, 'technician_id');
    }
    public function rating(){
        return $this->hasOne(Rating::class, 'order_id');
    }
    public function payment(){
        return $this->hasMany(Payment::class);
    }
}
