<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Service;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
{
    $selectedMonth = $request->input('month', Carbon::now()->month); // Valor predeterminado: mes actual
    $selectedYear = $request->input('year', Carbon::now()->year); // Valor predeterminado: año actual

    // Cantidad de servicios confirmados y cancelados en el mes
    $confirmedAppointments = Appointment::whereMonth('created_at', $selectedMonth)
                                        ->whereYear('created_at', $selectedYear)
                                        ->where('status', 'confirmed')
                                        ->count();

    $canceledAppointments = Appointment::whereMonth('created_at', $selectedMonth)
                                       ->whereYear('created_at', $selectedYear)
                                       ->where('status', 'canceled')
                                       ->count();

    // Monto total recaudado en el mes (sumando precios de los servicios en citas confirmadas)
    $totalRevenue = Appointment::whereMonth('created_at', $selectedMonth)
                               ->whereYear('created_at', $selectedYear)
                               ->where('status', 'confirmed')
                               ->with('services') // Relación con los servicios
                               ->get()
                               ->sum(function ($appointment) {
                                   return $appointment->services->sum('price'); // Sumar precios de los servicios
                               });

    // Nuevos clientes registrados en el mes
    $newClients = User::whereMonth('created_at', $selectedMonth)
                      ->whereYear('created_at', $selectedYear)
                      ->count();

    return view('appointments.report', compact(
        'confirmedAppointments', 
        'canceledAppointments', 
        'totalRevenue', 
        'newClients',
        'selectedMonth',
        'selectedYear'
    ));
}

}
