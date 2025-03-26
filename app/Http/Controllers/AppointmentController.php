<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Service;
use App\Events\NewAppointmentCreated;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmacionCitaMail;

class AppointmentController extends Controller
{
    public function index(){

        return view('appointments.index');

    }

    public function store(){
        $user = auth()->user(); // Obtiene usuario autenticado
        $appointments = Appointment::with('services', 'user')->get();

        $events = $appointments->map(function ($appointment) use ($user) {
            $isAdmin = $user->hasRole('admin'); // Verifica si el usuario es administrador
            $isOwner = $appointment->user->id == $user->id; // Verifica si la cita pertenece al usuario
            return [
                'id' => $appointment->appointment_id,
                'title' => ($isOwner || $isAdmin) ? $appointment->user->name : 'Reservado',
                'start' => $appointment->start_date . 'T' . $appointment->time ,
                'end' => $appointment->start_date . 'T' . $appointment->timeEnd,
                'status' => $appointment->status,
                'backgroundColor' => $appointment->status === 'confirmed' ? 'green' : 'yellow',
                'borderColor' => $appointment->status === 'confirmed' ? 'darkgreen' : 'orange',
                'textColor' => $appointment->status === 'confirmed' ? 'white' : 'black',
                'extendedProps' => [
                    'client' => $appointment->user->name, // Solo el nombre del cliente
                    'services' => $appointment->services->pluck('name')->join(', '), // Nombres de los servicios
                ]
            ];
        });

        return response()->json($events);
    }

    public function createAppointment(Request $request)
    {
         // Verifica si Laravel está recibiendo correctamente el user_id
         if (!$request->has('user_id')) {
            return response()->json(['error' => 'El ID del usuario no fue recibido.'], 400);
        }

        // Validación
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'timeEnd' => 'required|date_format:H:i',
            'status' => 'required|string',
            'services' => 'required|array',
            'services.*' => 'exists:services,service_id',
        ]);

        // Crea la cita
        $appointment = Appointment::create([
            'user_id' => $request->user_id,
            'start_date' => $request->start_date,
            'time' => $request->time,
            'timeEnd' => $request->timeEnd,
            'status' => $request->status,
        ]);

        // Asigna servicios a la cita
        $appointment->services()->attach($request->services);

        // Emitir evento de nueva cita
        event(new NewAppointmentCreated($appointment));

        return response()->json(['message' => 'Cita agendada con éxito', 'appointment' => $appointment], 201);
    }

    public function destroy($appointment_id){
        $appointment = Appointment::find($appointment_id);

        if (!$appointment) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

        $appointment->delete();

        return response()->json(['message' => 'Cita eliminada correctamente']);
    }



//funcion para ver disponibilidad de horarios    
    public function checkAvailability(Request $request){
        $request->validate([
            'start_date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'timeEnd' => 'required|date_format:H:i|after:time',
        ]);

        $conflict = Appointment::where('start_date', $request->start_date)
            ->where(function ($query) use ($request) {
                $query->whereBetween('time', [$request->time, $request->timeEnd])
                    ->orWhereBetween('timeEnd', [$request->time, $request->timeEnd])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('time', '<=', $request->time)
                            ->where('timeEnd', '>=', $request->timeEnd);
                    });
            })
            ->exists();

        return response()->json(['available' => !$conflict]);
    }

    public function confirmAppointment(Request $request, $id){
        $appointment = Appointment::with('user')->findOrFail($id);

        $appointment->status = 'confirmed';
        $appointment->save();
        
        $user = $appointment->user->name;
        $services = $appointment->services->pluck('name')->join(', ');
        $date = $appointment->start_date;
        $time = $appointment->time;
        $price = $appointment->services->sum('price');

        // Enviar correo de confirmación
        Mail::to($appointment->user->email)->send(new ConfirmacionCitaMail($user, $services, $date, $time, $price));

        return response()->json(['message' => 'Cita confirmada y correo enviado con éxito.']);
    }

}


