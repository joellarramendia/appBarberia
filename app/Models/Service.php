<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $primaryKey = 'service_id';
    protected $table = 'services';

    protected $fillable = [
        'name',
        'description',
        'price',
        'duration',
    ];

    public function appointments()
    {
        return $this->belongsToMany(Appointment::class, 'service_id', 'appointment_id');
    }

}
