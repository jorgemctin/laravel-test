<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_id',
        'dentist_id',
        'service_id'
        // 'user_id'
    ];
    
    public function User() {
        return $this->belongsTo(User::class);
    }
    public function Service() {
        return $this->belongsTo(Service::class);
    }
}

//Tablas intermedias-$this
//Primero la foreingKey del modelo en el que estoy, luego la foreingKey del otro modelo
