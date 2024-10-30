<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Muestra el panel de administración.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Aquí podrías agregar lógica para obtener estadísticas o datos relevantes
        // Ejemplo: $totalSales = Order::sum('total'); // Suponiendo que tienes un modelo Order

        return view('admin.dashboard', [
            // Pasa datos a la vista si es necesario
            // 'totalSales' => $totalSales,
        ]);
    }
}
