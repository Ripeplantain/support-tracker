<?php

namespace App\Services;

use App\Models\Activities;
use App\Models\ActivityUpdates;

class ActivityService
{
    public function get_user_activities($user)
    {
        return $user->activities;
    }

    public function create_activity($user, $validated_data)
    {
        return $user->activities()->create($validated_data);
    }

    public function update_activity_status($activity, $status)
    {
        $activity->status = $status;
        $activity->save();
    }

    public function create_activity_update($activity, $status, $remarks, $user)
    {
        return $activity->activity_updates()->create([
            'status' => $status,
            'remarks' => $remarks,
            'user_id' => $user->id
        ]);
    }

    public function get_activity($id)
    {
        return Activities::find($id);
    }

    public function get_activity_updates($activity)
    {
        return $activity->activity_updates;
    }

    public function get_activity_update($id)
    {
        return ActivityUpdates::find($id);
    }

    public function update_activity_update($activity_update, $status, $remarks)
    {
        $activity_update->status = $status;
        $activity_update->remarks = $remarks;
        $activity_update->save();
    }

    public function delete_activity_update($activity_update)
    {
        $activity_update->delete();
    }

    public function delete_activity($activity)
    {
        $activity->delete();
    }

    public function get_user_activity_updates($user)
    {
        return $user->activity_updates;
    }
}