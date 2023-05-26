<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\Reported_incident;

class ReportedIncidentController extends Controller
{
    public function index(): \Inertia\Response
    {
        return \Inertia\Inertia::render('ReportedIncident/Index', [
            'incidents' => Reported_incident::with('incident')->orderBy('created_at', 'desc')->get()
        ]);
    }


    public function create(): \Inertia\Response
    {
        return \Inertia\Inertia::render('ReportedIncident/Create', [
            'status' => session('status'),
            'incidents' => Incident::all()->map(function ($incident) {
                return [
                    'id' => $incident->id,
                    'name' => $incident->name
                ];
            }),
        ]);
    }

    public function store(): \Illuminate\Http\RedirectResponse
    {
        $data = request()->validate([
            'city' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-90,90',
            'incident' => 'required|int|exists:incidents,id',
        ]);

        $incident = Incident::find($data['incident']);

        $id = $incident->reportedIncidents()->create([
            'city' => $data['city'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
        ])->id;

        return redirect()->route('reported_incident.show', $id);
    }

    public function show(Reported_incident $incident): \Inertia\Response
    {
        $incident->load('incident');
        $users = $incident
            ->incident
            ->users()
            ->whereRaw('6371 * acos(cos(radians(?)) * cos(radians(users.latitude)) * cos(radians(users.longitude) - radians(?)) + sin(radians(?)) * sin(radians(users.latitude))) <= 50', [$incident->latitude, $incident->longitude, $incident->latitude])
            ->get();
        return \Inertia\Inertia::render('ReportedIncident/Show', [
            'incident' => $incident,
            'users' => $users
        ]);
    }
}
