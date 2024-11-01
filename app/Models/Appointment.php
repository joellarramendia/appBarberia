<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Appointment extends Model
{
    use hasFactory;

    protected $table = 'appointments';

    protected $fillable = [
        'user_id',
        'date',
        'time',
        'status',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function service() {
        return $this->belongsToMany(Service::class, 'appointment_service')->withPivot('quantity');
    }
}
