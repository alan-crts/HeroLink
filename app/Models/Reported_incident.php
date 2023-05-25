<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reported_incident extends Model
{
    use HasFactory;

    public function incident(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Incident::class);
    }

    protected $fillable = [
        'city',
        'latitude',
        'longitude',
        'incident_id'
    ];
}
