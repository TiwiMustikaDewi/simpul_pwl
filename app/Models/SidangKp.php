<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SidangKp extends Model
{
    use HasFactory;

    protected $table = 'sidang_kps';

    protected $fillable = [
        'internship_id',
        'proposed_date',
        'sidang_date',
        'room',
        'presentation_file',
        'status',
        'grade',
        'notes',
        'student_notes',
    ];

    protected function casts(): array
    {
        return [
            'proposed_date' => 'datetime',
            'sidang_date' => 'datetime',
        ];
    }

    public function internship(): BelongsTo
    {
        return $this->belongsTo(Internship::class);
    }
}
