<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\Appointment;

class NewAppointmentCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $appointment;

    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    public function broadcastOn()
    {
        return new Channel('appointments');
    }

    public function broadcastAs()
    {
        return 'nueva-cita';
    }

    public function broadcastWith()
    {
        return [
            'appointment' => [
                'appointment_id' => $this->appointment->appointment_id,
                'start_date' => $this->appointment->start_date,
                'time' => $this->appointment->time,
                'timeEnd' => $this->appointment->timeEnd,
                'status' => $this->appointment->status,
                'user' => [
                    'id' => $this->appointment->user->id,
                    'name' => $this->appointment->user->name, //asegura que el nombre del usuario se incluya
                ],
                'services' => $this->appointment->services->map(function ($service) {
                    return ['id' => $service->service_id, 'name' => $service->name];
                })
            ]
        ];
    }
}
