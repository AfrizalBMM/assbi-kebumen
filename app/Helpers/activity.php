<?php

use App\Models\ActivityLog;

function logActivity($action, $target = null, $description = null)
{
    ActivityLog::create([
        'user_id' => auth()->id(),
        'role' => auth()->user()->role ?? 'system',
        'action' => $action,
        'target_type' => $target ? get_class($target) : null,
        'target_id' => $target->id ?? null,
        'description' => $description,
        'ip_address' => request()->ip()
    ]);
}

