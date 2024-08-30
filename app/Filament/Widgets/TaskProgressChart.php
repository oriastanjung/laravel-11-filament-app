<?php

namespace App\Filament\Widgets;

use App\Models\Task;
use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class TaskProgressChart extends ChartWidget
{
    protected static ?string $heading = 'Task Progress by Month';

    protected function getData(): array
    {
        if (Auth::check() && Auth::user()->role === User::ROLE_ADMIN) {
            // Initialize arrays to hold the labels (months) and data (task counts)
            $labels = [];
            $data = [];

            // Get the current year
            $currentYear = Carbon::now()->year;

            // Generate month labels and initialize data array
            $months = range(1, 12);
            foreach ($months as $month) {
                $labels[] = date('M', mktime(0, 0, 0, $month, 1)); // Month abbreviation (Jan, Feb, etc.)
                $data[] = Task::whereYear('updated_at', $currentYear)
                            ->whereMonth('updated_at', $month)
                            ->count();
            }

            return [
                'datasets' => [
                    [
                        'label' => 'Tasks Count',
                        'data' => $data,
                    ],
                ],
                'labels' => $labels,
            ];
        }

        return [];
    }

    public static function canView(): bool
    {
        return Auth::check() && Auth::user()->role === User::ROLE_ADMIN;
    }

    protected static string $color = 'success';

    protected function getType(): string
    {
        return 'line'; // Use 'bar' for a bar chart to show counts more clearly
    }
}
