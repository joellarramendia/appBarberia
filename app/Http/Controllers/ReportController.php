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
        $selectedMonth = $request->input('month', Carbon::now()->month);
        $selectedYear = $request->input('year', Carbon::now()->year);

        // Crea una instancia de Carbon para el primer día del mes seleccionado
        $startDate = Carbon::create($selectedYear, $selectedMonth, 1)->startOfMonth();

        // Crea una instancia de Carbon para el último día del mes seleccionado
        $endDate = Carbon::create($selectedYear, $selectedMonth, 1)->endOfMonth();

        $confirmedAppointments = Appointment::whereBetween('start_date', [$startDate, $endDate])
            ->where('status', 'confirmed')
            ->count();

        $canceledAppointments = Appointment::whereBetween('start_date', [$startDate, $endDate])
            ->where('status', 'canceled')
            ->count();

        $totalRevenue = Appointment::whereBetween('start_date', [$startDate, $endDate])
            ->where('status', 'confirmed')
            ->with('services')
            ->get()
            ->sum(function ($appointment) {
                return $appointment->services->sum('price');
            });

        $newClients = User::whereMonth('created_at', $selectedMonth)
            ->whereYear('created_at', $selectedYear)
            ->count();

        if ($request->ajax()) {
            return view('appointments.report_results', compact(
                'confirmedAppointments',
                'canceledAppointments',
                'totalRevenue',
                'newClients'
            ));
        }

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
