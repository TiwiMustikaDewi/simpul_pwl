<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InternshipGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'leader_id',
    ];

    public function leader(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'leader_id');
    }

    public function members(): HasMany
    {
        return $this->hasMany(InternshipGroupMember::class, 'group_id');
    }

    public function internships(): HasMany
    {
        return $this->hasMany(Internship::class, 'group_id');
    }
}
