<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeaveType;

class LeaveTypeSeeder extends Seeder
{
    public function run(): void
    {
        LeaveType::fromAttributes(
            name: 'إجازة سنوية',
            description: 'إجازة مدفوعة الأجر لأغراض شخصية أو عطلات.',
      
            requiresApproval: true,
            isPaid: true
        )->save();

        LeaveType::fromAttributes(
            name: 'إجازة مرضية',
            description: 'إجازة لأسباب صحية أو مرضية.',
            
            requiresApproval: true,
            isPaid: true
        )->save();

        LeaveType::fromAttributes(
            name: 'إجازة بدون راتب',
            description: 'إجازة غير مدفوعة يمكن الحصول عليها بموافقة الإدارة.',
           
            requiresApproval: true,
            isPaid: false
        )->save();
    }
}
