<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InternshipLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'internship_id',
        'date',
        'activity',
        'description',
        'status',
        'supervisor_note',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }

    public function internship(): BelongsTo
    {
        return $this->belongsTo(Internship::class);
    }
}
