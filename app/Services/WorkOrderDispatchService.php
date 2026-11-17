<?php

namespace App\Services;

use App\Models\User;
use App\Models\WorkOrder;
use Illuminate\Support\Carbon;

class WorkOrderDispatchService
{
    public function assign(WorkOrder $workOrder, User $technician, ?Carbon $scheduledAt = null): WorkOrder
    {
        $workOrder->forceFill([
            'technician_id' => $technician->id,
            'status' => 'assigned',
            'scheduled_at' => $scheduledAt ?? $workOrder->scheduled_at ?? now()->addHours(4),
        ])->save();

        return $workOrder->refresh();
    }

    public function markInProgress(WorkOrder $workOrder): WorkOrder
    {
        $workOrder->forceFill([
            'status' => 'in_progress',
            'started_at' => $workOrder->started_at ?? now(),
        ])->save();

        return $workOrder->refresh();
    }

    public function complete(WorkOrder $workOrder): WorkOrder
    {
        $workOrder->forceFill([
            'status' => 'completed',
            'completed_at' => now(),
        ])->save();

        return $workOrder->refresh();
    }
}
