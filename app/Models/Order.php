<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class Order extends Model
{
use SoftDeletes;
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function technician(){
     return $this->belongsTo(Technician::class, 'technician_id')

     ;
    }
    public function payment(){
        return $this->hasOne(Payment::class);
    }

    public function listKerusakan(){
        return $this->hasMany(ListKerusakan::class);
    }

    public function rating(){
        return $this->hasOne(Rating::class, 'order_id');
    }
}
