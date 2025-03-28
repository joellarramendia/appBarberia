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
        $selectedYear = $request->input('year', Carbon::now()->year);
        $selectedMonth = null; // Inicializar $selectedMonth como null

        if ($request->has('month')) {
            // Reporte Mensual
            $selectedMonth = $request->input('month');
            $startDate = Carbon::create($selectedYear, $selectedMonth, 1)->startOfMonth();
            $endDate = Carbon::create($selectedYear, $selectedMonth, 1)->endOfMonth();
        } else {
            // Reporte Anual
            $startDate = Carbon::create($selectedYear, 1, 1)->startOfYear();
            $endDate = Carbon::create($selectedYear, 12, 31)->endOfYear();
        }

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

        $newClients = User::whereBetween('created_at', [$startDate, $endDate])
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
            'selectedMonth', // $selectedMonth siempre estará definido (puede ser null)
            'selectedYear'
        ));
    }

}
