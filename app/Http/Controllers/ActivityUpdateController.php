<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ActivityService;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ActivityUpdateController extends Controller
{
    protected $activityService;

    public function __construct(ActivityService $activityService)
    {
        $this->activityService = $activityService;
    }

    public function create($activity_id)
    {
        try {
            $activity = $this->activityService->get_activity($activity_id);
            return view('activity_updates.create', compact('activity'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('activities.index')->with('error', 'Activity not found.');
        } catch (\Exception $e) {
            return redirect()->route('activities.index')->with('error', 'Failed to retrieve activity.');
        }
    }

    public function store(Request $request, $activity_id)
    {
        try {
            $validated_data = $request->validate([
                'status' => 'required|in:pending,approved,rejected',
                'remarks' => 'required|min:2|max:255',
            ]);

            $activity = $this->activityService->get_activity($activity_id);
            $this->activityService->create_activity_update($activity, $validated_data['status'], $validated_data['remarks'], auth()->user());

            return redirect()->route('activities.show', $activity_id)->with('success', 'Activity update created successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->errors());
        } catch (ModelNotFoundException $e) {
            return redirect()->route('activities.index')->with('error', 'Activity not found.');
        } catch (\Exception $e) {
            return redirect()->route('activities.index')->with('error', 'Failed to create activity update.');
        }
    }

    public function edit($activity_id, $id)
    {
        try {
            $activity = $this->activityService->get_activity($activity_id);
            $activity_update = $this->activityService->get_activity_update($id);
            return view('activity_updates.edit', compact('activity', 'activity_update'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('activities.index')->with('error', 'Activity update not found.');
        } catch (\Exception $e) {
            return redirect()->route('activities.index')->with('error', 'Failed to retrieve activity update.');
        }
    }

    public function update(Request $request, $activity_id, $id)
    {
        try {
            $validated_data = $request->validate([
                'status' => 'required|in:pending,approved,rejected',
                'remarks' => 'required|min:2|max:255',
            ]);

            $activity_update = $this->activityService->get_activity_update($id);
            $this->activityService->update_activity_update($activity_update, $validated_data['status'], $validated_data['remarks']);

            return redirect()->route('activities.show', $activity_id)->with('success', 'Activity update updated successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->errors());
        } catch (ModelNotFoundException $e) {
            return redirect()->route('activities.index')->with('error', 'Activity update not found.');
        } catch (\Exception $e) {
            return redirect()->route('activities.index')->with('error', 'Failed to update activity update.');
        }
    }

    public function destroy($activity_id, $id)
    {
        try {
            $activity_update = $this->activityService->get_activity_update($id);
            $this->activityService->delete_activity_update($activity_update);

            return redirect()->route('activities.show', $activity_id)->with('success', 'Activity update deleted successfully.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('activities.index')->with('error', 'Activity update not found.');
        } catch (\Exception $e) {
            return redirect()->route('activities.index')->with('error', 'Failed to delete activity update.');
        }
    }
}
