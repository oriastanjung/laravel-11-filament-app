<?php

namespace App\Filament\Widgets;

use App\Models\Task;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StatsAdminOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $stats = [
            Stat::make('Tasks', Task::count()),
        ];

        // Fetch and calculate the total benefit
        $benefit = $this->calculateTotalBenefit();
        $benefitPreview = 'Rp ' . number_format($benefit, 0, ',', '.') . ',-';
        // Only add the "Users" and "Benefit" stats if the user is an admin
        if (Auth::check() && Auth::user()->role === User::ROLE_ADMIN) {
            $stats[] = Stat::make('Users', User::count());
            $stats[] = Stat::make('Benefit', $benefitPreview);
        }

        return $stats;
    }

    private function calculateTotalBenefit(): float
    {
        // Replace with actual query to fetch and calculate the total benefit
        // For example, if you have a 'tasks' table with a 'price' column
        // you can use something like this:

        // Assuming Task model has a 'price' column
        $total_price = Task::sum('price');
        $total_modal = Task::sum('modal');
        return $total_price-$total_modal; // Adjust this as per your actual model and column
    }
}
