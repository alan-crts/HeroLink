<?php

namespace App\Http\Controllers;
use App\Models\Reported_incident;

class DashboardController extends Controller
{
    public function index(): \Inertia\Response
    {
        //get reported incidents where incident is in the list of incidents the user has selected and near 50km of the user
        $user = auth()->user();

        $incidents = Reported_incident::with('incident')
            ->whereIn('incident_id', $user->incidents->pluck('id'))
            ->orderBy('created_at', 'desc')
            ->get();


        return \Inertia\Inertia::render('Dashboard/Index', [
            'incidents' => $incidents
        ]);
    }
}
