<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentService extends Model
{
    use HasFactory;

    protected $table = 'appointment_service';

    protected $fillable = [
        'appointment_id',
        'service_id',
        'quantity',
    ];

    public function appointment() {
        return $this->belongsTo(Appointment::class);
    }

    public function service() {
        return $this->belongsTo(Service::class);
    }
}
