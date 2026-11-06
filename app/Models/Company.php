<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'city',
        'contact_person',
        'phone',
    ];

    public function internships(): HasMany
    {
        return $this->hasMany(Internship::class);
    }

    public function experiences(): HasMany
    {
        return $this->hasMany(InternshipExperience::class);
    }

    public function validatedExperiences(): HasMany
    {
        return $this->hasMany(InternshipExperience::class)->where('is_validated', true);
    }

    /**
     * Get active quota information for the company.
     * Quota rule: Maximum 1 group OR maximum 3 individuals per active period.
     *
     * @return array<string, mixed>
     */
    public function getQuotaInfoAttribute(): array
    {
        // Load active internships (status 'approved' or 'in_progress')
        $activeInternships = $this->internships()
            ->with(['student.user', 'group.members.student.user'])
            ->whereIn('status', ['approved', 'in_progress'])
            ->get();

        $pendingInternships = $this->internships()
            ->with(['student.user', 'group'])
            ->where('status', 'pending')
            ->get();

        $groupInternship = $activeInternships->firstWhere('type', 'group');
        $individualInternships = $activeInternships->where('type', 'individual');
        $individualCount = $individualInternships->count();

        $hasGroup = $groupInternship !== null;
        $isFull = $hasGroup || ($individualCount >= 3);

        $occupants = [];
        if ($hasGroup) {
            $groupName = $groupInternship->group?->name ?? 'Kelompok KP';
            $leaderName = $groupInternship->student?->user?->name ?? 'Ketua';
            $occupants[] = "{$groupName} (Ketua: {$leaderName})";
        } else {
            foreach ($individualInternships as $item) {
                if ($item->student?->user?->name) {
                    $occupants[] = $item->student->user->name;
                }
            }
        }

        $pendingCount = $pendingInternships->count();

        // Determine status text & badges
        if ($hasGroup) {
            $statusLabel = 'Kuota Terpenuhi (1 Kelompok)';
            $badgeVariant = 'danger'; // Red/Full
            $capacityPercent = 100;
        } elseif ($individualCount >= 3) {
            $statusLabel = 'Kuota Terpenuhi (3/3 Individu)';
            $badgeVariant = 'danger';
            $capacityPercent = 100;
        } elseif ($individualCount > 0) {
            $statusLabel = "Terisi {$individualCount}/3 Individu";
            $badgeVariant = 'warning'; // Partial / Amber
            $capacityPercent = (int) round(($individualCount / 3) * 100);
        } else {
            $statusLabel = 'Kuota Tersedia (1 Kelompok / 3 Individu)';
            $badgeVariant = 'success'; // Green / Open
            $capacityPercent = 0;
        }

        return [
            'is_full' => $isFull,
            'has_group' => $hasGroup,
            'group_internship' => $groupInternship,
            'individual_count' => $individualCount,
            'individual_internships' => $individualInternships,
            'remaining_individual' => $hasGroup ? 0 : max(0, 3 - $individualCount),
            'can_accept_individual' => ! $hasGroup && ($individualCount < 3),
            'can_accept_group' => ! $hasGroup && ($individualCount === 0),
            'occupants' => $occupants,
            'pending_count' => $pendingCount,
            'status_label' => $statusLabel,
            'badge_variant' => $badgeVariant,
            'capacity_percent' => $capacityPercent,
        ];
    }
}
