<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'npm',
<<<<<<< HEAD
=======
        'faculty',
>>>>>>> af4810d (Update registrasi)
        'major',
        'phone',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function internships(): HasMany
    {
        return $this->hasMany(Internship::class);
    }

    public function ledGroups(): HasMany
    {
        return $this->hasMany(InternshipGroup::class, 'leader_id');
    }

    public function memberGroups(): BelongsToMany
    {
<<<<<<< HEAD
        return $this->belongsToMany(InternshipGroup::class, 'internship_group_members', 'student_id', 'group_id')
            ->withTimestamps();
=======
        return $this->belongsToMany(
            InternshipGroup::class,
            'internship_group_members',
            'student_id',
            'group_id'
        )->withTimestamps();
>>>>>>> af4810d (Update registrasi)
    }

    public function experiences(): HasMany
    {
        return $this->hasMany(InternshipExperience::class);
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> af4810d (Update registrasi)
