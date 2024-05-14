<?php

namespace App\Filament\Widgets;

use App\Models\Deposite;
use App\Models\District;
use App\Models\Expense;
use App\Models\PaymentRequest;
use App\Models\SubDistrict;
use App\Models\User;
use App\Models\WithdrawRequest;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Deposite', Deposite::sum('amount')),
            Stat::make('Total Expense', Expense::sum('amount')),
            Stat::make('Members', User::count()-1),
            Stat::make('Grant Applications', WithdrawRequest::count()),
            Stat::make('Grant Accepted', WithdrawRequest::where('status',1)->count()),
            Stat::make('Grant Denied', WithdrawRequest::where('status', 2)->count()),
            Stat::make('Districts', District::count()),
            Stat::make('Upazilas', SubDistrict::count()),
           
           
            Stat::make('Subscription Payments', PaymentRequest::count()),
        ];
    }
}
