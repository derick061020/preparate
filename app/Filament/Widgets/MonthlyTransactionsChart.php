<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Carbon\Carbon;
use App\Models\Transaccion;

class MonthlyTransactionsChart extends ChartWidget
{
    protected static ?string $heading = 'Ganancias por Mes';

    protected function getData(): array
    {
        $currentYear = Carbon::now()->year;
        
        // Inicializar datos
        $data = [
            'datasets' => [
                [
                    'label' => 'Ganancias por Mes',
                    'data' => [],
                    'backgroundColor' => '#3b82f6', // Azul de Tailwind
                    'borderColor' => '#3b82f6',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => [],
        ];

        // Calcular ganancias por cada mes del año
        for ($month = 1; $month <= 12; $month++) {
            $ganancias = Transaccion::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->where('estado', 'completado')
                ->sum('monto');

            $data['labels'][] = Carbon::create($currentYear, $month, 1)->format('F');
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
                    'text' => 'Ganancias por Mes - ' . Carbon::now()->format('Y'),
                ],
            ],
            
        ];
    }
}
