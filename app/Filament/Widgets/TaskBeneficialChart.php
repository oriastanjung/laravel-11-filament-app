<?php

namespace App\Filament\Widgets;

use App\Models\Task;
use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class TaskBeneficialChart extends ChartWidget
{
    protected static ?string $heading = 'Task Benefits by Month';

    protected function getData(): array
    {
        if (Auth::check() && Auth::user()->role === User::ROLE_ADMIN) {
            // Initialize arrays to hold the labels (months) and data (benefit sums)
            $labels = [];
            $data = [];

            $currentYear = Carbon::now()->year;

            // Generate month labels and initialize data array
            $months = range(1, 12);
            foreach ($months as $month) {
                $labels[] = date('M', mktime(0, 0, 0, $month, 1)); // Month abbreviation (Jan, Feb, etc.)

                // Calculate total benefit for the month
                $totalBenefit = Task::whereYear('updated_at', $currentYear)
                    ->whereMonth('updated_at', $month)
                    ->whereNotNull('price')
                    ->whereNotNull('modal')
                    ->get()
                    ->sum(function ($task) {
                        return $task->price - $task->modal;
                    });

                $data[] = $totalBenefit;
            }

            return [
                'datasets' => [
                    [
                        'label' => 'Total Benefit',
                        'data' => $data,
                    ],
                ],
                'labels' => $labels,
            ];
        }

        // Return empty data if user is not an admin
        return [];
    }

    public static function canView(): bool
    {
        return Auth::check() && Auth::user()->role === User::ROLE_ADMIN;
    }

    // protected static string $color = 'success';

    protected function getType(): string
    {
        return 'line'; // Use 'line' or 'bar' based on your preference
    }
}
