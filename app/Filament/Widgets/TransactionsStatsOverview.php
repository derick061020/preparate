<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;
use App\Models\Transaccion;
use App\Models\Llc;
use App\Models\User;

class TransactionsStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    
    protected function getStats(): array
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        
        // Ganancias del año
        $yearlyProfit = Transaccion::whereYear('created_at', $currentYear)
            ->where('estado', 'completado')
            ->sum('monto');
            
        // Ganancias del mes actual
        $monthlyProfit = Transaccion::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->where('estado', 'completado')
            ->sum('monto');
            
        // Calcular proyección para el resto del año
        $averageMonthlyProfit = ($yearlyProfit > 0) ? $yearlyProfit / $currentMonth : $monthlyProfit;
        $remainingMonths = 12 - $currentMonth;
        $projection = $averageMonthlyProfit * $remainingMonths;

        // LLC registrados con estado completado
        $completedLlcs = Llc::whereYear('created_at', $currentYear)
            ->where('estado', 'completado')
            ->count();
            
        // Usuarios nuevos del año
        $newUsers = User::whereYear('created_at', $currentYear)
            ->count();

        // Calcular porcentaje de crecimiento mensual
        $lastMonth = $currentMonth - 1;
        $lastMonthProfit = Transaccion::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $lastMonth)
            ->where('estado', 'completado')
            ->sum('monto');
            
        $growthPercentage = ($monthlyProfit > 0 && $lastMonthProfit > 0) 
            ? (($monthlyProfit - $lastMonthProfit) / $lastMonthProfit) * 100
            : 0;

        return [
            Stat::make('Ganancias del año', '$' . number_format($yearlyProfit, 2))
                ->description('Este mes: $' . number_format($monthlyProfit, 2) . ' | Proyección: $' . number_format($projection, 2))
                ->descriptionIcon('heroicon-o-arrow-trending-up')
                ->color('success'),
            
            Stat::make('LLC registrados', $completedLlcs)
                ->description('Estado completado')
                ->color('warning'),
            
            Stat::make('Usuarios nuevos', $newUsers)
                ->description('Año ' . $currentYear)
                ->color('primary'),
            
            //Stat::make('Crecimiento mensual', number_format($growthPercentage, 2) . '%')
            //    ->description('Comparado con el mes anterior')
            //    ->color($growthPercentage >= 0 ? 'success' : 'danger')
            //    ->descriptionIcon($growthPercentage >= 0 ? 'heroicon-o-arrow-trending-up' : 'heroicon-o-arrow-trending-down'),
        ];
    }
}
