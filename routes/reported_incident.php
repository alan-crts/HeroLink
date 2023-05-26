<?php

use App\Http\Controllers\ReportedIncidentController;
use Illuminate\Support\Facades\Route;

Route::get('/incident/create', [ReportedIncidentController::class, 'create'])
    ->name('reported_incident.create');

Route::get('/incident', [ReportedIncidentController::class, 'index'])
    ->name('reported_incident.index');

Route::post('/incident', [ReportedIncidentController::class, 'store'])
    ->name('reported_incident.store');

Route::get('/incident/{incident}', [ReportedIncidentController::class, 'show'])
    ->name('reported_incident.show');
