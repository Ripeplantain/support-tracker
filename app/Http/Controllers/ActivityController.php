<?php

namespace App\Http\Controllers;

use App\Models\Activities;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ActivityController extends Controller
{

    public function index()
    {
        try {
            $activities = Activities::with('user', 'assignedTo')->orderBy('created_at', 'desc')->paginate(10);
            return view('activities.index', ['activities' => $activities]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to retrieve activities.');
        }
    }

    public function create()
    {
        $users = User::all()->except(auth()->user()->id);

        return view('activities.create', ['users' => $users]);
    }

    public function store(Request $request)
    {
        try {
            $validated_data = $request->validate([
                'name' => 'required|min:2|max:100',
                'assigned_to' => 'required|exists:users,id'
            ]);

            $activity = new Activities();
            $activity->name = $validated_data['name'];
            $activity->assigned_to = $validated_data['assigned_to'];
            $activity->user_id = auth()->user()->id;
            $activity->save();

            return redirect()->route('activities.index')->with('success', 'Activity created successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->errors());
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', 'Failed to create activity.');
        }
    }

    public function show($id)
    {
        try {
            $activity = Activities::with('user', 'assignedTo', 'activityUpdates')->findOrFail($id);
            return view('activities.show', compact('activity'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('activities.index')->with('error', 'Activity not found.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to retrieve activity details.');
        }
    }

    public function edit($id)
    {
        try {
            $activity = Activities::findOrFail($id);
            $users = User::all()->except(auth()->user()->id);
            return view('activities.edit', ['activity' => $activity, 'users' => $users]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('activities.index')->with('error', 'Activity not found.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to retrieve activity for editing.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $activity = Activities::findOrFail($id);
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
            $activity = Activities::findOrFail($id);
            $activity->delete();

            return redirect()->route('activities.index')->with('success', 'Activity deleted successfully.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('activities.index')->with('error', 'Activity not found.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete activity.');
        }
    }
}
