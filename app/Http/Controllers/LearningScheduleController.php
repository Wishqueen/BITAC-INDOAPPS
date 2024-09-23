<?php

namespace App\Http\Controllers;

use App\Models\LearningSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LearningScheduleController extends Controller
{
    // Display the calendar page
    public function index()
    {
        return view('learning_schedule.index');
    }

    // API to fetch schedules in JSON format
    public function getEvents()
    {
        $events = LearningSchedule::all();
        $schedules = [];

        foreach ($events as $event) {
            $schedules[] = [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start,
                'end' => $event->end,
                'description' => $event->description
            ];
        }

        return response()->json($schedules);
    }

    // Store a new event
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);

        LearningSchedule::create([
            'title' => $request->title,
            'description' => $request->description,
            'start' => $request->start,
            'end' => $request->end,
        ]);

        return redirect()->back()->with('success', 'Learning schedule added successfully.');
    } 
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:learning_schedules,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start' => 'required|date_format:Y-m-d\TH:i',
            'end' => 'nullable|date_format:Y-m-d\TH:i',
        ]);

        $schedule = LearningSchedule::find($validatedData['id']);
        $schedule->title = $validatedData['title'];
        $schedule->description = $validatedData['description'];
        $schedule->start = $validatedData['start'];
        $schedule->end = $validatedData['end'];
        $schedule->save();

        return redirect()->back()->with('success', 'Schedule updated successfully!');
    }

    
}
