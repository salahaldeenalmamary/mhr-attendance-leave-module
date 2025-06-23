<?php

namespace App\Filament\Resources\UsersResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\LeaveRequest;
use App\Models\AttendanceRecord;
use Illuminate\Support\Facades\DB;

class DashboardStats extends BaseWidget
{
    protected static ?string $pollingInterval = null;

    protected function getStats(): array
    {
        return [
          Stat::make('Total Employees', User::count())
    ->description('All registered employees')
    ->icon('heroicon-o-users')
    ->color('primary')
    ->url(route('filament.admin.resources.users.index')),

Stat::make('Verified Emails', User::whereNotNull('email_verified_at')->count())
    ->description('Users with verified emails')
    ->icon('heroicon-o-envelope-open')
    ->color('success')
    ->url(route('filament.admin.resources.users.index', ['tableFilters[email_verified_at][value]' => '1'])),

Stat::make('Leave Requests (Pending)', LeaveRequest::where('status', 'pending')->count())
    ->description('Pending approvals')
    ->icon('heroicon-o-clock')
    ->color('warning')
    ->url(route('filament.admin.resources.leave-requests.index')),

            Stat::make('Verified Emails', User::whereNotNull('email_verified_at')->count())
                ->description('Users with verified emails')
                ->icon('heroicon-o-envelope-open')
                ->color('success'),

            Stat::make('Unverified Emails', User::whereNull('email_verified_at')->count())
                ->description('Users not verified yet')
                ->icon('heroicon-o-envelope')
                ->color('danger'),

            Stat::make('Managers Count', User::whereNotNull('manager_id')->distinct('manager_id')->count('manager_id'))
                ->description('Total managers')
                ->icon('heroicon-o-user-group')
                ->color('info'),

            Stat::make('Unique Departments', User::distinct('department_id')->count('department_id'))
                ->description('Departments represented')
                ->icon('heroicon-o-building-office')
                ->color('gray'),

            Stat::make('Leave Requests (Pending)', LeaveRequest::where('status', 'pending')->count())
                ->description('Pending approvals')
                ->icon('heroicon-o-clock')
                ->color('warning'),

            Stat::make('Leave Requests (Approved)', LeaveRequest::where('status', 'approved')->count())
                ->description('Approved leaves')
                ->icon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('Leave Requests (Rejected)', LeaveRequest::where('status', 'rejected')->count())
                ->description('Rejected leave requests')
                ->icon('heroicon-o-x-circle')
                ->color('danger'),

            Stat::make('Today\'s Attendance', AttendanceRecord::whereDate('attendance_date', now())->count())
                ->description('Records marked today')
                ->icon('heroicon-o-calendar-days')
                ->color('success'),

            Stat::make('Absent Today', AttendanceRecord::whereDate('attendance_date', now())
                    ->where('status', 'absent')->count())
                ->description('Employees marked absent')
                ->icon('heroicon-o-user-minus')
                ->color('danger'),

            Stat::make('Employees On Leave Today', LeaveRequest::whereDate('start_date', '<=', now())
                    ->whereDate('end_date', '>=', now())
                    ->where('status', 'approved')
                    ->count())
                ->description('Currently on leave')
                ->icon('heroicon-o-arrow-up-on-square')
                ->color('warning'),

            Stat::make('With OTP Active', User::whereNotNull('otp')->where('otp_expires_at', '>', now())->count())
                ->description('Users with valid OTP')
                ->icon('heroicon-o-key')
                ->color('blue'),
        ];
    }
}
