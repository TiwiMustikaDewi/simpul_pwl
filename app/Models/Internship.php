<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Internship extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'company_id',
        'supervisor_id',
        'group_id',
        'type',
        'title',
        'start_date',
        'end_date',
        'status',
        'admin_note',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(Supervisor::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(InternshipGroup::class, 'group_id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(InternshipLog::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(InternshipReport::class);
    }

    public function experience(): HasOne
    {
        return $this->hasOne(InternshipExperience::class);
    }

    public function sidang(): HasOne
    {
        return $this->hasOne(SidangKp::class);
    }
}
