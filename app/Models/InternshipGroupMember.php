<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InternshipGroupMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'student_id',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(InternshipGroup::class, 'group_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
