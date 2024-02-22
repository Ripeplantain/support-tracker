<?php

namespace App\Http\Controllers;

use App\Models\Activities;
use App\Models\ActivityUpdates;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ActivityUpdateController extends Controller
{
    public function create($activity_id)
    {
        $activity = Activities::findOrFail($activity_id);
        return view('activity_updates.create', [
            'activity_id' => $activity_id,
            'activity' => $activity
        ]);
    }

    public function store($activity_id)
    {
        try {
            $validated_data = request()->validate([
                'activity_status' => 'required|in:pending,in-progress,completed',
                'remarks' => 'nullable'
            ]);
    
            // Begin a database transaction
            DB::beginTransaction();
    
            $activity = Activities::findOrFail($activity_id);
    
            $activity->status_changed = true;
            $activity->save();
    
            $updateActivity = new ActivityUpdates();
            $updateActivity->activity_id = $activity_id;
            $updateActivity->activity_status = $validated_data['activity_status'];
            $updateActivity->remarks = $validated_data['remarks'];
            $updateActivity->user_id = auth()->user()->id;
            $updateActivity->save();
    
            // Commit the transaction if all operations succeed
            DB::commit();
    
            return redirect()->route('activities.index')->with('success', 'Activity update created successfully.');
        } catch (ValidationException $e) {
            // Rollback the transaction if a validation error occurs
            DB::rollBack();
            return redirect()->back()->withErrors($e->validator->errors());
        } catch (\Exception $e) {
            // Rollback the transaction if any other exception occurs
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create activity update.');
        }
    }
}
