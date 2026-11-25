<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InternshipExperience extends Model
{
    use HasFactory;

    protected $fillable = [
        'internship_id',
        'student_id',
        'company_id',
        'position',
        'selection_process',
        'skills_used',
        'experience_review',
        'is_validated',
    ];

    protected function casts(): array
    {
        return [
            'is_validated' => 'boolean',
        ];
    }

    public function internship(): BelongsTo
    {
        return $this->belongsTo(Internship::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
