<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ActivityService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class ActivityController extends Controller
{

    protected $activityService;

    public function __construct(ActivityService $activityService)
    {
        $this->activityService = $activityService;
    }

    public function index()
    {
        try {
            $activities = $this->activityService->get_user_activities(auth()->user());
            return view('activities.index', compact('activities'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to retrieve activities.');
        }
    }

    public function create()
    {
        return view('activities.create');
    }

    public function store(Request $request)
    {
        try {
            $validated_data = $request->validate([
                'name' => 'required|min:2|max:100',
            ]);

            $this->activityService->create_activity(auth()->user(), $validated_data);

            return redirect()->route('activities.index')->with('success', 'Activity created successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->errors());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create activity.');
        }
    }

    public function show($id)
    {
        try {
            $activity = $this->activityService->get_activity($id);
            $activity_updates = $this->activityService->get_activity_updates($activity);
            return view('activities.show', compact('activity', 'activity_updates'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('activities.index')->with('error', 'Activity not found.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to retrieve activity details.');
        }
    }

    public function edit($id)
    {
        try {
            $activity = $this->activityService->get_activity($id);
            return view('activities.edit', compact('activity'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('activities.index')->with('error', 'Activity not found.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to retrieve activity for editing.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $activity = $this->activityService->get_activity($id);
            $activity->name = $request->name;
            $activity->save();

            return redirect()->route('activities.index')->with('success', 'Activity updated successfully.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('activities.index')->with('error', 'Activity not found.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update activity.');
        }
    }

    public function destroy($id)
    {
        try {
            $activity = $this->activityService->get_activity($id);
            $activity->delete();

            return redirect()->route('activities.index')->with('success', 'Activity deleted successfully.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('activities.index')->with('error', 'Activity not found.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete activity.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $activity = $this->activityService->get_activity($id);
            $this->activityService->update_activity_status($activity, $request->status);
            $this->activityService->create_activity_update($activity, $request->status, $request->remarks, auth()->user());

            return redirect()->back()->with('success', 'Activity status updated successfully.');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Activity not found.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update activity status.');
        }
    }
}
