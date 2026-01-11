<?php

use App\Models\ActivityLog;

function logActivity($action,$targetType,$targetId=null,$desc=null)
{
    ActivityLog::create([
        'user_id'=>auth()->id(),
        'role'=>auth()->user()->role ?? 'system',
        'action'=>$action,
        'target_type'=>$targetType,
        'target_id'=>$targetId,
        'description'=>$desc
    ]);
}
