<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Appointment extends Model
{
    use hasFactory;

    protected $primaryKey = 'appointment_id';
    protected $table = 'appointments';

    protected $fillable = [
        'start_date',
        'finish_date',
        'status',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function service()
    {
        return $this->belongsToMany(Service::class, 'appointment_service', 'appointment_id');
    }



}
