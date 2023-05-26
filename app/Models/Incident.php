<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;

    public function users(): \Illuminate\Database\Eloquent\Relations\belongsToMany
    {
        return $this->belongsToMany(User::class, "users_incidents", "incident_id", "user_id");
    }

    public function reportedIncidents(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Reported_incident::class);
    }

    protected $fillable = [
        'name'
    ];
}
