<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Carbon\Carbon;
use App\Models\Transaccion;
use App\Models\Plan;

class TransactionsByPlanChart extends ChartWidget
{
    protected static ?string $heading = 'Ganancias por Plan';
    
    public ?string $filter;

    public function __construct()
    {
        $this->filter = (string)Carbon::now()->month;
    }

    protected function getData(): array
    {
        // Obtener todos los planes
        $planes = Plan::all();
        
        // Inicializar datos
        $data = [
            'datasets' => [
                [
                    'label' => 'Ganancias por Plan',
                    'data' => [],
                    'backgroundColor' => '#3b82f6', // Azul de Tailwind
                    'borderColor' => '#3b82f6',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => [],
        ];

        // Usar el filtro activo
        $activeFilter = $this->filter;
        $year = Carbon::now()->year;
        
        // Calcular ganancias por plan para el mes actual
        foreach ($planes as $plan) {
            $ganancias = Transaccion::where('plan_id', $plan->id)
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $activeFilter)
                ->where('estado', 'completado')
                ->sum('monto');

            $data['labels'][] = $plan->nombre;
            $data['datasets'][0]['data'][] = (float)$ganancias;
        }

        return $data;
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'plugins' => [
                'legend' => [
                    'position' => 'top',
                ],
                'title' => [
                    'display' => true,
                    'text' => 'Ganancias por Plan - ' . Carbon::now()->format('F Y'),
                ],
            ],
            
        ];
    }

    protected function getFilters(): array
    {
        $currentYear = Carbon::now()->year;
        $months = [];
        
        for ($month = 1; $month <= 12; $month++) {
            $monthName = Carbon::create($currentYear, $month, 1)->format('F Y');
            $months[$month] = $monthName;
        }
        
        return $months;
    }
}
